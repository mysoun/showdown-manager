<?php
namespace ShowdownManager;

//use PDO;

class SM
{
    public $http_path;
    public $client_path;
    public $start_page;
    public $java_home;
    public $path;

    private $db;

    public $genre;
    public $resolution;
    public $table_name;
    public $ep_table_name;
    public $resolution_field;
    public $shell_resolution;
    public $db_quality;

    public $sid;
    public $type;
    public $title;
    public $episode;

    function __construct( $http_path, $client_path, $start_page, $java_home )
    {
        $this->http_path = $http_path;
        $this->client_path = $client_path;
        $this->start_page = $start_page;

        $this->java_home = $java_home;
        $this->path = "{$java_home}/bin:/usr/local/bin:/usr/bin:/bin";

        putenv("JAVA_HOME=$this->java_home");
        putenv("PATH=$this->path");
        putenv("LANG=ko_KR.UTF-8");
    }

    function __destruct()
    {
        unset($this);
    }

    public function getOnAirList( &$db, $genre_table_name, $genre_where ) {
        $result = $db->query("SELECT * FROM {$genre_table_name} WHERE {$genre_where} ORDER BY NAME");

        return $result;
    }

    public function monitor_info( &$db, $episode_table_name, $genre, $sid, $hd, $fhd ) {
        $result = [];

        $result_hd_ep = $db->query("SELECT COUNT(EPISODE) as EP_CNT FROM {$episode_table_name} WHERE SID = {$sid} AND QUALITY = '720P'");
        $result_hd_ep_cnt = $result_hd_ep->fetch();

        $result_hd_ep = $db->query("SELECT COUNT(EPISODE) as EP_CNT FROM {$episode_table_name} WHERE SID = {$sid} AND QUALITY = '720P' AND DOWNLOAD = 'Y'");
        $result_hd_ep_down_cnt = $result_hd_ep->fetch();

        $result['hd'] = ( $hd == "Y" ) ? "<button class='btn-episode ps-setting' sid='{$sid}' genre='{$genre}' resolution='720p'>{$result_hd_ep_down_cnt['EP_CNT']}/{$result_hd_ep_cnt['EP_CNT']}</button>" : "";

        $result_fhd_ep = $db->query("SELECT COUNT(EPISODE) as EP_CNT FROM {$episode_table_name} WHERE SID = {$sid} AND QUALITY = '1080P'");
        $result_fhd_ep_cnt = $result_fhd_ep->fetch();

        $result_fhd_ep = $db->query("SELECT COUNT(EPISODE) as EP_CNT FROM {$episode_table_name} WHERE SID = {$sid} AND QUALITY = '1080P' AND DOWNLOAD = 'Y'");
        $result_fhd_ep_down_cnt = $result_fhd_ep->fetch();

        $result['fhd'] = ( $fhd == "Y" ) ? "<button class='btn-episode ps-setting' sid='{$sid}' genre='{$genre}' resolution='1080p'>{$result_fhd_ep_down_cnt['EP_CNT']}/{$result_fhd_ep_cnt['EP_CNT']}</button>" : "";

        return $result;
    }

    public function get_system_call( $cmd ) {
        $last_line = exec( $cmd, $return_var );

        return [ 'last_line' => $last_line, 'return_var' => $return_var ];
    }

    public function set_table_name() {
        switch( $this->genre ) {
            case 'drama' :
                $this->table_name = 'DRAMA_LIST';
                $this->ep_table_name = 'DRAMA_EPISODE';
                break;
            case 'tv' :
                $this->table_name = 'TV_LIST';
                $this->ep_table_name = 'TV_EPISODE';
                break;

            case 'enter' :
                $this->table_name = 'ENTER_LIST';
                $this->ep_table_name = 'ENTER_EPISODE';
                break;

            default :
                exit;
        }
    }

    public function set_resolution_name() {
        switch( $this->resolution ) {
            case '720p' :
            case '720P' :
                $this->resolution_field = 'MONITOR_HD';
                $this->shell_resolution = '720';
                $this->db_quality = '720P';
                break;
            case '1080p' :
            case '1080P' :
                $this->resolution_field = 'MONITOR_FHD';
                $this->shell_resolution = '1080';
                $this->db_quality = '1080P';
                break;

            default :
        }
    }

