<?php
 require_once ('src/queryHelper.php');
 include_once ('views/header.phtml');
 $step = 3;
 include_once ('views/left.phtml');
?>
<div class="col s12 m9">
    <div class="card">
        <div class="card-content">
            <div class="title">
                <h3>Add New Server</h3>
            </div>
            <form action="src/server.php" method="post" role="form">

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="name" id="name" required />
                    <label for="name">Name</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="ip" id="ip" required />
                    <label for="ip" >IP</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="port" id="port" required />
                    <label for="port" >Port</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="username" id="username" required autocomplete="off"/>
                    <label for="username">Username</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="password" name="password" id="password" required autocomplete="off"/>
                    <label for="password">Password</label>
                </div>

                <div class="input-field form-group checkbox">
                    <input type="checkbox" id="vcenter" />
                    <label for="vcenter">vCenter</label>
                </div>

                <div class="vcenter-items">
                    <div class="input-field form-group">
                        <input class="form-control validate" type="text" name="vcenter_ip" id="vcenter_ip" />
                        <label for="vcenter_ip" >vCenter IP</label>
                    </div>

                    <div class="input-field form-group">
                        <input class="form-control validate" type="text" name="vcenter_username" id="vcenter_username" autocomplete="off" />
                        <label for="vcenter_username" >vCenter Username</label>
                    </div>

                    <div class="input-field form-group">
                        <input class="form-control validate" type="password" name="vcenter_password" id="vcenter_password" autocomplete="off" />
                        <label for="vcenter_password" >vCenter Password</label>
                    </div>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="license" id="license" required />
                    <label for="license" >License</label>
                </div>

                <div class="divider"></div>

                <button type="button" class="btn btn-success left create" style="margin-top:15px;margin-right:10px;">Create trial license</button>

                <div class="input-field form-group">
                    <?php
                        $servers = dbGet('SELECT * FROM `server`');
                        if(is_array($servers))
                            echo('<a class="btn pink left" href="datastore.php">Skip And Next</a>');
                        else
                            echo('<a class="btn pink left" href="complete.php">Skip And Finish</a>');
                    ?>
                    
                    <button type="submit" class="btn btn-success right">Save and Next</button>
                    <a style="margin-right: 20px;" class="btn btn-success right" onClick="saveThis()">Save and Add Another Server</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function (e) {
       $('div.checkbox input').change(function (e) {
           $('.vcenter-items').slideToggle();
       });
		
		$(".create").click(function(e) {
			
			ip = $("#ip");
			license = $("#license");
			
			$.ajax({
				url:"license.php",
				data:{ip:ip.val()},
				type:"GET",
				dataType:"JSON",
				success:function(data) {
				
					if (data.ok) {
						license.val(data.secret);	
					}
				}
			});
		});
    });
    function saveThis() {
		
        $.ajax({
            url: "src/server.php",
            type: "post",
            data: {
                method              : 'ajax',
                name                : $('input#name').val(),
                ip                  : $('input#ip').val(),
                port                : $('input#port').val(),
                username            : $('input#username').val(),
                password            : $("input#password").val(),
                vcenter_ip          : $('input#vcenter_ip').val(),
                vcenter_username    : $('input#vcenter_username').val(),
                vcenter_password    : $('input#vcenter_password').val(),
                license             : $('input#license').val()
            },
            success: function (response) {
                if(response == 1){
                    var $toastContent = $('<span class="rtl center">Server Added Successfully</span>');
                    Materialize.toast($toastContent, 5000, 'green');
                    $('input').val('');
                    $('.valid').removeClass('valid');
                    $('a.pink').attr('href','datastore.php');
                    $('a.pink').text('Skip And Next');
                }
                else{
                    var $toastContent = $('<span class="rtl center">An error occurred during add the server , Please call support.</span>');
                    Materialize.toast($toastContent, 5000, 'red');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var $toastContent = $('<span class="rtl center">An error occurred during send the data , Please call support.</span>');
                Materialize.toast($toastContent, 5000, 'red');
            }
        });
    }
</script>
<?php
include_once ('views/footer.phtml');
?>
