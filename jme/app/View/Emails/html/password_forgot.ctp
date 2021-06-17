<?php
	$pclass = 'font-weight: bold;';
	$bordertop = 'border-top: 2px solid #E9E9E9;';
	$followlbl = 'text-align: left;float: left;margin-left: 20px;';
	$bottom = 'background-color:#FDFDFD;height:70px;text-align: right;padding-top: 10px;';
	$span = 'text-align: left;float:left;margin-left: 20px;margin-right: 20px;';
	$p = 'text-align: left;margin-left: 20px;margin-right: 20px;';
?>

<table border="0" cellpadding="0" cellspacing="0" width="598px" style="padding: 0;margin: 0;font-family:arial,sans-serif;font-size: 14px;text-align:left;color: #222;background-color: #fff;">
	<tr>
		<td align="center" valign="top">
			<p style="<?php echo $pclass; echo $p; ?>">Hello <?php echo $data['username'] ?>,</p>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top">
			<p style="<?php echo $p; ?>">Keep this mail for reference. Here are your login details:</p>
		</td>
	</tr>

	<tr>
		<td align="center" valign="top" style="text-align:left; padding-left:10px;">
			<span style="<?php echo $span; ?>">Email : <?php echo $data['email'] ?></span>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" style="text-align:left; padding-left:10px;">
			<span style="<?php echo $span; ?>">Password : <?php echo $data['password'] ?></span>
		</td>
	</tr>
	<tr>
		<td align="center" valign="top">
			<p style="<?php echo $p; ?>">Looking forward to hearing from you!</p>
		</td>
	</tr>
	<tr>
		<td>
			<p style="<?php echo $p; ?>">
				Thanks !				
			</p>
		</td>
	</tr>
</table>