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

    public $showdown_url;
    public $showdown_port;

    private $db;
    private $sock;

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
    public $name;
    public $episode;

    function __construct( $http_path, $client_path, $start_page, $java_home, $showdown_url, $showdown_port )
    {
        $this->http_path = $http_path;
        $this->client_path = $client_path;
        $this->start_page = $start_page;

        $this->java_home = $java_home;
        $this->path = "{$java_home}/bin:/usr/local/bin:/usr/bin:/bin";

        putenv("JAVA_HOME=$this->java_home");
        putenv("PATH=$this->path");
        putenv("LANG=ko_KR.UTF-8");

        $this->showdown_url = $showdown_url;
        $this->showdown_port = $showdown_port;
    }

    public function connect_socket() {
        if (($this->sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error());
        }

        if ($result = socket_connect($this->sock, $this->showdown_url, $this->showdown_port ) === false) {
            echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($this->sock));
        }
    }

    public function close_socket() {
        if ( $this->sock ) socket_close( $this->sock );
    }

    public function get_list_socket( $type , $status ) {
        $command = '{ "request": "list", "type":"' . $type . '", "status": "' . $status . '" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);

        $resonse = json_decode( $resonse, true );
        return $resonse['args'];
    }

    public function get_search_socket( $_keyword ) {
        $command = '{ "request": "search", "type":"' . strtoupper($this->genre) . '", "keyword" : "' . $_keyword . '" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);
        $resonse = json_decode( $resonse, true );

        return $resonse;
    }

    public function add_program_socket( $_keyword ) {
        $command = '{ "request": "add", "type":"' . strtoupper($this->genre) . '", "keyword" : "' . $_keyword . '" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);

        return $resonse;
    }

    public function del_program_socket( ) {
        $command = '{ "request": "delete", "type":"' . strtoupper($this->genre) . '", "sid": "' . $this->sid . '", "name" : "' . $this->name . '" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);

        return $resonse;
    }

    public function set_rename_socket( $_new_name ) {
        $command = '{ "request": "rename", "type":"' . strtoupper($this->genre) . '", "sid": "' . $this->sid . '", "name" : "' . $this->name . '", "new_name" : "' . $_new_name . '" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);
        $resonse = json_decode( $resonse, true );

        return $resonse;
    }

    public function set_all_monitor_socket() {
        $command = '{ "request": "monitor", "type":"' . strtoupper($this->genre) . '", "sid": "' . $this->sid . '", "quality":"' . $this->resolution. '" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);
        $resonse = json_decode( $resonse, true );

        return $resonse;
    }

    public function set_all_download_socket( $_completed = 'Y' ) {
        $command = '{ "request": "all_episode_update", "type":"' . strtoupper($this->genre) . '", "sid": "' . $this->sid . '", "quality":"' . $this->resolution. '", "name" : "' . $this->name . '", "complete" : "' . $_completed. '" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);
        $resonse = json_decode( $resonse, true );

        return $resonse;
    }

    public function set_download_socket( $_completed = 'Y' ) {
        $command = '{ "request": "episode_update", "type":"' . strtoupper($this->genre) . '", "sid": "' . $this->sid . '", "quality":"' . $this->resolution. '", "name" : "' . $this->name . '", "complete" : "' . $_completed. '", "episode" : "' . $this->episode . '" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);
        $resonse = json_decode( $resonse, true );

        return $resonse;
    }


    public function get_list_episode_socket(  ) {
        // 720p 정보
        $command = '{ "request": "episode", "type":"' . strtoupper($this->genre) . '", "sid": "' . $this->sid . '", "quality":"720P" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);
        $resonse = json_decode( $resonse, true );
        $resonse_720p = $resonse['args'];

        // 1080p 정보
        $command = '{ "request": "episode", "type":"' . strtoupper($this->genre) . '", "sid": "' . $this->sid . '", "quality":"1080P" }';
        socket_write($this->sock, $command."\n", strlen($command) + 1);
        $resonse = socket_read($this->sock,100000, PHP_NORMAL_READ);
        $resonse = json_decode( $resonse, true );
        $resonse_1080p = $resonse['args'];

        // 정보 merge
        $result = [];
        foreach( $resonse_720p as $v ) {
            if ( !$result['name'] ) $result['name'] = $v['name'];
            $result['episode'][ $v['episode'] ][ '720-A' ] = $v['air_date'];
            $result['episode'][ $v['episode'] ][ '720-E' ] = $v['episode'];
            $result['episode'][ $v['episode'] ][ '720-M' ] = $v['monitor'];
            $result['episode'][ $v['episode'] ][ '720-D' ] = $v['download'];
            $result['episode'][ $v['episode'] ][ '720-C' ] = $v['complete'];
        }

        foreach( $resonse_1080p as $v ) {
            $result['episode'][ $v['episode'] ][ '1080-A' ] = $v['air_date'];
            $result['episode'][ $v['episode'] ][ '1080-E' ] = $v['episode'];
            $result['episode'][ $v['episode'] ][ '1080-M' ] = $v['monitor'];
            $result['episode'][ $v['episode'] ][ '1080-D' ] = $v['download'];
            $result['episode'][ $v['episode'] ][ '1080-C' ] = $v['complete'];
        }

        return $result;
    }
}