<?php 

require('utils/bdd.php');
require('utils/markdown.php');
require('utils/constants.php');


$request = $bdd->query('SELECT * FROM `pk_data` WHERE `type`="general"');
$general_data = json_decode($request->fetch()['data'], TRUE);

//

 ?>

<!DOCTYPE html>
<html>
<?php include('utils/head.php'); print_head(array('title' => "Page d'accueil")); ?>
<body>


<?php include('utils/header.php'); print_header(); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Paul Kern</h1>
				<h3 class="titre-principal">Etudiant en Génie Electrique à l'INSA Strasbourg</h3>
				<a href="<?php echo $general_data[$GEN_CV]; ?>" class="btn btn-primary bouton margetop25">Télécharger mon CV</a>
				<div class="margebot45"></div>
			</div>
		</div>
	</div>
</section>

<section id="presentation" class="even-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="titre">Qui suis-je ?</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 text-center">
				<img id="profil-pic" src="<?php echo $general_data[$GEN_PHOTO]; ?>" width="200" height="200" class="img-thumbnail-mod-height margebot25" alt="Photo profil">
			</div>
			<div class="col-sm-9">
				<?php echo markdown_to_html($general_data[$GEN_PRES_TEXT]); ?>
				<div class="text-center">
					<a href="mailto:<?php echo $general_data[$GEN_LINK_MAIL]; ?>" target="_blank"><i class="fas fa-envelope fa-4x icone"></i></a>
					<a href="<?php echo $general_data[$GEN_LINK_LINKEDIN]; ?>" target="_blank"><i class="fab fa-linkedin fa-4x icone"></i></a>
					<a href="<?php echo $general_data[$GEN_LINK_GITHUB]; ?>" target="_blank"><i class="fab fa-github fa-4x icone"></i></a>
					<a href="<?php echo $general_data[$GEN_LINK_ITCHIO]; ?>"target="_blank"><i class="fab fa-itch-io fa-4x icone"></i></a>
				</div>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<section id="education" class="odd-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre">Formation</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 text-center bordure-right">
				<img src="img/logo_insa.svg" class="img-thumbnail-mod-height" alt="Logo INSA Strasbourg" height=60>
				<p class="margetop25"><span class="bleu-big">2016 - 2021</span><br>
				<span class="fw-bold">INSA Strasbourg</span><br>
				Diplôme d'Ingénieur en Génie Electrique</p>
			</div><hr class="hr">
			<div class="col-sm-6 text-center bordure-left">
				<img src="img/logo_saint_michel.png" class="img-thumbnail-mod-height" alt="Logo Saint-Michel" height=60>
				<p class="margetop25"><span class="bleu-big">2016</span><br>
				<span class="fw-bold">Lycée Saint-Michel des Batignolles</span><br>
				Baccalauréat Général S - Spé Maths - Mention Très Bien</p>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<section id="experiences-pro" class="even-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre"><a href="exp_pro">Expériences professionnelles</a></h2>
			</div>
		</div>
		<div class="row">
			<div class="text-center col-sm-4 bordure-right">
				<img src="img/logo_voxcare.svg" class="img-thumbnail-mod-height" alt="Logo Vox Care" height=60>
				<p class="margetop25"><span class="bleu-big">Février - Août 2021</span><br>
				<span class="fw-bold">Vox Care</span><br>
				Stage de fin d'études</p>
				<p class="justif gris">Amélioration du produit principal : Serena, un assistant vocal à destinations des établissements de santé.<br>
				Plusieurs sujets abordés : reconnaissance vocale, débruitage d'un signal, détection Bluetooth...</p>
			</div><hr class="hr">
			<div class="text-center col-sm-4 bordure-left bordure-right">
				<img src="img/logo_kpu.png" class="img-thumbnail-mod-height" alt="Logo KPU" height=60>
				<p class="margetop25"><span class="bleu-big">Juin - Août 2019</span><br>
				<span class="fw-bold">Korea Polytechnic University</span><br>
				Stage de découverte culturelle</p>
				<p class="justif gris">Self-learning en Arduino et programmation Web.</p>
			</div><hr class="hr">
			<div class="text-center col-sm-4 bordure-left">
				<img src="img/logo_kpu.png" class="img-thumbnail-mod-height" alt="Logo Cordon" height=60>
				<p class="margetop25"><span class="bleu-big">Juillet 2017</span><br>
				<span class="fw-bold">Cordon CMS</span><br>
				Stage ouvrier</p>
				<p class="justif gris">Traitement des télés</p>
			</div>
		</div>
		<div class="margebot25"></div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<a class="btn btn-primary bouton" href="exp_pro">Voir toutes les expériences</a>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<section id="skills" class="odd-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre">Compétences</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre">Langues</h3>
			</div>
		</div>
		<div class="row">
			<div class="text-center col-sm-3">
				<img src="img/flags/flag_fr.svg" alt="Français" height="65" class="img-thumbnail-mod-height logo">
				<p class="bleu">Langue maternelle</p>
			</div>
			<div class="text-center col-sm-3">
				<img src="img/flags/flag_en.svg" alt="Anglais" height="65" class="img-thumbnail-mod-height logo">
				<p class="bleu">Courant - C1 (TOEIC : 990/990)</p>
			</div>
			<div class="text-center col-sm-3">
				<img src="img/flags/flag_de.svg" alt="Allemand" height="65" class="img-thumbnail-mod-height logo">
				<p class="bleu">Bases - A2</p>
			</div>
			<div class="text-center col-sm-3">
				<img src="img/flags/flag_kr.svg" alt="Coréen" height="65" class="img-thumbnail-mod-height logo">
				<p class="bleu">Notions - A1</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre">Langages de programmation</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4 class="sous-titre">Maîtrisés</h4>
			</div>
		</div>
		<div class="row">
			<div class="text-center col-sm-2">
				<img src="img/logo_python.svg" alt="Python" height="65" class="logo">
				<p class="bleu">Python 3</p>
			</div>
			<div class="text-center col-sm-2">
				<img src="img/logo_vb.svg" alt="VB.NET" height="65" class="logo">
				<p class="bleu">Visual Basic .NET</p>
			</div>
			<div class="margebot25"></div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4 class="sous-titre">Niveau intérmédiaire</h4>
			</div>
		</div>
		<div class="row">
			<div class="text-center col-sm-2">
				<img src="img/logo_cpp.svg" alt="C++" height="65" class="logo">
				<p class="bleu">C++</p>
			</div>
			<div class="text-center col-sm-2">
				<img src="img/logo_vhdl.png" alt="VHDL" height="65" class="logo">
				<p class="bleu">VHDL</p>
			</div>
			<div class="margebot25"></div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4 class="sous-titre">Débutant</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre">Logiciels & OS</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre">Autres compétences</h3>
			</div>
		</div>
	</div>
