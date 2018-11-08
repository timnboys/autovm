<?php use yii\helpers\Html; use yii\helpers\Url;?>
<style type="text/css">
.table td{text-align:left;padding-left:10px!important;}
    .col-md-6{background:none!important;box-shadow:none!important;}
</style>
<!-- content -->
<div class="content">
    
    <div class="col-md-6">
        <div style="float:left;width:100%;padding:30px;background:#fff;border-radius:6px;box-shadow:0 0 5px #ddd;">

            <table class="table table-bordered">

                <tr>
                    <td>Server</td><td><a href="<?php echo Yii::$app->urlManager->createUrl(['/admin/server/edit', 'id' => isset($vps->server->id)?$vps->server->id:'']);?>"><?php echo Html::encode(isset($vps->server->name)?$vps->server->name:'');?></a></td>
                </tr>
                <?php foreach($vps->ips as $ip) {?>
                <tr>
                    <td>IP Address</td><td><?php echo $ip->ip;?> <a href="<?php echo Url::toRoute(['vps/del', 'id' => $ip->id]);?>">Delete</a></td>
                </tr>
                <?php }?>
                <tr>
                    <td>Operating System</td><td><?php echo Html::encode(isset($vps->os->name)?$vps->os->name:'');?></td>
                </tr>
               <tr>
                    <td>Username</td><td><?php echo Html::encode($vps->os->username);?></td>
                </tr>                
                <tr>
                    <td>Password</td><td><?php echo Html::encode($vps->password);?></td>
                </tr>                
                <tr>
                    <td>Plan</td><td><a href="<?php echo isset($vps->plan)? Yii::$app->urlManager->createUrl(['/admin/plan/edit', 'id' => $vps->plan->id]):'' ; ?>"><?php echo isset($vps->plan)?Html::encode($vps->plan->name):'';?></a></td>
                </tr>                                
                <tr>
                    <td>Logs</td><td><a href="<?php echo Yii::$app->urlManager->createUrl(['/admin/vps/log', 'id' => $vps->id]);?>"><i class="fa fa-search"></i></a></td>
                </tr>
                <tr>
                    <td>Status</td><td><?php echo ($vps->getIsActive() ? ' Active' : ' Inactive');?></td>
                </tr>    
            </table>            

            <a href="<?php echo Yii::$app->urlManager->createUrl(['/admin/vps/update', 'id' => $vps->id]);?>" class="btn btn-primary waves-effect waves-light upgrade">Upgrade</a>
            <a href="<?php echo Yii::$app->urlManager->createUrl(['/admin/vps/terminate', 'id' => $vps->id]);?>" class="btn btn-danger waves-effect waves-light terminate">Terminate</a>

            <?php echo Html::endForm();?>
            
            <div style="float:left;width:100%;margin-top:30px;"></div>
            
            <button type="button" class="btn btn-primary select-os">Change OS</button>
            
            <div style="display:none;" class="install-box">
            <?php echo Html::beginForm(Url::toRoute(['vps/install', 'id' => $vps->id]), 'POST', ['class' => 'install']);?>
            
            <div class="form-group">
                <select class="form-control" name="data[os]">
                    <?php foreach($os as $o) {?>
                    <option value="<?php echo $o->id;?>"><?php echo Html::encode($o->name);?></option>
                    <?php }?>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Install</button>
            </div>
            
            <?php echo Html::endForm();?>
            </div>
                
        </div>
    </div>
    
       <div class="col-md-6">
        <div style="float:left;width:100%;padding:30px;background:#fff;border-radius:6px;box-shadow:0 0 5px #ddd;">                                        
         
            <table class="table table-bordered">
                <tr>
                    <td width="150">ID</td><td><?php echo $vps->id;?></td>
                </tr>            
                <tr>
                    <td>User</td> <td><?php echo ($vps->user->first_name);?> -  <a href="<?php echo \yii\helpers\Url::toRoute(['user/login', 'id' => $vps->user->id]);?>">Login</a></td>
                </tr>
                <tr>
                    <td>Created at</td><td><?php echo date('d M Y - H:i', $vps->created_at);?></td>
                </tr>
                <tr>
                    <td>Updated at</td><td><?php echo date('d M Y - H:i', $vps->updated_at);?></td>
                </tr>                                        
                <tr>
                    <td>Bandwidth usage</td><td><p><?php if($vps->plan_type==VpsPlansTypeDefault) echo number_format($used_bandwidth/1024, 3) .' / '. number_format($vps->plan->band_width); else echo number_format($used_bandwidth/1024, 3) .' /'. number_format($vps->vps_band_width);?> GB</p></td>                    
                </tr>
            </table>            
            
            <a href="<?php echo Yii::$app->urlManager->createUrl(['/admin/vps/reset-bandwidth', 'id' => $vps->id]);?>" class="btn btn-primary waves-effect waves-light">Reset bandwidth</a>
            
            <div style="float:left;width:100%;margin-top:30px;"></div>
            
            <?php echo Html::beginForm(Url::toRoute(['vps/add', 'id' => $vps->id]));?>
            
            <div class="form-group">
                <select class="form-control" name="data[ip]">
                    <?php foreach($ips as $ip) {?>
                    <option value="<?php echo $ip->id;?>"><?php echo $ip->ip;?></option>
                    <?php }?>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add new IP address</button>
            </div>    
</div>
<!-- END content -->
<?php

$js = <<<EOT

$(".upgrade").click(function(e) {
    
    e.preventDefault();
    
    self = $(this);
    
    self.text("Please wait");
    
    $.getJSON(self.attr("href"), self.serialize(), function(data) {
        if (data.ok) {
            self.text("Done");
        } else {
            self.text("Try again");
        }
    });
});

$(".terminate").click(function(e) {
    
    e.preventDefault();
    
    self = $(this);
    
    ok = confirm('The vps will be terminated and deleted');
    
    if (ok) {
        self.text("Please wait");

        $.getJSON(self.attr("href"), self.serialize(), function(data) {
            if (data.ok) {
                self.text("Done");
            } else {
                self.text("Try again");
            }
        });
    }
});

$(".select-os").click(function() {

    data = $(".install-box").html();

    new simpleAlert({title: 'Select os', content: data});
    
    $(".install").submit(function(e) {

    e.preventDefault();
    
    self = $(this);
    
    new simpleAlert({title:'Installing', content:'Please wait, This may take a few minute.'});
    
    $.post(self.attr("action"), self.serialize(), function(data) {
        if (data.ok) {
            new simpleAlert({title: 'Installed', content: 'The selected OS has been installed. Please reload the page to see changes.'});
        } else {
            new simpleAlert({title: 'Error', content: 'There is an error, Please try again.'});
        }
    });
});
});
EOT;

$this->registerJs($js);
