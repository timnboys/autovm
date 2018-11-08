<?php if($update) {?>
<div class="alert alert-danger">There is a new update available. <a href="<?php echo Yii::$app->urlManager->createUrl('/admin/default/update');?>">Update it</a></div>
<?php }?>