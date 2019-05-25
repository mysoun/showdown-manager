    <div class="header-advance-area">
        <div class="header-top-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="header-top-wraper">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="header-top-menu tabl-d-n">
                                        <ul class="nav navbar-nav mai-top-nav">
                                            <li class="nav-item"><a href="#" class="nav-link">Showdown Manager</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=1" class="nav-link">1. 드라마(예정)</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=2" class="nav-link">2. 드라마(방영중)</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=3" class="nav-link">3. 드라마(종료)</a></li>
                                            <?php
                                                if ( $merge_tv_enter == 'Y' ) {
                                                    echo <<<EOF
                                            <li class="nav-item"><a href="on_air.php?status=4" class="nav-link">4+5. 예능</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=6" class="nav-link">6. 예능(종료)</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=7" class="nav-link">7+8. TV</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=9" class="nav-link">9. TV(종료)</a></li>
EOF;
                                                } else {
                                                    echo <<<EOF
                                            <li class="nav-item"><a href="on_air.php?status=4" class="nav-link">4. 예능(방영전)</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=5" class="nav-link">5. 예능(방영중)</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=6" class="nav-link">6. 예능(종료)</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=7" class="nav-link">7. TV(방영전)</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=8" class="nav-link">8. TV(방영중)</a></li>
                                            <li class="nav-item"><a href="on_air.php?status=9" class="nav-link">9. TV(종료)</a></li>
EOF;
                                                }
                                            ?>
                                            <?php
                                            if ( $show_log_menu == 'Y' ) {
                                                echo '<li class="nav-item"><a href="log.php" class="nav-link">10. 금일 로그</a></li>';
                                            }
                                            if ( $_SESSION['sm-auth'] === true ) {
                                                echo '<li class="nav-item"><a href="api.php?type=logout" class="nav-link">11. 로그아웃</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>