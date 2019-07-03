<div class="footer-copyright-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-copy-right">
                    <p>Showdown Manager <?=$showdown_manager_ver;?> Make by 룡룡이, Showdown <?=$showdown_min_ver;?> Require, Thank you for iodides!</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="modal-episode-table-list" class="modal fade" role="dialog" sid="" genre="">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modal-episode-title"></h4>
            </div>
            <div class="modal-body modal-episode-content"></div>
            <div class="modal-footer text-left">
                <button type="button" class="btn btn-primary btn-all-episode-720-monitor-on">720p 모니터링 전체 On</button>
                <button type="button" class="btn btn-info btn-all-episode-720-monitor-off">720p 모니터링 전체 Off</button>
                <button type="button" class="btn btn-primary btn-all-episode-720-download-on">720p 다운로드 전체 On</button>
                <button type="button" class="btn btn-info btn-all-episode-720-download-off">720p 다운로드 전체 Off</button>
            </div>
            <div class="modal-footer text-left">
                <button type="button" class="btn btn-primary btn-all-episode-1080-monitor-on">1080p 모니터링 전체 On</button>
                <button type="button" class="btn btn-info btn-all-episode-1080-monitor-off">1080p 모니터링 전체 Off</button>
                <button type="button" class="btn btn-primary btn-all-episode-1080-download-on">1080p 다운로드 전체 On</button>
                <button type="button" class="btn btn-info btn-all-episode-1080-download-off">1080p 다운로드 전체 Off</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div id="modal-program" class="modal fade" role="dialog" genre="<?=$genre;?>">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modal-program-title">프로그램 검색 결과</h4>
            </div>
            <div class="modal-body modal-program-content" style="display: flex;justify-content: center;">
                <table style="width:500px;align-self: center;">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="2"><h4>[<span id="modal-program-genre"></span>] <span id="modal-program-name"></span></h4></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center" width="130" >
                                <img id="modal-program-image" class="card-img-top" src="" width="130" alt="">
                            </td>
                            <td class="text-primary" style="padding-left:10px;font-weight: bold; vertical-align: top; line-height:30px;">
                                방송사 : <span id="modal-program-company"></span><br>
                                방영일 : <span id="modal-program-airdate"></span><br>
                                스케쥴 : <span id="modal-program-schedule"></span><br>
                                설명 : <span id="modal-program-comment"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer text-right">
                <button type="button" class="btn btn-success btn-program-add">추가</button>
                <button type="button" class="btn btn-warning btn-program-cancle" data-dismiss="modal">취소</button>
            </div>
        </div>

    </div>
</div>



<div id="modal-loading" class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title modal-program-title">처리중입니다.....</h4>
            </div>
            <div class="modal-body text-center">
                <span class="fa fa-spinner fa-spin fa-3x"></span>
            </div>
        </div>

    </div>
</div>

<!-- jquery
    ============================================ -->
<script src="js/vendor/jquery-1.12.4.min.js"></script>
<!-- bootstrap JS
    ============================================ -->
<script src="js/bootstrap.min.js"></script>
<!-- wow JS
    ============================================ -->
<script src="js/wow.min.js"></script>
<!-- price-slider JS
    ============================================ -->
<script src="js/jquery-price-slider.js"></script>
<!-- owl.carousel JS
    ============================================ -->
<script src="js/owl.carousel.min.js"></script>
<!-- sticky JS
    ============================================ -->
<script src="js/jquery.sticky.js"></script>
<!-- scrollUp JS
    ============================================ -->
<script src="js/jquery.scrollUp.min.js"></script>
<!-- mCustomScrollbar JS
    ============================================ -->
<script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/scrollbar/mCustomScrollbar-active.js"></script>
<!-- metisMenu JS
    ============================================ -->
<script src="js/metisMenu/metisMenu.min.js"></script>
<script src="js/metisMenu/metisMenu-active.js"></script>

<!-- plugins JS
    ============================================ -->
<script src="js/plugins.js"></script>
<!-- main JS
    ============================================ -->
<script src="js/main.js"></script>
</body>

</html>

