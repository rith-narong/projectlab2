<?php
// Get selected aside from the URL
$aside = isset($_GET['aside']) ? $_GET['aside'] : '';

// Modify query to filter by aside if selected
$condition = !empty($aside) ? "aside = ?" : "";
$params = !empty($aside) ? [$aside] : [];

$result = dbSelect("aside", "*", $condition, $params);
$num = count($result);
?>

<aside id="fh5co-hero" class="js-fullheight">
	<div class="flexslider js-fullheight">
		<ul class="slides">
			<?php
			foreach ($result as $row) {
			?>

				<li style="background-image: url(images/<?=$row['image']?>);">
					<div class="overlay-gradient"></div>
					<div class="container">
						<div class="col-md-6 col-md-offset-3 col-md-pull-3 js-fullheight slider-text">
							<div class="slider-text-inner">
								<div class="desc">

									<h2><?=$row['title']?></h2>
									<p><?=$row['des']?></p>
									<p><a href="index.php?p=product" class="btn btn-primary btn-outline btn-lg">SHOP</a></p>
								</div>
							</div>
						</div>
					</div>
				</li>
			<?php
			}
			?>


		</ul>
	</div>
</aside>