</section>

<section id="projects" class="even-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre">Projets</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre">Scolaires</h3>
			</div>
		</div>
		<div class="row">
			<div class="text-center col-sm-4 bordure-right" style="padding-left: 10px">
				<img src="img/logo_voxcare.svg" class="img-thumbnail-mod-height" alt="Logo Vox Care" height=60>
				<p class="margetop25"><span class="bleu-big">Septembre 2020 - Février 2021</span><br>
				<span class="fw-bold">Station météo connectée</span></p>
				<p class="justif gris">Mesures de grandeurs météos toutes les 10 minutes tous les jours, et récupération de celles-ci par SMS, Internet ou radio.</p>
			</div><hr class="hr">
			<div class="text-center col-sm-4 bordure-left bordure-right">
				<img src="img/logo_kpu.png" class="img-thumbnail-mod-height" alt="Logo KPU" height=60>
				<p class="margetop25"><span class="bleu-big">Septembre 2020 - Janvier 2021</span><br>
				<span class="fw-bold">Bouée <span class="italique">Men Over Board</span> autonome</span></p>
				<p class="justif gris">Projet réalisé pour l'entreprise <a href="https://www.phr-yacht-design.com/">PHR Yacht Design</a>, qui consistait à étudier la faisabilité d'une bouée devant récupérer les personnes tombées à la mer de façon autonome.</p>
			</div><hr class="hr">
			<div class="text-center col-sm-4 bordure-left">
				<img src="img/logo_kpu.png" class="img-thumbnail-mod-height" alt="Logo KPU" height=60>
				<p class="margetop25"><span class="bleu-big">Septembre 2020 - Janvier 2021</span>
				<span class="fw-bold">Bouée <span class="italique">Men Over Board</span> autonome</span></p>
				<p class="justif gris">Projet réalisé pour l'entreprise <a href="https://www.phr-yacht-design.com/">PHR Yacht Design</a>, qui consistait à étudier la faisabilité d'une bouée devant récupérer les personnes tombées à la mer de façon autonome.</p>
			</div>
		</div>
		<div class="margebot25"></div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<a class="btn btn-primary bouton" href="projects_sco">Voir toutes les projets scolaires</a>
			</div>
		</div>		
		<div class="margebot45"></div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre">Personnels</h3>
			</div>
		</div>
		<div class="row">
			<div class="text-center col-sm-6 bordure-right">
				<img src="img/logo_voxcare.svg" class="img-thumbnail-mod-height" alt="Logo Vox Care" height=60>
				<p class="margetop25"><span class="bleu-big">Septembre 2020 - Février 2021</span><br>
				<span class="fw-bold">Station météo connectée</span><br></p>
				<p class="justif gris">Mesures de grandeurs météos toutes les 10 minutes tous les jours, et récupération de celles-ci par SMS, Internet ou radio.</p>
			</div><hr class="hr">
			<div class="text-center col-sm-6 bordure-left">
				<img src="img/logo_kpu.png" class="img-thumbnail-mod-height" alt="Logo KPU" height=60>
				<p class="margetop25"><span class="bleu-big">Septembre 2020 - Janvier 2021</span><br>
				<span class="fw-bold">Bouée <span class="italique">Men Over Board</span> autonome</span></p>
				<p class="justif gris">Projet réalisé pour l'entreprise <a href="https://www.phr-yacht-design.com/">PHR Yacht Design</a>, qui consistait à étudier la faisabilité d'une bouée devant récupérer les personnes tombées à la mer de façon autonome.</p>
			</div>
		</div>
		<div class="margebot25"></div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<a class="btn btn-primary bouton" href="projects_perso">Voir toutes les projets personnels</a>
			</div>
		</div>
		<div class="margebot25"></div>
