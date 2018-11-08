<?php
 include_once ('views/header.phtml');
 $step = 2;
 include_once ('views/left.phtml');
?>
<div class="col s12 m9">
    <div class="card">
        <div class="card-content">
            <div class="title">
                <h3>Installation Wizard</h3>
            </div>
            <form id="w0" action="src/install.php" method="post" role="form">

                <b>MySql details</b>
                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" value="localhost" name="mysql_host" id="mysql_host" required />
                    <label for="mysql_host">MySQL host</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="mysql_username" id="mysql_username" required />
                    <label for="mysql_username" >MySQL Username</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="mysql_database" id="mysql_database" required />
                    <label for="mysql_database" >Database Name</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="password" name="mysql_password" id="mysql_password" required autocomplete="off" />
                    <label for="mysql_password" >MySQL Password</label>
                </div>

                <b>Admin Pannel details</b>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="email" id="email" required autocomplete="off" />
                    <label for="email" >Admin Email Address</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="password" name="password" id="password" required autocomplete="off" />
                    <label for="password" >Admin Password</label>
                </div>

                <div class="divider"></div>
                <div class="input-field form-group">
                    <button type="submit" class="btn btn-success right">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include_once ('views/footer.phtml');
?>