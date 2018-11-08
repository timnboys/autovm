<?php
 include_once ('views/header.phtml');
 $step = 5;
 include_once ('views/left.phtml');
?>
<div class="col s12 m9">
    <div class="card">
        <div class="card-content">
            <div class="title">
                <h3>Completed !</h3>
                <p style="padding-left: 20px">Please remove install folder from /web directory.</p>
            </div>
            <p style="text-align: justify;margin-bottom: 20px;font-weight: bold;">
            </p>
            <div class="divider"></div>
            <div class="input-field form-group">
                <a href="../" class="btn btn-success right">Finish</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function (e) {
       $('div.checkbox input').change(function (e) {
           $('.vcenter-items').slideToggle();
       });
    });
    function reloadPage() {
        location.reload();
    }
</script>
<?php
include_once ('views/footer.phtml');
?>