    public function preprocesing( &$db ) {
        switch( $this->type ) {
            case 'monitor' :
                $result = $db->query( "SELECT * FROM {$this->table_name} WHERE SID = {$this->sid}");
                $result = $result->fetch();
                if ( $result[$this->resolution_field] == 'Y' ) {
                    // 모니터링 스탑
                    $db->query ( "UPDATE {$this->table_name} SET {$this->resolution_field} = 'N' WHERE SID = {$this->sid}");
                } else {
                    // 모니터링 스타트
                    $db->query ( "UPDATE {$this->table_name} SET {$this->resolution_field} = 'Y' WHERE SID = {$this->sid}");
                }
                break;
            case 'all_episode_monitor_on' :
                $query = "UPDATE {$this->ep_table_name} SET MONITOR = 'Y' WHERE SID = :sid AND QUALITY = :quality";
                $stmt = $db->prepare($query);

                $stmt->bindParam(':sid', $this->sid);
                $stmt->bindParam(':quality', $this->db_quality);

                $stmt->execute();
                break;
            case 'all_episode_monitor_off' :
                $query = "UPDATE {$this->ep_table_name} SET MONITOR = 'N', DOWNLOAD = 'N', COMPLETE = 'N', PROCESS = 'N', DEL = 'N' WHERE SID = :sid AND QUALITY = :quality";
                $stmt = $db->prepare($query);

                $stmt->bindParam(':sid', $this->sid);
                $stmt->bindParam(':quality', $this->db_quality);

                $stmt->execute();

                break;
            case 'episode_monitor_on_off' :
                $result = $db->query("SELECT * FROM {$this->ep_table_name} WHERE SID = {$this->sid} AND EPISODE = '{$this->episode}' AND QUALITY = '{$this->db_quality}'");

                $result = $result->fetch();

                if ( $result['MONITOR'] == 'Y' ) {
                    $query = "UPDATE {$this->ep_table_name} SET MONITOR = 'N' WHERE SID = :sid AND EPISODE = '{$this->episode}' AND QUALITY = :quality";
                } else {
                    $query = "UPDATE {$this->ep_table_name} SET MONITOR = 'Y' WHERE SID = :sid AND EPISODE = '{$this->episode}' AND QUALITY = :quality";
                }

                $stmt = $db->prepare($query);

                $stmt->bindParam(':sid', $this->sid);
                $stmt->bindParam(':quality', $this->db_quality);

                $stmt->execute();
                break;

            case 'all_episode_download_on' :
                $query = "UPDATE {$this->ep_table_name} SET DOWNLOAD = 'Y', COMPLETE = 'Y', PROCESS = 'Y', DEL = 'Y' WHERE SID = :sid AND QUALITY = :quality";
                $stmt = $db->prepare($query);

                $stmt->bindParam(':sid', $this->sid);
                $stmt->bindParam(':quality', $this->db_quality);

                $stmt->execute();
                break;
            case 'all_episode_download_off' :
                $query = "UPDATE {$this->ep_table_name} SET DOWNLOAD = 'N', COMPLETE = 'N', PROCESS = 'N', DEL = 'N' WHERE SID = :sid AND QUALITY = :quality";
                $stmt = $db->prepare($query);

                $stmt->bindParam(':sid', $this->sid);
                $stmt->bindParam(':quality', $this->db_quality);

                $stmt->execute();

                break;

            case 'episode_download_on_off' :
                $result = $db->query("SELECT * FROM {$this->ep_table_name} WHERE SID = {$this->sid} AND EPISODE = '{$this->episode}' AND QUALITY = '{$this->db_quality}'");

                $result = $result->fetch();

                if ( $result['DOWNLOAD'] == 'Y' ) {
                    $query = "UPDATE {$this->ep_table_name} SET DOWNLOAD = 'N', COMPLETE = 'N', PROCESS = 'N', DEL = 'N' WHERE SID = :sid AND EPISODE = '{$this->episode}' AND QUALITY = :quality";
                } else {
                    $query = "UPDATE {$this->ep_table_name} SET DOWNLOAD = 'Y', COMPLETE = 'Y', PROCESS = 'Y', DEL = 'Y' WHERE SID = :sid AND EPISODE = '{$this->episode}' AND QUALITY = :quality";
                }

                $stmt = $db->prepare($query);

                $stmt->bindParam(':sid', $this->sid);
                $stmt->bindParam(':quality', $this->db_quality);

                $stmt->execute();
                break;
        }
    }

    public function get_episode_list( &$db ) {
        $result = $db->query( "SELECT * FROM {$this->table_name} WHERE SID = {$this->sid}");
        $result = $result->fetch();

        $this->title = $result['NAME'];

        $result_ep = $db->query("SELECT * FROM {$this->ep_table_name} WHERE SID = {$this->sid}");

        $episode_rework = [];

        foreach ( $result_ep as $v ) {
            $ep_no = (int)substr( $v['EPISODE'], 1, 4);

            if ( $v['QUALITY'] == '720P' ) {
                $episode_rework[ $ep_no ]['720-E'] = $v['EPISODE'];
                $episode_rework[ $ep_no ]['720-A'] = $v['AIR_DATE'];
                $episode_rework[ $ep_no ]['720-M'] = $v['MONITOR'];
                $episode_rework[ $ep_no ]['720-D'] = $v['DOWNLOAD'];
                $episode_rework[ $ep_no ]['720-C'] = $v['COMPLETE'];
            } elseif( $v['QUALITY'] == '1080P' ) {
                $episode_rework[ $ep_no ]['1080-E'] = $v['EPISODE'];
                $episode_rework[ $ep_no ]['1080-A'] = $v['AIR_DATE'];
                $episode_rework[ $ep_no ]['1080-M'] = $v['MONITOR'];
                $episode_rework[ $ep_no ]['1080-D'] = $v['DOWNLOAD'];
                $episode_rework[ $ep_no ]['1080-C'] = $v['COMPLETE'];
            }
        }

        ksort($episode_rework);
        return $episode_rework;
    }
}