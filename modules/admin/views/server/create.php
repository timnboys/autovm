<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<!-- content -->
<div class="content">     
    <div class="col-md-6">
        <?php echo \app\widgets\Alert::widget();?>
        <?php $form = ActiveForm::begin(['enableClientValidation' => true]);?>
            <?php echo $form->field($model, 'name');?>
            <?php echo $form->field($model, 'ip');?>
            <?php echo $form->field($model, 'port');?>
            <?php echo $form->field($model, 'username');?>
            <?php echo $form->field($model, 'password')->passwordInput(['class'=>'form-control strength']);?>
            <?php echo $form->field($model, 'network')->label('VM Network Label');?>
            <?php echo $form->field($model, 'second_network')->label('Second Network Label');?>
            <?php echo $form->field($model, 'version')->label('VM Hardware version')->dropDownList(\app\models\Server::getVersionList());?>
            <label class="checkbox"><input type="checkbox" class="vCenterCheckBox" style="margin-bottom: 15px;"><span></span><b style="display:inline-block">vCenter</b></label>
            <?php echo $form->field($model, 'vcenter_ip');?>
            <?php echo $form->field($model, 'vcenter_username');?>
            <?php echo $form->field($model, 'vcenter_password')->passwordInput(['class'=>'form-control strength']);?>
            
			<?php echo $form->field($model, 'license');?>
            <?php echo $form->field($model, 'parent_id')->label('Use IP Address from:')->dropDownList(\app\models\Server::getListData(), ['prompt' => 'None']);?>
			
			
            <div class="margin-top-10"></div>
            <div class="margin-top-10"></div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="button" class="btn btn-primary waves-effect waves-light test3">Create test license</button>

            </div>
        <?php ActiveForm::end();?>
    </div>
</div>
<!-- END content -->
<?php

$url = Url::toRoute(['test', 'ip' => '']);

$this->registerJs("
   
$('.test2').click(function() {

if (!$('#server-ip').val()) {
   alert('please enter your server ip address');
   return false;
}

$.getJSON('$url' + $('#server-ip').val(), function(data) {

if (data.ok) {

$('#server-license').val(data.secret);

}

});

});

$('.btn-submit').click(function() {
  alert($('.password').strength('score'));
  return false;
});                 
$(document).ready(function(e){

        $('.field-server-vcenter_ip').hide();
        $('.field-server-vcenter_username').hide();
        $('.field-server-vcenter_password').hide();
        $('.vCenterCheckBox').on('click',function(){
            $('.field-server-vcenter_ip').slideToggle();
            $('.field-server-vcenter_username').slideToggle();
            $('.field-server-vcenter_password').slideToggle();
        });
    });
");
