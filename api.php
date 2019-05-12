<?php
    include_once("./php_header.php");

    putenv("JAVA_HOME=$JAVA_HOME");
    putenv("PATH=$PATH");
    putenv("LANG=ko_KR.UTF-8");

    @chdir( $client_path );

    switch( $_GET['genre'] ) {
        case 'drama' :
            $table_name = 'DRAMA_LIST';
            $ep_table_name = 'DRAMA_EPISODE';
            break;
        case 'tv' :
        case 'enter' :
            $table_name = 'TV_LIST';
            $ep_table_name = 'TV_EPISODE';
            break;

        default :
            exit;
    }

    switch( $_GET['resolution'] ) {
        case '720p' :
        case '720P' :
            $resolution_field = 'MONITOR_HD';
            $shell_resolution = '720';
            $db_quality = '720P';
            break;
        case '1080p' :
        case '1080P' :
            $resolution_field = 'MONITOR_FHD';
            $shell_resolution = '1080';
            $db_quality = '1080P';
            break;

        default :
//            exit;
    }

    $sid = $_GET['sid'];

    switch( $_GET['type'] ) {
        case 'monitor' :
                $result = $db->query( "SELECT * FROM {$table_name} WHERE SID = {$sid}");
                $result = $result->fetch();
                if ( $result[$resolution_field] == 'Y' ) {
                    $_GET['type'] = 'drama_stop';
                } else {
                    $_GET['type'] = 'drama_start';
                }
                $_GET['title'] = $result['NAME'];
            break;
        case 'all_episode_monitor_on' :
            $query = "UPDATE {$ep_table_name} SET MONITOR = 'Y' WHERE SID = :sid AND QUALITY = :quality";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':sid', $sid);
            $stmt->bindParam(':quality', $db_quality);

            $stmt->execute();
            break;
        case 'all_episode_monitor_off' :
            $query = "UPDATE {$ep_table_name} SET MONITOR = 'N', DOWNLOAD = 'N', COMPLETE = 'N', PROCESS = 'N', DEL = 'N' WHERE SID = :sid AND QUALITY = :quality";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':sid', $sid);
            $stmt->bindParam(':quality', $db_quality);

            $stmt->execute();

            break;
        case 'episode_monitor_on_off' :
            $episode = $_GET['episode'];
            $result = $db->query("SELECT * FROM {$ep_table_name} WHERE SID = {$sid} AND EPISODE = '{$episode}' AND QUALITY = '{$db_quality}'");

            $result = $result->fetch();

            if ( $result['MONITOR'] == 'Y' ) {
                $query = "UPDATE {$ep_table_name} SET MONITOR = 'N' WHERE SID = :sid AND EPISODE = '{$episode}' AND QUALITY = :quality";
            } else {
                $query = "UPDATE {$ep_table_name} SET MONITOR = 'Y' WHERE SID = :sid AND EPISODE = '{$episode}' AND QUALITY = :quality";
            }


            $stmt = $db->prepare($query);

            $stmt->bindParam(':sid', $sid);
            $stmt->bindParam(':quality', $db_quality);

            $stmt->execute();
            break;

        case 'all_episode_download_on' :
            $query = "UPDATE {$ep_table_name} SET DOWNLOAD = 'Y', COMPLETE = 'Y', PROCESS = 'Y', DEL = 'Y' WHERE SID = :sid AND QUALITY = :quality";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':sid', $sid);
            $stmt->bindParam(':quality', $db_quality);

            $stmt->execute();
            break;
        case 'all_episode_download_off' :
            $query = "UPDATE {$ep_table_name} SET DOWNLOAD = 'N', COMPLETE = 'N', PROCESS = 'N', DEL = 'N' WHERE SID = :sid AND QUALITY = :quality";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':sid', $sid);
            $stmt->bindParam(':quality', $db_quality);

            $stmt->execute();

            break;

        case 'episode_download_on_off' :
            $episode = $_GET['episode'];
            $result = $db->query("SELECT * FROM {$ep_table_name} WHERE SID = {$sid} AND EPISODE = '{$episode}' AND QUALITY = '{$db_quality}'");

            $result = $result->fetch();

            if ( $result['DOWNLOAD'] == 'Y' ) {
                $query = "UPDATE {$ep_table_name} SET DOWNLOAD = 'N', COMPLETE = 'N', PROCESS = 'N', DEL = 'N' WHERE SID = :sid AND EPISODE = '{$episode}' AND QUALITY = :quality";
            } else {
                $query = "UPDATE {$ep_table_name} SET DOWNLOAD = 'Y', COMPLETE = 'Y', PROCESS = 'Y', DEL = 'Y' WHERE SID = :sid AND EPISODE = '{$episode}' AND QUALITY = :quality";
            }


            $stmt = $db->prepare($query);

            $stmt->bindParam(':sid', $sid);
            $stmt->bindParam(':quality', $db_quality);

            $stmt->execute();
            break;
    }

    switch( $_GET['type'] ) {
        case 'drama_add' :
            break;
        case 'tv_add' :
            break;
        case 'drama_del' :
            break;
        case 'tv_del' :
            break;
        case 'drama_start' :
            $sr = get_system_call("java -jar Client.jar start drama \"{$_GET['title']}\" {$shell_resolution}" );
            break;
        case 'tv_start' :
            break;
        case 'drama_stop' :
            $sr = get_system_call("java -jar Client.jar stop drama \"{$_GET['title']}\" {$shell_resolution}" );
            break;
        case 'tv_stop' :
            break;
        case 'drama_search' :
            break;
        case 'tv_search' :
            break;
        case 'enter_search' :
            break;
        default :
//            $sr = get_system_call("java -jar Client.jar stop " );

            break;
    }

    echo $sr['last_line'];

    @chdir( $http_path );
    include_once("./php_footer.php");