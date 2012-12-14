<?PHP require('includes/hacker.php'); $hacker = new Hacker(); $feed = $hacker->feed(); ?><!DOCTYPE html>
<html>
	<?PHP require('includes/partials/head.php'); ?>
	<body data-home="true">
		
		<!-- Make sure all your bars are the first things in your <body> -->
		<header class="bar-title">
			
				<h1 class="title">
					<div class="title-rel-wrap">
						<a href="#feeds" id="title">Hatchet<span>&#x25BC;</span></a>
						<a href="#" class="title-feed"><?PHP echo ucfirst($feed); ?><span></a>
					</div>
				</h1>
			
			<a class="button" href="#" id="reload">Reload</a>
		</header>
		
		<!-- Wrap all non-bar HTML in the .content div (this is actually what scrolls) -->
		<div class="content">
		    <ul class="list"></ul>
		</div>
		
		
		<div id="feeds" class="popover">
			<header class="popover-header">
				<a class="button" href="#">About</a>
				<h3 class="title">Select Feed</h3>
				<a class="button" href="#">Fork</a>
			</header>
			<ul class="list">
				<li class="active"><a href="#" data-feed="popular" class="anchor" data-ignore="push">Popular</a></li>
				<li><a href="#" data-feed="new" class="anchor" data-ignore="push">Newest</a></li>
			</ul>
		</div>
		
		<script type="text/javascript">
		
			var feed="<?PHP echo $feed; ?>", home_url = "<?PHP echo $hacker->home_url(); ?>";
			
		</script>
		
	</body>
</html>