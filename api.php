<?php
    include_once("./php_header.php");
    switch( $_GET['type'] ) {
        case 'auth' :
            if ( $manager_id == trim($_POST['username']) && $manager_passwd == trim($_POST['password']) ) {
                $_SESSION['sm-auth'] = true;
                echo 'true';
            } else {
                echo 'false';
            }
            exit;
            break;
        case 'logout' :
            unset($_SESSION['sm-auth']);
            HEADER("Location:./login.php");
            exit;
            break;
    }

    $sm->genre = $_GET['genre'];
    $sm->resolution = $_GET['resolution'];

    $sm->sid = $_GET['sid'];
    $sm->type = $_GET['type'];
    $sm->episode = $_GET['episode'];
    $sm->name = $_GET['name'];

    $type = $sm->type;
    $title = $sm->title;

    switch( $type ) {
        case 'search' :
            $_GET['keyword'] = trim( $_GET['keyword'] );

            if ( $_GET['keyword'] != '' ) $json_result = $sm->get_search_socket( $_GET['keyword']);
            echo json_encode($json_result);

            break;
        case 'rename' :
            $_GET['new_name'] = trim( $_GET['new_name'] );

            if ( $_GET['new_name'] != '' ) $sm->set_rename_socket( $_GET['new_name']);
            break;

        case 'monitor' :
                $sm->set_all_monitor_socket();
            break;

        case 'all_episode_download_on' :
                $sm->set_all_download_socket( 'Y');
            break;

        case 'all_episode_download_off' :
                $sm->set_all_download_socket( 'N');
            break;

        case 'episode_download_on_off' :
                if ( $_GET['complete'] == 'Y' ) $sm->set_download_socket( 'N' );
                else  $sm->set_download_socket( 'Y' );
            break;

        case 'add' :
            $_GET['keyword'] = trim( $_GET['keyword'] );

            if ( $_GET['keyword'] != '' ) $json_result = $sm->add_program_socket( $_GET['keyword']);
            echo json_encode($json_result);
            break;

        case 'delete' :
            $sm->del_program_socket();
            break;

        default :
            break;
    }

    include_once("./php_footer.php");
