<?php use yii\helpers\Url;use yii\widgets\ActiveForm;?>
<!-- content -->
<div class="content user seeting">     
    <div class="col-md-6">
    <div class="userstyle">
        <div class="title_up"><h3>Settings</h3></div>

        <?php echo \app\widgets\Alert::widget();?>
        <?php $form = ActiveForm::begin(['enableClientValidation' => true]);?>
            <?php echo $form->field($model, 'title');?>
            <?php echo $form->field($model, 'api_url');?>
            <?php echo $form->field($model, 'terminate')->dropDownList([1 => 'Yes', 2 => 'No']);?>
            
            <div class="margin-top-10"></div>
            <div class="margin-top-10"></div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
            </div>
        <?php ActiveForm::end();?>
    </div>   </div>
    
    <div class="col-md-6">
    <div class="userstyle">
        <div class="title_up"><h3>Update tools</h3></div>
        <p>Current: <?php echo $current;?></p>
        <p><?php echo ($needUpdate ? 'There is a new update available' : 'Your current version is up to date');?></p>
        <a href="<?php echo Url::toRoute(['update']);?>" class="btn btn-primary waves-effect waves-light">Update system if available</a>
    </div>   </div>
</div>
<!-- END content -->
