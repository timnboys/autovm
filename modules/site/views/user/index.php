<?php
use yii\helpers\Url;
use yii\helpers\Html;

Yii::$app->setting->title .= ' - virtual servers';
?>

<div class="content">
    <div class="container vpsServers">
        <div class="row">
            <h3 class="title">Virtual Servers <p>List of your active virtual servers</p></h3>
            <?php echo \app\widgets\Alert::widget();?>
            <ul class="collapsible popout z-depth-4">
                <?php foreach($virtualServers as $vps) {?>
                    <li data-id="<?php echo $vps->id;?>">
                        <div class="collapsible-header">
                            <div class="row">
                                <div class="col l1 s2 center-align">
                                    <?php echo $vps->id;?>
                                </div>
								
                                <div class="col l1 s2 center-align">
                                    <?php if($vps->getIsOnline()){
                                    	echo('<div class="green circle" style="width: 16px; height: 16px; margin-top: 15px;"></div>');
                                    	}
                                    	else{
                                    	echo('<div class="grey circle" style="width: 16px; height: 16px; margin-top: 15px;"></div>');
                                    	}
                                     ?>
                                    
                                </div>
								
                                <div class="col l2 s3 center-align">
                                    <?php echo Html::encode($vps->ip ? $vps->ip->ip : 'NONE');?>
                                </div>
								<div class="col l2 s2 center-align">
                                    <?php echo Html::encode(!empty($vps->hostname) ? $vps->hostname : '');?>
                                </div>
                                <div class="col l3 hide-on-small-and-down center-align">
				    <?php echo Html::encode(isset($vps->os->name)?$vps->os->name:'NONE');?>
                                </div>
                                <div class="col l3 s4 center-align">
                                    <a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="12" class="btn blue vps-stop waves-effect waves-light" style="padding:5px;"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="12">change_history</i></a>
                                    <a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="2" class="btn blue vps-stop waves-effect waves-light" style="padding:5px;"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="2">autorenew</i></a>
                                    <a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="3" class="btn blue vps-stop waves-effect waves-light" style="padding:5px;"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="3">stop</i></a>
                                    <a href="javascript:void(0);" data-id="<?php echo $vps->id;?>" data-action="4" class="btn blue white-text vps-start waves-effect waves-light" style="padding:5px;"><i class="material-icons" data-id="<?php echo $vps->id;?>" data-action="4">play_arrow</i></a>
                                </div>
                            </div>
                        </div>
                        <div class="collapsible-body">
<!-- -->
<table class="bordered vpss striped centered responsive-table">
                <thead>
                    <th>IP Address</th>
                    <th>Server</th>
                    <th>Operating system</th>
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
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td colspan="2">Loading</td>
                    </tr>
                    <tr>
                        <td><a href="javascript:void(0);"><i class="material-icons">computer</i> <br>Change Os</a></td>
                        <td><a href="javascript:void(0);"><i class="material-icons">album</i> <br>ISO</a></td>
                        <td><a href="javascript:void(0);"><i class="material-icons">autorenew</i> <br>Restart</a></td>
                        <td><a href="javascript:void(0);"><i class="material-icons">stop</i> <br> Stop</a></td>
                        <td><a href="javascript:void(0);"><i class="material-icons">play_arrow</i> <br> Start</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);"><i class="material-icons">gps_fixed</i> <br> VPS Status</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);"><i class="material-icons">timeline</i> <br> Monitor</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);"><i class="material-icons">layers</i> <br> Extend hard</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);"><i class="material-icons">history</i> <br> Action Logs</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);"><i class="material-icons">developer_board</i> <br> Console</a></td>
                        <td class="hide-on-med-and-down"><a href="javascript:void(0);"><i class="material-icons">backup</i> <br> SnapShot</a></td>
                    </tr>
                    <tr>
                        <td class="hide-on-large-only"><a href="javascript:void(0);"><i class="material-icons">gps_fixed</i> <br> VPS Status</a></td>
                        <td class="hide-on-large-only"><a href="javascript:void(0);"><i class="material-icons">timeline</i> <br> Monitor</a></td>
                        <td class="hide-on-large-only"><a href="javascript:void(0);"><i class="material-icons">layers</i> <br> Extend hard</a></td>
                        <td class="hide-on-large-only"><a href="javascript:void(0);"><i class="material-icons">history</i> <br> Action Logs</a></td>
                    </tr>
                    </tbody>
                    </table>
<!-- -->
                        </div>
                    </li>
                <?php }?>
            </ul>
            <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pages]);?>
        </div>
    </div>
</div>
