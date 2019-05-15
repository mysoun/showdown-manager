<?php
    include_once ("./config.php");
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
            $title = '4. 예능(방영중)';
            $genre_table_name = 'ENTER_LIST';
            $genre_episode_table_name = 'ENTER_EPISODE';
            $genre_where = "STATUS = 1 OR STATUS = 2";
            $genre = "enter";
            break;
        case 5 :
            $title = '5. 예능(방영종료)';
            $genre_table_name = 'ENTER_LIST';
            $genre_episode_table_name = 'ENTER_EPISODE';
            $genre_where = "STATUS = 3";
            $genre = "enter";
            break;
        case 6 :
            $title = '6. TV(방영중)';
            $genre_table_name = 'TV_LIST';
            $genre_episode_table_name = 'TV_EPISODE';
            $genre_where = "STATUS = 1 OR STATUS = 2";
            $genre = "tv";
            break;
        case 7 :
            $title = '7. TV(방영종료)';
            $genre_table_name = 'TV_LIST';
            $genre_episode_table_name = 'TV_EPISODE';
            $genre_where = "STATUS = 3";
            $genre = "tv";
            break;
    }

    // 방송 목록
    $result = $sm->getOnAirList( $db, $genre_table_name, $genre_where);