</section>

<section id="experiences-perso" class="odd-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre">Expériences extra-professionnelles</h2>
			</div>
		</div>
		<div class="row">
			<div class="text-center col-sm-6 bordure-right">
				<a href="https://charon25.itch.io/spalt"><img src="img/img_spalt.png" class="img-thumbnail-mod-height" alt="Logo KPU" height=150></a>
				<p class="margetop25"><span class="bleu-big">Mars 2021</span><br>
				<span class="fw-bold">MiniJam 76</span><br>
				Jeu réalisé de A à Z en 72h en Python<br>
				<a href="https://charon25.itch.io/spalt">Page du jeu sur itch.io</a></p>
			</div><hr class="hr">
			<div class="text-center col-sm-6 bordure-left">
				<a href="https://www.sauas.fr/"><img src="img/img_sauas.png" class="img-thumbnail-mod-height" alt="Logo SAUAS" height=150></a>
				<p class="margetop25"><span class="bleu-big">Juin - Octobre 2019 & Septembre - Novembre 2020</span><br>
				<span class="fw-bold">Société des Amis des Universités de l'Académie de Strasbourg</span><br>
				Réalisation du site Web de l'association<br><a href="https://www.sauas.fr/">sauas.fr</a></p>
			</div>
		</div>
		<div class="margebot25"></div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<a class="btn btn-primary bouton" href="exp_extra">Voir toutes les expériences</a>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<section id="contests" class="even-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre">Compétitions</h2>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-sm-2 bordure-right">
				<p class="bleu-big">Avril 2021</p>
				<p class="fw-bold">Google Code Jam</p>
				<p>Round 2</p>
			</div>
			<div class="col-sm-2 bordure-right bordure-left">
				<p class="bleu-big">Février 2021</p>
				<p class="fw-bold">Google Hash Code</p>
				<p>3000<sup>e</sup>/10000<br>Top <span class="bleu">30 %</span></p>
			</div>
			<div class="col-sm-2 bordure-left">
				<p class="bleu-big">Avril 2021</p>
				<p class="fw-bold">Google Code Jam</p>
				<p>Round 2</p>
			</div>
		</div>
	</div>
</section>

<?php include('utils/footer.php'); print_footer(); ?>

</body>
</html>

<script type="text/javascript" src="js/no_js.js"></script>
