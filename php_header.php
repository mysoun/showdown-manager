<?php
    include_once ("./config.php");

    $sqlite_db = $client_path."/SQLDB.db";
    $PATH = "$JAVA_HOME/bin:/usr/local/bin:/usr/bin:/bin";

    $db = new PDO('sqlite:' . $sqlite_db );
    $db->setAttribute(PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION);
    //$db->query("PRAGMA synchronous = OFF");

    function drama_monitor_info( $db, $sid, $hd, $fhd ) {
        $result = [];

        $result_hd_ep = $db->query("SELECT COUNT(EPISODE) as EP_CNT FROM DRAMA_EPISODE WHERE SID = {$sid} AND QUALITY = '720P'");
        $result_hd_ep_cnt = $result_hd_ep->fetch();

        $result_hd_ep = $db->query("SELECT COUNT(EPISODE) as EP_CNT FROM DRAMA_EPISODE WHERE SID = {$sid} AND QUALITY = '720P' AND DOWNLOAD = 'Y'");
        $result_hd_ep_down_cnt = $result_hd_ep->fetch();

        $result['hd'] = ( $hd == "Y" ) ? "<button class='btn-episode ps-setting' sid='{$sid}' genre='drama' resolution='720p'>{$result_hd_ep_down_cnt['EP_CNT']}/{$result_hd_ep_cnt['EP_CNT']}</button>" : "";

        $result_fhd_ep = $db->query("SELECT COUNT(EPISODE) as EP_CNT FROM DRAMA_EPISODE WHERE SID = {$sid} AND QUALITY = '1080P'");
        $result_fhd_ep_cnt = $result_fhd_ep->fetch();

        $result_fhd_ep = $db->query("SELECT COUNT(EPISODE) as EP_CNT FROM DRAMA_EPISODE WHERE SID = {$sid} AND QUALITY = '1080P' AND DOWNLOAD = 'Y'");
        $result_fhd_ep_down_cnt = $result_fhd_ep->fetch();

        $result['fhd'] = ( $fhd == "Y" ) ? "<button class='btn-episode ps-setting' sid='{$sid}' genre='drama' resolution='1080p'>{$result_fhd_ep_down_cnt['EP_CNT']}/{$result_fhd_ep_cnt['EP_CNT']}</button>" : "";

        return $result;
    }

    function get_system_call( $cmd ) {
        $last_line = exec( $cmd, $return_var );

        return [ 'last_line' => $last_line, 'return_var' => $return_var ];
    }