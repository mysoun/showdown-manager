<?php
    $http_path = ""; // Showdown Manager 설치되어 있는 디렉토리 ex) /volume1/web/showdown-manager
    $client_path = ""; // Showdown 설치되어 있는 디렉토리 ex) /volume1/showdown
    $merge_tv_enter = 'N'; // Y or N, Showdown 1.52에 추가된 TV/Enter의 방영 예정을 합쳐서 보여줄지 나눠줄지 선택하는 부분
    $start_page = 2; // 메뉴 번호 1~10

    // Showdown Manager 접속 ID/Passwd 설정. 미설정시 인증 Pass
    $manager_id = '';
    $manager_passwd = '';

    // 시놀로지의 경우 폴더 권한에 자식 폴더 및 파일 포함 http 권한 설정 필요
    // Linux 기반사 용자의 경우 showdown의 실행 권한을 showdown-manager web 실행 권한(ex. http)과 showdown 파일들의 소유자를 같이 맞출 필요가 있음
    $show_log_menu = 'Y';

    $JAVA_HOME = "/var/packages/Java8/target/j2sdk-image/jre"; // 시스템의 $JAVA_HOME 위치

    ## 이 이하는 수정하지 마세요.
    $showdown_min_ver = 'v1.52(Beta)'; // Showdown 필요 버전
    $showdown_manager_ver = 'v0.6.3'; // Showdown Manager 버전

    ## Docker용 환경 설정
    if ( $_SERVER['WEB_DOCUMENT_ROOT']) $http_path = $_SERVER['WEB_DOCUMENT_ROOT'];
    if ( $_SERVER['SHOWDOWN_PATH']) $client_path = $_SERVER['SHOWDOWN_PATH'];
    if ( $_SERVER['SHOWDOWN_START_PAGE'] ) $start_page = $_SERVER['SHOWDOWN_START_PAGE'];
    if ( $_SERVER['SHOWDOWN_LOG_VIEW'] ) $show_log_menu = $_SERVER['SHOWDOWN_LOG_VIEW'];
    if ( $_SERVER['SHOWDOWN_MERGE_MENU'] ) $merge_tv_enter = $_SERVER['SHOWDOWN_MERGE_MENU'];
    if ( $_SERVER['SHOWDOWN_MANAGER_ID'] ) $manager_id = $_SERVER['SHOWDOWN_MANAGER_ID'];
    if ( $_SERVER['SHOWDOWN_MANAGER_PASSWD'] ) $manager_passwd = $_SERVER['SHOWDOWN_MANAGER_PASSWD'];