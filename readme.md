# Showdown Web Manager
iodides님이 제작하신 Showdown을 Web에서 관리할 수 있도록 제작

## 제작 및 구동 환경
 * Synology DSM 6.0
 * Nginx
 * PHP 7.0(5.6+)
 * Kiaalap Template : https://github.com/puikinsh/kiaalap
 * Showdown v1.54 : https://iodides.tistory.com/15
 
## 설치 방법 by Synology DSM 6.0
 ```
      
    1. Showdown 설치 디렉토리에 권한 할당
        http : 읽기/쓰기
     
    2. Showdown Manager 설치 디렉토리에 권한 할당
        http : 읽기
    
    3. Synology Web Station 설정
        Nginx + PHP 7.0 or 5.6 + PHP 확장 에서 sockets 체크

    4. Showdown Manager 설정 파일 수정
        $ cd [Showdown Manager 설치 디렉토리]
        $ vi config.php
        
            $http_path = ""; // Showdown Manager 설치되어 있는 디렉토리
            $client_path = ""; // Showdown 설치되어 있는 디렉토리

            $showdown_url = "localhost"; // Shodown이 설치되어 있는 IP, 같은 서버일 경우 localhost ex) localhost
            $showdown_port = 4040; // Showdown이 동작하는 Port, Showdown config.properties 참조 ex) 4040
    
            $start_page = 1; // 메뉴 번호 1~7

            // Showdown Manager 접속 ID/Passwd 설정. 미설정시 인증 Pass
            $manager_id = '';
            $manager_passwd = '';

            // 시놀로지의 경우 폴더 권한에 자식 폴더 및 파일 포함 http 권한 설정 필요
            // Linux 기반사 용자의 경우 showdown의 실행 권한을 showdown-manager web 실행 권한(ex. http)과 showdown 파일들의 소유자를 같이 맞출 필요가 있음
            $show_log_menu = 'N'; 

    5. Showdown Server 구동 및 구동 확인
        $ nohup ./start.sh &
        $ ps axf | grep java
            java -jar Server.jar <= 출력 확인
            
    6. Showdown Client 종료 확인
        Showdown Manager를 이용해서 수정할 경우 수정 시점에 Showdown Client가 종료되어 있는 것을 확인해 주세요.
        
```    

## Version History
    * v0.1 / 20190512
        Drama 기능 추가
    * v0.2 / 20190513
        TV/엔터 기능 추가
        시작 메뉴 config 추가
    * v0.3 / 20190514
        객체화로 소스 리뉴얼
    * v0.4 / 20190514
        SQL Lock 이슈로 인해 객체화 롤백
    * v0.5 / 20190516
        모니터링 관련 Client 명령어 처리 부분 DB Access로 변경
        config.php 설정에 자동 접속 페이지를 설정할 수 있는 start_page 추가 
        Episode Page 오픈시 제일 하단으로 자동 스크롤 추가
    * v0.5.1 / 20190516
        1000개 이상 되는 에피소드 정렬 이슈 수정 
    * v0.5.2 / 20190516
        모바일 페이지 대응
        class destruct 오류 제거
    * v0.5.3 / 20190517
        Showdown Log 페이지 추가
        - ShowDown.log 파일에서 최대 500 line의 로그를 시간 역순으로 출력합니다.
    * v0.5.4 / 20190518
        Showdown Log Page On/Off 설정 추가
        - 시놀로지의 경우 폴더 권한에 자식 폴더 및 파일 포함 http 권한 설정 필요
        - Linux 기반사 용자의 경우 showdown의 실행 권한을 showdown-manager web 실행 권한(ex. http)과 showdown 파일들의 소유자를 같이 맞출 필요가 있음
        - 다른 유저 권한으로 실행 방법 ex) sudo -u http "nohup ./start.sh &"
    * v0.5.5 / 20190519
        Hot fix
    * v0.6.3 / 20190525
        Docker 대응 기능 추가
        - 아래의 Docker Hub 에서 Showdown Manager 설치 가능
        - https://hub.docker.com/r/kumryung/showdown-manager
        Login 기능 추가
        - config.php에 관련된 추가 항목 있음, 둘다 미설정시 인증 Pass
        - $manager_id : 로그인 ID 
        - $manager_passwd : 로그인 Password
        showdown 1.52(Beta) 업데이트 대응 관련 메뉴 번호 변경 및 기능 추가
        - config.php에 관련된 추가 항목 있음
        - $merge_tv_enter = 'N'; // Y or N, Showdown 1.52에 추가된 TV/Enter의 방영 예정을 합쳐서 보여줄지 나눠줄지 선택하는 부분
        
    * v1.0.0 / 20190701
        더 이상 Showdown DB에 직접 접속을 하지 않습니다. 
        - PHP 확장 기능중 pdo_sqlite를 이용하지 않습니다.
        더 이상 Showdown Manager는 Java 명령을 수행하지 않습니다.
        Showdown 1.54 버전에 추가된 API 기능을 이용하게 변경 되었습니다. 
        - PHP 확장 기능중 sockets를 이용합니다.  
        프로그램 검색/추가/삭제/이름변경 기능이 추가되었습니다.
        개별 에피소드의 모니터링 상태 변경 기능이 제거 되었습니다.
        예정/방영중 프로그램을 같이 보여주는 기능이 제거 되었습니다.
        config.php에 관련된 추가 항목 있음
        - $showdown_url : Shodown이 설치되어 있는 IP, 같은 서버일 경우 localhost ex) localhost
        - $showdown_port : Showdown이 동작하는 Port, Showdown config.properties 참조 ex) 4040
    
        
        @@ Showdown Client가 실행된 상태에서는 Showdown Manager가 동작하지 않습니다.
         
            
## 알려진 버그
    
    
## 남기는 말
  먼저 Showdown을 제작 및 공개해주신 iodides님께 감사드립니다.<br>
  기본적인 기능만 급하게 만들게 되어 보안 및 소스 코드의 구조화등 많은 부분이 부족한 소스 입니다.<br> 
  1.0.0 부터 Showdown 1.54에 추가된 API 기능을 이용하게 변경 되었습니다.
  대부분의 기능이 구현되었습니다. 일부 기능은 추후 업데이트 하도록 하겠습니다.<br>
  이용에 참고해 주세요.<br>
  Showdown을 사용함에 있어 조금이나마 도움이 되었으면 합니다.
  
  감사합니다.
