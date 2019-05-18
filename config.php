<?php
    $http_path = ""; // Showdown Manager 설치되어 있는 디렉토리 ex) /volume1/web/showdown-manager
    $client_path = ""; // Showdown 설치되어 있는 디렉토리 ex) /volume1/showdown
    $start_page = 2; // 메뉴 번호 1~8
    $show_log_menu = 'N'; // Y or N, Linux 기반(시놀로지 포함) 사용자의 경우 showdown의 실행 권한을 showdown-manager web 실행 권한(ex. http)과 showdown 파일들의 소유자를 같이 맞출 필요가 있음

    $JAVA_HOME = "/var/packages/Java8/target/j2sdk-image/jre"; // 시스템의 $JAVA_HOME 위치

    $showdown_min_ver = 'v1.51'; // Showdown 필요 버전, 수정하지 마세요.
    $showdown_manager_ver = 'v0.5.4'; // Showdown Manager 버전