<script>
    $("#modal-episode-table-list").on("hidden.bs.modal", function () {
        location.reload();
    }).on('shown.bs.modal', function () {
        $(this).animate({ scrollTop: $(".modal-episode-content").height() }, "slow");
    });


    $(".btn-monitor").on('click', function () {
        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                type: 'monitor',
                genre: $(this).attr('genre'),
                resolution: $(this).attr('resolution'),
                sid: $(this).attr('sid')
            };
            $.ajax({
                url: "./api.php",
                data: data
            }).done(function (msg) {
                btn_lock = false;
                location.reload();
                //alert("Data Saved: " + msg);
            });
        };
    });

    $(".btn-title-edit").on('click', function () {
        var new_name = prompt( '변경할 제목을 입력해 주세요.', $(this).attr('name') );

        if ( new_name != '' ) call_rename_action( $(this).attr('sid'), $(this).attr('genre'), $(this).attr('name'), new_name );
    });


    $(".btn-program-search").on('click', function () {
        var keyword = prompt( '검색할 프로그램 이름을 입력해 주세요.', '' );

        if ( keyword != '' ) call_search_action( keyword );
    });

    $(".btn-program-add").on('click', function () {
        call_program_add_action();
    });

    $(".btn-program-delete").on('click', function () {
        var genre = $(this).attr("genre");
        var name = $(this).attr("name");
        var sid = $(this).attr("sid");

        if( confirm("[" + name + "] 프로그램을 삭제 하시겠습니까?") ) call_program_delete_action(genre, sid, name );
    });

    $(".btn-episode").on('click', function() {
        if ( btn_lock == false ) {
            btn_lock = true;


            call_episode( $(this).attr('sid'), $(this).attr('genre'), $(this).attr('name') );
        }
    });


    $(".btn-all-episode-720-monitor-on").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'monitor';
        var resolution = '720P';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-720-monitor-off").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'monitor';
        var resolution = '720P';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-720-download-on").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_download_on';
        var resolution = '720P';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-720-download-off").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_download_off';
        var resolution = '720P';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-1080-monitor-on").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'monitor';
        var resolution = '1080P';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-1080-monitor-off").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'monitor';
        var resolution = '1080P';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-1080-download-on").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_download_on';
        var resolution = '1080P';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-1080-download-off").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_download_off';
        var resolution = '1080P';

        call_episode_action( sid, genre, resolution, type );
    });

    $("#loginForm").on("submit", function() {
        event.preventDefault();

        var username = $("#username").val();
        var password = $("#password").val();

        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                username: username,
                password: password
            };
            $.ajax({
                url: "./api.php?type=auth",
                data: data,
                type: 'POST'
            }).done(function (msg) {
                btn_lock = false;
                if ( msg == 'true') {
                    location.href = "./on_air.php";
                } else {
                    alert('로그인 정보를 정확히 입력해 주세요.' );
                    $("#username").focus();
                };

            });
        };
    });

    function call_episode( sid, genre, name ) {
        var data = {
            genre: genre,
            sid: sid,
            name: name
        };

        $.ajax({
            url: "./api_episode.php",
            data: data,
            dataType:"JSON"
        }).done(function (data) {
            btn_lock = false;
            $("#modal-episode-table-list").attr("sid", sid );
            $("#modal-episode-table-list").attr("genre", genre );

            $(".modal-episode-title").html( data.title );
            $(".modal-episode-content").html( data.content );

            $(".btn-episode-download-toogle").on('click', function () {
                var type = 'episode_download_on_off';
                var resolution = $(this).attr("resolution");
                var episode = $(this).attr("episode");
                var name = $(this).attr("name");
                var complete = $(this).attr("complete");

                call_episode_monitor_action( sid, genre, resolution, episode, type, name, complete );
            });

            $(".btn-episode-monitor-toogle").on('click', function () {
                var type = 'episode_monitor_on_off';
                var resolution = $(this).attr("resolution");
                var episode = $(this).attr("episode");
                alert('에피소드 개별 모니터링 설정은 더 이상 지원하지 않습니다.\n다운로드/완료 On/Off 기능을 이용해 주세요.');
                //call_episode_monitor_action( sid, genre, resolution, episode, type );
            });

            $("#modal-episode-table-list").modal('show');
            //.animate({ scrollTop: $(".modal-episode-content").height() }, "slow");

        });
    }

    function call_episode_action( sid, genre, resolution, type ) {
        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                type: type,
                genre: genre,
                resolution: resolution,
                sid: sid
            };
            $.ajax({
                url: "./api.php",
                data: data
            }).done(function (msg) {
                btn_lock = false;
                call_episode( sid, genre );
            });
        };
    }

    function call_episode_monitor_action( sid, genre, resolution, episode, type, name, complete ) {
        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                type: type,
                genre: genre,
                resolution: resolution,
                episode: episode,
                sid: sid,
                name: name,
                complete: complete
            };
            $.ajax({
                url: "./api.php",
                data: data
            }).done(function (msg) {
                btn_lock = false;
                call_episode( sid, genre );
            });
        };
    }

    function call_rename_action( sid, genre, name, new_name ) {
        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                type: 'rename',
                sid: sid,
                name: name,
                genre: genre,
                new_name: new_name
            };
            $.ajax({
                url: "./api.php",
                data: data
            }).done(function (msg) {
                btn_lock = false;
                location.reload();
            });
        };
    }

    function call_search_action( keyword ) {
        var genre = $("#modal-program").attr('genre');
        $("#modal-program").attr('keyword', keyword );
        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                type: 'search',
                genre: genre,
                keyword: keyword
            };

            $.ajax({
                url: "./api.php",
                data: data,
                dataType:"JSON"
            }).done(function (msg) {
                btn_lock = false;

                if ( msg.result == 'true' ) {
                    $("#modal-program-genre").text(msg.genre);
                    $("#modal-program-name").text(msg.name);

                    $("#modal-program-image").attr("src", msg.thumb);

                    $("#modal-program-company").text(msg.company);
                    $("#modal-program-airdate").text(msg.air_date);
                    $("#modal-program-schedule").text(msg.schedule);
                    $("#modal-program-comment").text(msg.comment);


                    $("#modal-program").modal('show');
                } else {
                    alert("검색된 결과가 없습니다.");
                };
            });
        };
    }


    function call_program_add_action() {
        $("#modal-program").modal('hide');
        $("#modal-loading").modal('show');

        var genre = $("#modal-program").attr('genre');
        var keyword = $("#modal-program").attr('keyword');
        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                type: 'add',
                genre: genre,
                keyword: keyword
            };
            $.ajax({
                url: "./api.php",
                data: data,
                dataType:"JSON"
            }).done(function (msg) {
                btn_lock = false;
                location.reload();
                //if ( msg.result == 'true' ) location.reload();
                //else {
                //    alert("프로그램을 추가 할 수 없습니다.");
                //}
            });
        };
    }

    function call_program_delete_action(genre, sid, name) {
        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                type: 'delete',
                genre: genre,
                name: name,
                sid: sid
            };
            $.ajax({
                url: "./api.php",
                data: data
            }).done(function (msg) {
                btn_lock = false;
                location.reload();
            });
        };
    }


    $(window).on('load',function(){

    });
</script>
