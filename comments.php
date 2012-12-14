<?PHP require('includes/hacker.php'); $hacker = new Hacker(); ?><!DOCTYPE html>
<html>
	<?PHP require('includes/partials/head.php'); ?>
	<body>
		
		<!-- Make sure all your bars are the first things in your <body> -->
		<header class="bar-title">
			<a class="button-prev" href="javascript:history.go(-1)">Back</a>
			<h1 class="title">Hatchet</h1>
		</header>
		
		<!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
		<div class="content comment-content">
		    
			<?PHP echo $hacker->comments($_GET['id']); ?>
		
		</div>
		
	</body>
</html>