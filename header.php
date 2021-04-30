<?php  ?>
<header>
	<div id="menu" class="container">
		<div id="menu-inside" class="fixed-top" style="background-color: white">
			<div id="b" class="row text-center">
				<div class="col-sm-12">
					<ul class="list-inline menu">
						<li class="list-inline-item menu-item"><a href="index" class="menu-lien"><i class="fas fa-home fa-1x"></i></a></li>
						<li class="list-inline-item menu-item"><a href="#presentation" class="menu-lien">Qui suis-je ?</a></li>
						<li class="list-inline-item menu-item"><a href="#education" class="menu-lien">Formation</a></li>
						<li class="list-inline-item menu-item"><a href="#experiences-pro" class="menu-lien">Expériences pro.</a></li>
						<li class="list-inline-item menu-item"><a href="#skills" class="menu-lien">Compétences</a></li>
						<li class="list-inline-item menu-item"><a href="#projects" class="menu-lien">Projets</a></li>
						<li class="list-inline-item menu-item"><a href="#experiences-perso" class="menu-lien">Expérience extra-pro.</a></li>
						<li class="list-inline-item menu-item"><a href="#contests" class="menu-lien">Compétition</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>


</header>
<div id="menu-top-margin"></div>
<div class="no-js" style="margin-top: 64px;"></div>

<script type="text/javascript">
	// Set the margin of the above div to the height of the menu
	var menuHeight = window.getComputedStyle(document.getElementById('menu-inside')).height;
	document.getElementById('menu-top-margin').style.marginTop = menuHeight;
</script>