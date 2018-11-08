<?php use yii\helpers\Html;

$_connect = ($e === 'connect' ? false : true);
$_ssh = ($e === 'ssh' ? false : true);
$_datastore = ($e === 'datastore' ? false : true);
$_template = ($e === 'template' ? false : true);

$license = (!empty($license->days) ? $license->days : 0);
$expired = (!empty($license->expired) && $license->expired ? true : false);
?>
<!-- content -->
<div class="content">     
    <div class="col-md-6 pull-left">
		<table class="table table-bordered">
<?php if(!empty($info)) {?>
				<tr>
					<td width="150">Server ID</td><td><?php echo $server->id;?></td>
				</tr>
				<tr>
					<td width="150">IP Address</td><td><?php echo $server->ip;?></td>
				</tr>
				<tr>
					<td width="150">RAM</td><td><?php echo number_format($info[0] / 1024 / 1024 / 1024);?> GB</td>
				</tr>
				<tr>
					<td width="150">RAM Usage</td><td><?php echo number_format($info[4] / 1024);?> GB</td>
				</tr>
				<tr>
					<td width="150">CPU Ferqunce</td><td><?php echo $info[1] * $info[2];?></td>
				</tr>
				<tr>
					<td width="150">CPU Cores</td><td><?php echo $info[2];?></td>
				</tr>
				<tr>
					<td width="150">CPU Usage</td><td><?php echo $info[3];?></td>
				</tr>

				<tr>
					<td width="150">CPU Model</td><td><?php echo $cpu;?></td>
				</tr>
<?php }?>
                <tr>
					<td width="150">Api Status</td><td><?php echo ($connect ? 'OK' : '<a  href="https://wiki.autovm.net/index.php/%D8%AE%D8%B7%D8%A7_%D8%AF%D8%B1_%D8%A7%D8%B1%D8%AA%D8%A8%D8%A7%D8%B7_%D8%A8%D8%A7_API">There is an error, Read More ...</a>');?></td>
				</tr>
				
				<?php if($connect) {?>
                <tr>
					<td width="150">Licence Time</td><td><?php echo $license;?> Days <?php echo ($expired ? ' <font color="red">Licence has Expired</font>' : '');?></td>
				</tr>
				<tr>
					<td width="150">Server Connection</td><td><?php echo ($_connect ? 'OK' : '<a  href="https://wiki.autovm.net/index.php/%D8%AE%D8%B7%D8%A7_%D8%AF%D8%B1_%D9%87%D9%86%DA%AF%D8%A7%D9%85_%D8%A7%D8%AA%D8%B5%D8%A7%D9%84_%D8%A8%D9%87_%D8%B3%D8%B1%D9%88%D8%B1">There is an error, Read More ...</a>');?></td>
				</tr>
				<tr>
					<td width="150">Server SSH</td><td><?php echo (!$_connect ? 'NONE' : ($_ssh ? 'OK' : '<a href="https://wiki.autovm.net/index.php/%D8%AE%D8%B7%D8%A7_%D8%AF%D8%B1_%D8%A7%D8%AA%D8%B5%D8%A7%D9%84_%D8%A8%D9%87_%D8%B3%D8%B1%D9%88%DB%8C%D8%B3_SSH">There is an error, Read More ...</a>'));?></td>
				</tr>
				<tr>
					<td width="150">Check Datastores</td><td><?php echo (!$_connect || !$_ssh ? 'NONE' : ($_datastore ? 'OK' : '<a href="https://wiki.autovm.net/index.php/%D8%AE%D8%B7%D8%A7_%D8%AF%D8%B1_%D8%A8%D8%B1%D8%B1%D8%B3%DB%8C_%D9%88%D8%B6%D8%B9%DB%8C%D8%AA_Datastores">There is an error, Read More ...</a>' ));?></td>
				</tr>
				<tr>
					<td width="150">Check Templates</td><td><?php echo (!$_connect || !$_ssh || !$_datastore ? 'NONE' : ($_template ? 'OK' : '<a href="https://wiki.autovm.net/index.php/%D8%AE%D8%B7%D8%A7_%D8%AF%D8%B1_%D8%A8%D8%B1%D8%B1%D8%B3%DB%8C_templates">Could not found ' . $dist . ', Read More ...</a>'));?></td>
				</tr>
				<?php }?>
			</body>
		</table>
    </div>
</div>
<!-- / content -->