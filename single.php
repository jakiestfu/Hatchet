<?PHP require('includes/hacker.php'); $hacker = new Hacker(); ?><!DOCTYPE html>
<html>
	<?PHP require('includes/partials/head.php'); ?>
	<body>
		
		<!-- Make sure all your bars are the first things in your <body> -->
		<header class="bar-title">
			<a class="button-prev" href="javascript:history.go(-1)">Back</a>
			<h1 class="title">Hatchet</h1>
			<a class="button-next" target="_blank" href="<?PHP echo base64_decode($_GET['url']); ?>">Out</a>
		</header>
		
		<!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
		<div class="content single-content">
		    
			<iframe src="<?PHP echo base64_decode($_GET['url']); ?>">
		
		</div>
		
	</body>
</html>