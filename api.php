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

    $sm->set_table_name();

    $sm->set_resolution_name();

    $sm->sid = $_GET['sid'];
    $sm->type = $_GET['type'];
    $sm->episode = $_GET['episode'];

    $sm->preprocesing( $db );

    $type = $sm->type;
    $title = $sm->title;
    $shell_resolution = $sm->shell_resolution;

    unset($sm);

    function get_system_call( $cmd ) {
        $last_line = exec( $cmd, $return_var );

        return [ 'last_line' => $last_line, 'return_var' => $return_var ];
    }

    @chdir( $client_path );

    switch( $type ) {
        case 'drama_add' :
            break;
        case 'tv_add' :
            break;
        case 'drama_del' :
            break;
        case 'tv_del' :
            break;
/*
        case 'drama_start' :
            $sr = get_system_call("java -jar Client.jar start drama \"{$title}\" {$shell_resolution}" );
            break;
        case 'enter_start' :
            $sr = get_system_call("java -jar Client.jar start enter \"{$title}\" {$shell_resolution}" );
            break;
        case 'tv_start' :
            $sr = get_system_call("java -jar Client.jar start tv \"{$title}\" {$shell_resolution}" );
            break;
        case 'drama_stop' :
            $sr = get_system_call("java -jar Client.jar stop drama \"{$title}\" {$shell_resolution}" );
            break;
        case 'enter_stop' :
            $sr = get_system_call("java -jar Client.jar stop enter \"{$title}\" {$shell_resolution}" );
            break;
        case 'tv_stop' :
            $sr = get_system_call("java -jar Client.jar stop tv \"{$title}\" {$shell_resolution}" );
            break;
*/
        case 'drama_search' :
            break;
        case 'tv_search' :
            break;
        case 'enter_search' :
            break;
        default :
            break;
    }

    echo $sr['last_line'];

    @chdir( $http_path );

    include_once("./php_footer.php");
