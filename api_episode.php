<?php
    include "php_header.php";

    $json_result = [];

    switch( $_GET['genre'] ) {
        case 'drama' :
            $table_name = 'DRAMA_LIST';
            $ep_table_name = 'DRAMA_EPISODE';
            break;
        case 'tv' :
        case 'enter' :
            $table_name = 'TV_LIST';
            $ep_table_name = 'TV_EPISODE';
            break;

        default :
            exit;
    }

    $sid = $_GET['sid'];

    $result = $db->query( "SELECT * FROM {$table_name} WHERE SID = {$sid}");
    $result = $result->fetch();

    $result_ep = $db->query("SELECT * FROM {$ep_table_name} WHERE SID = {$sid}");

    $episode_rework = [];

    foreach ( $result_ep as $v ) {
        $ep_no = (int)substr( $v['EPISODE'], 1, 3);

        if ( $v['QUALITY'] == '720P' ) {
            $episode_rework[ $ep_no ]['720-E'] = $v['EPISODE'];
            $episode_rework[ $ep_no ]['720-A'] = $v['AIR_DATE'];
            $episode_rework[ $ep_no ]['720-M'] = $v['MONITOR'];
            $episode_rework[ $ep_no ]['720-D'] = $v['DOWNLOAD'];
            $episode_rework[ $ep_no ]['720-C'] = $v['COMPLETE'];
        } elseif( $v['QUALITY'] == '1080P' ) {
            $episode_rework[ $ep_no ]['1080-E'] = $v['EPISODE'];
            $episode_rework[ $ep_no ]['1080-A'] = $v['AIR_DATE'];
            $episode_rework[ $ep_no ]['1080-M'] = $v['MONITOR'];
            $episode_rework[ $ep_no ]['1080-D'] = $v['DOWNLOAD'];
            $episode_rework[ $ep_no ]['1080-C'] = $v['COMPLETE'];
        }
    }

    ob_start();
    ksort($episode_rework);
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
    $json_result['title'] = $result['NAME'];
    $json_result['content'] = ob_get_contents();
    ob_end_clean();

    echo json_encode($json_result);

    include_once("./php_footer.php");
