<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>404 Error</title>
	<?php
		// CSS Files
		echo $this->Html->css('style.css');
		echo $this->Html->css('reset.css');
	?>
</head>
<body>
	<noscript>Your browser does not support JavaScript!</noscript>
	<section id="wrapper">
		<header>
			<h1><a href="<?php echo $this->webroot."admin/videos"; ?>" title="CV Studio">CV Studio</a></h1>
		</header>
		<section id="contentContainer">
			<section style="float:left; font-family:calibri; font-size:30px; height:300px; margin:50px 0 0 0;">
				<p>404 Error - Page Not Found</p>
			</section>
		</section>
		<?php echo $this->element('footer'); ?>
	</section>
</body>
</html>
