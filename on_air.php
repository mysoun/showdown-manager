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
                            <table>
                                <tr>
                                    <th class="text-center">번호</th>
                                    <th class="text-center">포스터</th>
                                    <th class="text-center">제목</th>
                                    <th class="text-center">시즌</th>
                                    <th class="text-center">방영일</th>
                                    <th class="text-center">방송사</th>
                                    <th class="text-center">스케쥴</th>
                                    <th class="text-center">상태(HD)</th>
                                    <th class="text-center">상태(FHD)</th>
                                    <th class="text-center">기능</th>
                                </tr>
                                <?php
                                    $i = 0;
                                    foreach( $result as $v ) {
                                        // 숫자가 아닐 경우 pass
                                        if ( !is_numeric( $v['SID'] ) ) continue;

                                        $i++;

                                        $monitor_info = $sm->monitor_info( $db, $genre_episode_table_name, $genre, $v['SID'], $v['MONITOR_HD'], $v['MONITOR_FHD'] );

                                        echo <<<EOF
                                <tr>
                                    <td class="text-center">{$i}</td>
                                    <td class="text-center"><img src="{$v['THUMB']}" alt="" /></td>
                                    <td>
                                        {$v['NAME']}
                                        <!--button data-toggle="tooltip" title="제목 수정" class="pd-setting-ed btn-title-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button-->
                                    </td>
                                    <td class="text-center">{$v['SEASON']}</td>
                                    <td class="text-center">{$v['AIR_DATE']}</td>
                                    <td class="text-center">{$v['COMPANY']}</td>
                                    <td class="text-center">{$v['SCHEDULE']}</td>
                                    <td class="text-center">{$monitor_info['hd']}</td>
                                    <td class="text-center">{$monitor_info['fhd']}</td>
                                    <td class="text-center">
                                        <button data-toggle="tooltip" title="720p 모니터링 On/Off" class="btn-monitor pd-setting-ed" sid="{$v['SID']}" genre="{$genre}" resolution="720p">HD</button>
                                        <button data-toggle="tooltip" title="1080p 모니터링 On/Off" class="btn-monitor pd-setting-ed" sid="{$v['SID']}" genre="{$genre}" resolution="1080p">FHD</button>
                                    </td>
                                </tr>
EOF;
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include_once("./footer.php");
include_once("./php_footer.php");
?>

