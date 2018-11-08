<?php
use yii\helpers\Html;

$bundle = \app\modules\site\assets\Asset::register($this);

Yii::$app->setting->title .= ' - control virtual server';

$this->registerJs("
    var vpsId = " . $vps->id . ";

    $(document).ready(function () {
    \"use strict\";
    
});

    $.ajax({
        url:baseUrl + '/site/vps/bandwidth',
        type:'POST',
        dataType:'JSON',
        data:{vpsId:vpsId},
        success:function(data){
            Morris.Line({
                element: 'chart{$vps->id}',
                data: data,
                xkey: 'date',
                ykeys: ['total'],
                labels: ['Bandwidth MB'],
                smooth:false,
                lineWidth:2,
                lineColors: ['#189C7E'],
            });
        }
    });
");

?>

<style type="text/css">
.view-vps-table{
    box-shadow:none;
}
</style>
<?= Yii::$app->session->set('username', $vps->server->username); ?>
        <div class="col-md-12">
            <table class="bordered vpss striped centered responsive-table">
                <thead>
                    <th>IP Address</th>
                    <th>Server</th>
                    <th>Operating System</th>
                    <th>Memory</th>
                    <th>CPU Cores</th>
                    <th>CPU MHZ</th>
                    <th>Disk Space</th>
                    <th>Username</th>
                    <th>Disk</th>                    
                    <th colspan="2">Bandwidth</th>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo Html::encode(isset($vps->ip->ip)?$vps->ip->ip:'');?></td>
                        <td><?php echo Html::encode(isset($vps->server)?$vps->server->name:'');?></td>
                        <td><?php echo Html::encode(isset($vps->os->name)?$vps->os->name:'');?></td>

                        <td><?php
                            //var_dump($vps);exit;
                            if($vps->plan_type==VpsPlansTypeDefault) {
                                echo $vps->plan->ram;
                            }
                            else {
                                echo $vps->vps_ram;
                            }
                            ?>
                        <td>
                            <?php
                            //var_dump($vps);exit;
                            if($vps->plan_type==VpsPlansTypeDefault) {
                                echo $vps->plan->cpu_core;
                            }
                            else {
                                echo $vps->vps_cpu_core;
                            }
                            ?> Core</td>
                        <td><?php
                            //var_dump($vps);exit;
                            if($vps->plan_type==VpsPlansTypeDefault) {
                                echo $vps->plan->cpu_mhz;
                            }
                            else {
                                echo $vps->vps_cpu_mhz;
                            }
                            ?> MHZ</td>
                        <td><?php
                            //var_dump($vps);exit;
                            if($vps->plan_type==VpsPlansTypeDefault) {
                                echo $vps->plan->hard;
                            }
                            else {
                                echo $vps->vps_hard;
                            }
                            ?> GB</td>
                            <td><?php echo Html::encode(isset($vps->os->username)?$vps->os->username:'');?></td>
                            <td><?php echo Html::encode(isset($vps->disk)?$vps->disk:'');?></td>
                            
                        <td colspan="2">
                            <?php
                            if($vps->plan_type==VpsPlansTypeDefault)
                                echo number_format($used_bandwidth/1024, 3) .' /'. $vps->plan->band_width;
                            else
                                echo number_format($used_bandwidth/1024, 3) .' / '. $vps->vps_band_width;?>
                            GB
                        </td>
                    </tr>
                    <tr>
                        <td><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="1"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="1">computer</i> <br>Change Os</a></td>
                        <td><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="10"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="10">album</i> <br>ISO</a></td>
                        <td><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="2"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="2">autorenew</i> <br>Restart</a></td>
                        <td><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="3"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="3">stop</i> <br> Stop</a></td>
                        <td><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="4"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="4">play_arrow</i> <br> Start</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="5"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="5">gps_fixed</i> <br> VPS Status</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="6"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="6">timeline</i> <br> Monitor</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="7"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="7">layers</i> <br> Extend hard</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="8"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="8">history</i> <br> Action Logs</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="9"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="9">developer_board</i> <br> Console</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="11"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="11">backup</i> <br> SnapShot</a></td>
                    </tr>
                    <tr>
                        <td class="hide-on-large-only"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="5"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="5">gps_fixed</i> <br> VPS Status</a></td>
                        <td class="hide-on-large-only"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="6"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="6">timeline</i> <br> Monitor</a></td>
                        <td class="hide-on-large-only"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="7"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="7">layers</i> <br> Extend hard</a></td>
                        <td class="hide-on-large-only"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="8"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="8">history</i> <br> Action Logs</a></td>
                        <td class="hide-on-large-only"><a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="9"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="9">developer_board</i> <br> Console</a></td>
                    </tr>
                </tbody>
            </table>
<div id="chart<?php echo $vps->id;?>" style="width:100%;height:150px"></div>
        </div>



