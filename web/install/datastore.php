<?php
 require_once ('src/queryHelper.php');
 include_once ('views/header.phtml');
 $step = 4;
 include_once ('views/left.phtml');
?>
<div class="col s12 m9">
    <div class="card">
        <div class="card-content">
            <div class="title">
                <h3>Add New DataStore & IP Address</h3>
            </div>
            <table class="responsive-table striped highlight">
                <thead>
                    <tr>
                        <th class="center-align">ID</th>
                        <th class="center-align">Name</th>
                        <th class="center-align">IP</th>
                        <th class="center-align">Port</th>
                        <th class="center-align">License</th>
                        <th class="center-align">Delete Server</th>
                        <th class="center-align">Add IP Address</th>
                    </tr>
                </thead>
                <tbody>
            <?php
                $servers = dbGet('SELECT * FROM `server`');
                if(isset($servers) && $servers){
                    foreach ($servers as $server){
                        echo('<tr id="'.$server['id'].'" class="center-align"><td>'.$server['id'].'</td><td>'.$server['name'].'</td><td>'.$server['ip'].'</td><td>'.$server['port'].'</td><td>'.$server['license'].'</td><td><i onClick="deleteServer('.$server['id'].')" class="material-icons red-text">delete</i></td><td><i onClick="addIP('.$server['id'].')" class="material-icons green-text">add_box</i></td></tr>');
                    }
                }
                else{
                    echo('<tr class="center"><p class="center red-text">NO DATA IS AVAIBLE !</p></tr>');
                }
            ?>
                </tbody>
            </table>
            <!--<div class="addDataStore">

                <p><i class="material-icons grey-text left">keyboard_arrow_right</i> Add New DataStore For ID <span></span></p>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="value" id="value" required />
                    <label for="value">Value</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="space" id="space" required />
                    <label for="space" >Space</label>
                </div>

                <div class="input-field form-group">
                    <select id="testSelect">
                        <option value="1" disabled selected="selected">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <label>Default</label>
                </div>

                <div class="divider"></div>
                <div class="input-field form-group">
                    <a class="btn pink left" href="server.php">Back to Add Servers</a>
                    <button class="btn btn-success right">Save DataStore</button>
                    <a style="margin-right: 20px;" class="btn btn-success right" href="complete.php">Finish & Next Step</a>
                </div>
            </div>-->
            <div class="addIP">

                <p>Add New IP Address For ID <span></span></p>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="fromip" id="fromip" required />
                    <label for="fromip">FROM :</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="toip" id="toip" required />
                    <label for="toip" >TO :</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="gateway" id="gateway" required />
                    <label for="gateway">Gateway</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="netmask" id="netmask" required />
                    <label for="netmask" >Netmask</label>
                </div>

                <div class="input-field form-group required">
                    <input class="form-control validate" type="text" name="macaddress" id="macaddress" required />
                    <label for="macaddress" >Mac Address</label>
                </div>

                <div class="input-field form-group">
                    <select>
                        <option value="1" disabled selected="selected">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <label>Public</label>
                </div>

                <div class="divider"></div>
                <div class="input-field form-group">
                    <a class="btn pink left" href="server.php">Back to Add Servers</a>
                    <button class="btn btn-success right">Save IP Address</button>
                    <a style="margin-right: 20px;" class="btn btn-success right" href="complete.php">Finish & Next Step</a>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function (e) {
       $('select').material_select();
    });
    function reloadPage() {
        location.reload();
    }
    function deleteServer(id) {
        $.ajax({
            url: "src/datastore.php",
            type: "post",
            data: {
                method: 'delete-server',
                id: id
            },
            success: function (response) {
                if(response == 1){
                    var $toastContent = $('<span class="rtl center">Server Deleted Successfully</span>');
                    Materialize.toast($toastContent, 5000, 'green');
                    $("tr#"+id+"").remove();
                }
                else{
                    var $toastContent = $('<span class="rtl center">An error occurred during delete the server , Please call support.</span>');
                    Materialize.toast($toastContent, 5000, 'red');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var $toastContent = $('<span class="rtl center">An error occurred during send the data , Please call support.</span>');
                Materialize.toast($toastContent, 5000, 'red');
            }
        });
    }
    function addDataStore(id) {
        $('.addDataStore p span').html(id);
        $('.addIP').slideUp();
        $('.addDataStore').slideDown();
        $('.addDataStore button').on("click",function (e) {
            $.ajax({
                url: "src/datastore.php",
                type: "post",
                data: {
                    id: id,
                    value: $('input#value').val(),
                    space: $('input#space').val(),
                    defalt: $('.addDataStore select').find(":selected").val()
                },
                success: function (response) {
                    if(response == 1){
                        var $toastContent = $('<span class="rtl center">DataStore Added Successfully</span>');
                        Materialize.toast($toastContent, 5000, 'green');
                        $('input').val('');
                        $('select').val('1');
                        $('.valid').removeClass('valid');
                        $('select').material_select();
                    }
                    else{
                        var $toastContent = $('<span class="rtl center">An error occurred during add the dataStore , Please call support.</span>');
                        Materialize.toast($toastContent, 5000, 'red');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var $toastContent = $('<span class="rtl center">An error occurred during send the data , Please call support.</span>');
                    Materialize.toast($toastContent, 5000, 'red');
                }
            });
        });
    }
    function addIP(id) {
        $('.addIP p span').html(id);
        $('.addDataStore').slideUp();
        $('.addIP').slideDown();
        $('.addIP button').on("click",function (e) {
            $.ajax({
                url: "src/datastore.php",
                type: "post",
                data: {
                    id: id,
                    from_ip: $('input#fromip').val(),
                    to_ip: $('input#toip').val(),
                    gateway: $('input#gateway').val(),
                    netmask: $('input#netmask').val(),
                    mac_address: $('input#macaddress').val(),
                    public: $('.addIP select').find(":selected").val()
                },
                success: function (response) {
                    if(response == 1){
                        var $toastContent = $('<span class="rtl center">IP Added Successfully</span>');
                        Materialize.toast($toastContent, 5000, 'green');
                        $('input').val('');
                        $('select').val('1');
                        $('.valid').removeClass('valid');
                        $('select').material_select();
                    }
                    else{
                        var $toastContent = $('<span class="rtl center">An error occurred during add the ip , Please call support.</span>');
                        Materialize.toast($toastContent, 5000, 'red');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var $toastContent = $('<span class="rtl center">An error occurred during send the data , Please call support.</span>');
                    Materialize.toast($toastContent, 5000, 'red');
                }
            });
        });
    }
</script>
<?php
include_once ('views/footer.phtml');
?>