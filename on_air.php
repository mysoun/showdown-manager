<?php
    include_once("./php_header.php");
    include_once("./header.php");
    include_once("./menu.php");
?>
    <div class="product-status mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="product-status-wrap">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <h4><?=$title;?></h4>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                            <button type="button" class="btn btn-success btn-program-search">프로그램 추가</button>
                        </div>
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
                                        if ( !is_numeric( $v['sid'] ) ) continue;

                                        $i++;

                                        //$monitor_info = $sm->monitor_info( $db, $genre_episode_table_name, $genre, $v['SID'], $v['MONITOR_HD'], $v['MONITOR_FHD'] );
                                        $v['episode'] = str_replace( 'E', '', $v['episode'] ) * 1;
                                        $monitor_info['hd'] = ( $v['monitor_hd'] == "Y" ) ? "<button class='btn-episode ps-setting' sid='{$v['sid']}' genre='{$genre}' resolution='720P' name='{$v['name']}'>{$v['complete_hd']}/{$v['episode']}</button>" : "";
                                        $monitor_info['fhd'] = ( $v['monitor_fhd'] == "Y" ) ? "<button class='btn-episode ps-setting' sid='{$v['sid']}' genre='{$genre}' resolution='1080P' name='{$v['name']}'>{$v['complete_fhd']}/{$v['episode']}</button>" : "";

                                        echo <<<EOF
                                <tr>
                                    <td class="text-center">{$i}</td>
                                    <td class="text-center"><img src="{$v['thumb']}" alt="" /></td>
                                    <td>
                                        {$v['name']}
                                        <button data-toggle="tooltip" title="제목 수정" class="pd-setting-ed btn-title-edit" name="{$v['name']}" sid='{$v['sid']}' genre='{$genre}'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        <button data-toggle="tooltip" title="프로그램 삭제" class="pd-setting-ed btn-program-delete" name="{$v['name']}" sid='{$v['sid']}' genre='{$genre}'><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                    <td class="text-center">{$v['season']}</td>
                                    <td class="text-center">{$v['air_date']}</td>
                                    <td class="text-center">{$v['company']}</td>
                                    <td class="text-center">{$v['schedule']}</td>
                                    <td class="text-center">{$monitor_info['hd']}</td>
                                    <td class="text-center">{$monitor_info['fhd']}</td>
                                    <td class="text-center">
                                        <button data-toggle="tooltip" title="720p 모니터링 On/Off" class="btn-monitor pd-setting-ed" sid="{$v['sid']}" genre="{$genre}" resolution="720P">HD</button>
                                        <button data-toggle="tooltip" title="1080p 모니터링 On/Off" class="btn-monitor pd-setting-ed" sid="{$v['sid']}" genre="{$genre}" resolution="1080P">FHD</button>
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

