<?php
    include_once ("./config.php");
    session_start();

    switch( basename($_SERVER['PHP_SELF']) ) {
        case 'login.php' :
            break;

        case 'log.php' :
            if ( $_SESSION['sm-auth'] !== true && $manager_id != '' ) {
                HEADER("Location:./login.php");
                exit;
            }

            $title = '8. 금일 Showdown 로그';
            $showdown_log_file = $client_path."/ShowDown.log";
            break;

        default :
            if ( $_SESSION['sm-auth'] !== true
                && $manager_id != ''
                && !( basename($_SERVER['PHP_SELF']) == 'api.php' && $_GET['type'] == 'auth' )
            ) {
                HEADER("Location:./login.php");
                exit;
            }
            include_once ("./ShowdownManager.php");

            $sqlite_db = $client_path."/SQLDB.db";

            $db = new PDO('sqlite:' . $sqlite_db );
            $db->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);

            $sm = new ShowdownManager\SM( $http_path, $client_path, $start_page, $JAVA_HOME );

            $_GET['status'] = (!$_GET['status']) ? $start_page : $_GET['status'];
            switch( $_GET['status'] ) {
                case 1 :
                default :
                    $title = '1. 드라마(미방영)';
                    $genre_table_name = 'DRAMA_LIST';
                    $genre_episode_table_name = 'DRAMA_EPISODE';
                    $genre_where = "STATUS = 1";
                    $genre = "drama";
                    break;
                case 2 :
                    $title = '2. 드라마(방영중)';
                    $genre_table_name = 'DRAMA_LIST';
                    $genre_episode_table_name = 'DRAMA_EPISODE';
                    $genre_where = "STATUS = 2";
                    $genre = "drama";
                    break;
                case 3 :
                    $title = '3. 드라마(종방영)';
                    $genre_table_name = 'DRAMA_LIST';
                    $genre_episode_table_name = 'DRAMA_EPISODE';
                    $genre_where = "STATUS = 3";
                    $genre = "drama";
                    break;
                case 4 :
                case 5 :
                    $genre_table_name = 'ENTER_LIST';
                    $genre_episode_table_name = 'ENTER_EPISODE';
                    if ( $merge_tv_enter == 'Y') {
                        $title = '4+5. 예능';
                        $genre_where = "STATUS = 1 OR STATUS = 2";
                    } else if ( $_GET['status'] == 4 ) {
                        $title = '4. 예능(방영전)';
                        $genre_where = "STATUS = 1";
                    } else {
                        $title = '5. 예능(방영중)';
                        $genre_where = "STATUS = 2";
                    }
                    $genre = "enter";
                    break;
                case 6 :
                    $title = '6. 예능(방영종료)';
                    $genre_table_name = 'ENTER_LIST';
                    $genre_episode_table_name = 'ENTER_EPISODE';
                    $genre_where = "STATUS = 3";
                    $genre = "enter";
                    break;
                case 7 :
                case 8 :
                    $genre_table_name = 'TV_LIST';
                    $genre_episode_table_name = 'TV_EPISODE';
                    if ( $merge_tv_enter == 'Y') {
                        $title = '7+8. TV';
                        $genre_where = "STATUS = 1 OR STATUS = 2";
                    } else if ( $_GET['status'] == 7 ) {
                        $title = '7. TV(방영전)';
                        $genre_where = "STATUS = 1";
                    } else {
                        $title = '8. TV(방영중)';
                        $genre_where = "STATUS = 2";
                    }
                    $genre = "tv";
                    break;
                case 9 :
                    $title = '9. TV(방영종료)';
                    $genre_table_name = 'TV_LIST';
                    $genre_episode_table_name = 'TV_EPISODE';
                    $genre_where = "STATUS = 3";
                    $genre = "tv";
                    break;
            }

            // 방송 목록
            $result = $sm->getOnAirList( $db, $genre_table_name, $genre_where);
            break;
    }
