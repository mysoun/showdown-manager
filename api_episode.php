<?php
    include "php_header.php";

    $json_result = [];

    $sm->genre = $_GET['genre'];
    $sm->sid = $_GET['sid'];

    $sm->set_table_name();

    $episode_rework = $sm->get_episode_list( $db );

    ob_start();
?>
<div class="product-status-wrap">
    <div class="asset-inner">
        <table>
            <tr>
                <th class="text-center">에피소드 회차</th>
                <th class="text-center">방영일</th>
                <th class="text-center">720p 모니터링</th>
                <th class="text-center">720p 다운/완료</th>
                <th class="text-center">1080p 모니터링</th>
                <th class="text-center">1080p 다운/완료</th>
            </tr>
            <?php
                foreach( $episode_rework as $k => $v ) {
                    $ep_monitor = ( $v['720-M'] == 'Y' || $v['1080-M'] == 'Y' ) ? "Y" : "N";
                    $ep_720_color = ( $v['720-M'] == 'Y' ) ? 'btn-success' : 'btn-danger';
                    $ep_720_m_color = ( $v['720-D'] == 'Y' ) ? 'btn-success' : 'btn-danger';
                    $ep_720 = ( $v['720-M'] == 'Y' ) ? "<button class='btn {$ep_720_m_color} btn-episode-download-toogle' episode='{$v['720-E']}' resolution='720P'>" . $v['720-D'] . '/' . $v['720-C'] . "</button>": '';
                    $ep_1080_color = ( $v['1080-M'] == 'Y' ) ? 'btn-success' : 'btn-danger';
                    $ep_1080_m_color = ( $v['1080-D'] == 'Y' ) ? 'btn-success' : 'btn-danger';
                    $ep_1080 = ( $v['1080-M'] == 'Y' ) ? "<button class='btn {$ep_1080_m_color} btn-episode-download-toogle' episode='{$v['1080-E']}' resolution='1080P'>" . $v['1080-D'] . '/' . $v['1080-C'] . "</button>" : '';
                    echo <<<EOF
            <tr>
                <td class="text-center">{$v['720-E']}</td>
                <td class="text-center">{$v['720-A']}</td>
                <td class="text-center"><button class="btn {$ep_720_color} btn-episode-monitor-toogle" data-toggle="tooltip" title="{$v['720-E']} 720p 모니터링 On/Off" episode='{$v['720-E']}' resolution='720P'>{$v['720-M']}</button></td>
                <td class="text-center">{$ep_720}</td>
                <td class="text-center"><button class="btn {$ep_1080_color} btn-episode-monitor-toogle" data-toggle="tooltip" title="{$v['1080-E']} 1080p 모니터링 On/Off" episode='{$v['1080-E']}' resolution='1080P'>{$v['1080-M']}</button></td>
                <td class="text-center">{$ep_1080}</td>
            </tr>
EOF;
                }
            ?>
        </table>
    </div>
</div>
<?php
    $json_result['title'] = $sm->title;
    $json_result['content'] = ob_get_contents();
    ob_end_clean();

    echo json_encode($json_result);

    include_once("./php_footer.php");
