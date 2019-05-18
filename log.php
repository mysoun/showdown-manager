<?php
include_once("./php_header.php");
include_once("./header.php");

?>
<div class="product-status mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4><?=$title;?></h4>
                    <div class="asset-inner">
                        <h5> * ShowDown.log 파일에서 최대 500 line의 로그를 시간 역순으로 출력합니다.</h5>
                        <?php
                            $showdown_logs = file( $showdown_log_file );
                            $max_log_line = count($showdown_logs);
                            $start_log_line = ( $max_log_line - 500 > 0 ) ? $max_log_line - 500 : 0 ;
                            for( $i = $max_log_line; $i >= $start_log_line; $i-- ) {
                                echo $showdown_logs[$i]."<br>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include_once("./footer.php");
    include_once("./php_footer.php");
    ?>

