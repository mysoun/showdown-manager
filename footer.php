<div class="footer-copyright-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer-copy-right">
                    <p>Showdown Manager <?=$showdown_manager_ver;?> Make by 룡룡이, Showdown <?=$showdown_min_ver;?> Require, Thank you iodides!</p>
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
        alert("Console 기능을 이용해 주세요.");
    })

    $(".btn-episode").on('click', function() {
        if ( btn_lock == false ) {
            btn_lock = true;

            call_episode( $(this).attr('sid'), $(this).attr('genre') );
        }
    });


    $(".btn-all-episode-720-monitor-on").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_monitor_on';
        var resolution = '720p';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-720-monitor-off").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_monitor_off';
        var resolution = '720p';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-720-download-on").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_download_on';
        var resolution = '720p';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-720-download-off").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_download_off';
        var resolution = '720p';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-1080-monitor-on").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_monitor_on';
        var resolution = '1080p';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-1080-monitor-off").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_monitor_off';
        var resolution = '1080p';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-1080-download-on").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_download_on';
        var resolution = '1080p';

        call_episode_action( sid, genre, resolution, type );
    });

    $(".btn-all-episode-1080-download-off").on('click', function() {
        var sid = $("#modal-episode-table-list").attr("sid");
        var genre = $("#modal-episode-table-list").attr("genre");
        var type = 'all_episode_download_off';
        var resolution = '1080p';

        call_episode_action( sid, genre, resolution, type );
    });


    function call_episode( sid, genre ) {
        var data = {
            genre: genre,
            sid: sid
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
                call_episode_monitor_action( sid, genre, resolution, episode, type );
            });

            $(".btn-episode-monitor-toogle").on('click', function () {
                var type = 'episode_monitor_on_off';
                var resolution = $(this).attr("resolution");
                var episode = $(this).attr("episode");
                call_episode_monitor_action( sid, genre, resolution, episode, type );
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

    function call_episode_monitor_action( sid, genre, resolution, episode, type ) {
        if ( btn_lock == false ) {
            btn_lock = true;
            var data = {
                type: type,
                genre: genre,
                resolution: resolution,
                episode: episode,
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
</script>