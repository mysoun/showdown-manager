# Showdown Web Manager
iodides님이 제작하신 Showdown을 Web에서 관리할 수 있도록 제작

## 제작 및 구동 환경
 * Synology DSM 6.0
 * Java8
 * Nginx
 * PHP 7.2(5.6+)
 * Kiaalap Template : https://github.com/puikinsh/kiaalap
 * Showdown v1.50 : https://iodides.tistory.com/7
 
## 설치 방법 by Synology DSM 6.0
 ```
    1. Showdown 설치 디렉토리에 권한 할당
        http : 읽기/쓰기
 
    2. Showdown 디렉토리의 SQLDB.db 파일에 권한 할당
        http : 읽기/쓰기
    
    3. Showdown Manager 설치 디렉토리에 권한 할당
        http : 읽기
    
    4. Synology Web Station 설정
        Nginx + PHP 7.0 or 5.6 

    5. JAVA8 설치 디렉토리 확인
        Showdown을 사용중이라면 Consol 접속 가능 할 것.
        $ echo $JAVA_HOME
        /var/packages/Java8/target/j2sdk-image/jre
        
    6. Showdown Manager 설정 파일 수정
        $ cd [Showdown Manager 설치 디렉토리]
        $ vi config.php
        
            $http_path = ""; // Showdown Manager 설치되어 있는 디렉토리
            $client_path = ""; // Showdown 설치되어 있는 디렉토리
        
            $JAVA_HOME = "/var/packages/Java8/target/j2sdk-image/jre"; // 시스템의 $JAVA_HOME 위치
            
    7. Showdown Server 구동 확인
        $ ps axf | grep java
        
            java -jar Server.jar
            
    8. Showdown Client 종료 확인
        Showdown이 사용하는 sqlite 특성상 cli.sh, cli.bat, Client.jre 등 동작시 정상적으로 작동하지 않습니다.
        Showdown Manager를 이용해서 수정할 경우 수정 시점에 Showdown Client가 종료되어 있는 것을 확인해 주세요.
        
```    

## Version History
  * v0.1 / 20190512 
    Drama 기능 추가 
    
## 남기는 말
  먼저 Showdown을 제작 및 공개해주신 iodides님께 감사드립니다.<br>
  기본적인 기능만 급하게 만들게 되어 보안 및 소스 코드의 구조화등 많은 부분이 부족한 소스 입니다.<br> 
  Showdown을 사용함에 있어 조금이나마 도움이 되었으면 합니다.
  
  감사합니다.
