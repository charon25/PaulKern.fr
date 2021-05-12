<?php 

require('utils/visits.php');

require('utils/bdd.php');
require('utils/markdown.php');
require('utils/constants.php');
require('utils/functions.php');

$general_data = get_db_data_from_key($bdd, 'general', 1)[0];
$experiences_pro_data = get_db_data_from_key($bdd, 'pro', 3);
$experiences_extra_data = get_db_data_from_key($bdd, 'extra', 3);

$projects_perso_data = get_db_data_from_key($bdd, 'perso', 3);
$projects_sco_data = get_db_data_from_key($bdd, 'sco', 3);

$skills_data = get_db_data_from_key($bdd, 'skill', -1);

$contests_data = get_db_data_from_key($bdd, 'contest', -1);

 ?>

<?php 


// require('path/to/PHPMailer/src/Exception.php');
// require('path/to/PHPMailer/src/PHPMailer.php');

if (isset($_POST[$MAIL_SUBMIT])) {

}

 ?>

<!DOCTYPE html>
<html>
<?php include('utils/head.php'); print_head(array('title' => "Page d'accueil")); ?>
<body>


<?php //include('utils/header.php'); print_header(); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Paul Kern</h1>
				<h3 class="titre-principal">Etudiant en Génie Electrique à l'INSA Strasbourg</h3>
			</div>
			<div class="col-sm-2"></div>
			<div class="col-sm-4 txt-droite">
				<a href="<?php echo $general_data[$GEN_CV]; ?>" class="btn btn-primary bouton margetop25 width200">Télécharger mon CV</a>
			</div>
			<div class="col-sm-4">
				<a class="btn btn-primary bouton margetop25 width200" onclick="show_hide_contact_form();">Me contacter</a>
			</div>
			<div class="margebot45"></div>
		</div>
	</div>
</section>

<section id="contact" class="gray-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="margetop25">Formulaire de contact</h2>
				<p class="gris">Aucune information entrée ici ne sera stockée sur le site.</p>
				<div class="margebot45"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<form method="post" action="#contact">
					<p class="fw-bold">Nom : <input type="text" name="<?php echo $MAIL_NAME ?>" class="form-control"></p>
					<p class="fw-bold">Organisme : <input type="text" name="<?php echo $MAIL_ORG ?>" class="form-control"></p>
					<p class="fw-bold">Adresse e-mail : <input type="text" name="<?php echo $MAIL_EMAIL ?>" class="form-control"></p>
					<p class="fw-bold">Objet : <input type="text" name="<?php echo $MAIL_OBJECT ?>" class="form-control"></p>
					<p class="fw-bold">Message : <textarea name="<?php echo $MAIL_MESSAGE; ?>" class="form-control" rows=10></textarea></p>
					<div class="text-center">
						<input type="submit" name="<?php echo $MAIL_SUBMIT; ?>" class="btn btn-primary bouton" value="Envoyer">
					</div>
				</form>
			</div>
			<div class="margebot25"></div>
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
			<?php 
				$count = count($experiences_pro_data);
				if ($count > 0) {
					$col_width = intdiv(12, $count);
					foreach ($experiences_pro_data as $key => $experience) {
						$bordures = array();
						if ($key < $count-1) {
							$bordures[] = 'bordure-right';
						}
						if ($key > 0) {
							$bordures[] = 'bordure-left';
						}
						echo '<div class="text-center col-sm-' . $col_width . ' ' . implode(' ', $bordures) . '"><a class="void" href="exp_pro#exp-' . $key . '">';
						echo '<img src="' . $experience[$EXP_MAIN_IMG] . '" class="img-thumbnail-mod-height" alt="Logo ' . $experience[$EXP_NAME] . '" height="100">';
						echo '<p class="margetop25"><span class="bleu-big">' . $experience[$EXP_DATE_TXT] . '</span><br>';
						echo '<span class="fw-bold">' . $experience[$EXP_NAME] . '</span><br>';
						echo $experience[$EXP_TITLE] . '</p>';
						echo '<div class="gris">' . markdown_to_html($experience[$EXP_SHORT_DESC]) . '</div>';
						echo '</a></div><hr class="hr">';
					}
				}
			 ?>
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
			<?php 
				foreach ($skills_data as $key => $skill) {
					if ($skill[$SKI_TYPE] == 'programming' && $skill[$SKI_LEVEL] == 'master') {
						echo '<div class="text-center col-sm-2">';
						echo '<img src="' . $skill[$SKI_IMG] . '" alt="' . $skill[$SKI_NAME] . '" height="65" class="logo">';
						echo '<p class="bleu">' . $skill[$SKI_NAME] . '</p>';
						echo '</div>';
					}
				}
				echo '<div class="margebot25"></div>';
			 ?>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4 class="sous-titre">Niveau intérmédiaire</h4>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach ($skills_data as $key => $skill) {
					if ($skill[$SKI_TYPE] == 'programming' && $skill[$SKI_LEVEL] == 'inter') {
						echo '<div class="text-center col-sm-2">';
						echo '<img src="' . $skill[$SKI_IMG] . '" alt="' . $skill[$SKI_NAME] . '" height="65" class="logo">';
						echo '<p class="bleu">' . $skill[$SKI_NAME] . '</p>';
						echo '</div>';
					}
				}
				echo '<div class="margebot25"></div>';
			 ?>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h4 class="sous-titre">Débutant</h4>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach ($skills_data as $key => $skill) {
					if ($skill[$SKI_TYPE] == 'programming' && $skill[$SKI_LEVEL] == 'begin') {
						echo '<div class="text-center col-sm-2">';
						echo '<img src="' . $skill[$SKI_IMG] . '" alt="' . $skill[$SKI_NAME] . '" height="65" class="logo">';
						echo '<p class="bleu">' . $skill[$SKI_NAME] . '</p>';
						echo '</div>';
					}
				}
				echo '<div class="margebot25"></div>';
			 ?>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre">Logiciels & OS</h3>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach ($skills_data as $key => $skill) {
					if ($skill[$SKI_TYPE] == 'software') {
						echo '<div class="text-center col-sm-2">';
						echo '<img src="' . $skill[$SKI_IMG] . '" alt="' . $skill[$SKI_NAME] . '" height="65" class="logo">';
						echo '<p class="bleu">' . $skill[$SKI_NAME] . '</p>';
						echo '</div>';
					}
				}
				echo '<div class="margebot25"></div>';
			 ?>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre">Autres compétences</h3>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach ($skills_data as $key => $skill) {
					if ($skill[$SKI_TYPE] == 'other') {
						echo '<div class="text-center col-sm-2">';
						echo '<img src="' . $skill[$SKI_IMG] . '" alt="' . $skill[$SKI_NAME] . '" height="65" class="logo">';
						echo '<p class="bleu">' . $skill[$SKI_NAME] . '</p>';
						echo '</div>';
					}
				}
				echo '<div class="margebot25"></div>';
			 ?>
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
			<?php 
				$count = count($projects_sco_data);
				if ($count > 0) {
					$col_width = intdiv(12, $count);
					foreach ($projects_sco_data as $key => $project) {
						$bordures = array();
						if ($key < $count-1) {
							$bordures[] = 'bordure-right';
						}
						if ($key > 0) {
							$bordures[] = 'bordure-left';
						}
						if ($project[$PRO_URL] != "") {
							$lien = '<a href="' . $project[$PRO_URL] . '" class="btn btn-primary bouton btn-sm">Lien du projet</a>';
						} else {
							$lien = '';
						}
						echo '<div class="text-center col-sm-' . $col_width . ' ' . implode(' ', $bordures) . '"><a class="void" href="projects_sco#pro-' . $key . '">';
						echo '<img src="' . $project[$PRO_MAIN_IMG] . '" class="img-thumbnail-mod-height" alt="Logo ' . $project[$PRO_TITLE] . '" height="150">';
						echo '<p class="margetop25"><span class="bleu-big">' . $project[$PRO_DATE_TXT] . '</span><br>';
						echo '<span class="fw-bold">' . $project[$PRO_TITLE] . '</span><br></p>';
						echo '<div class="gris">' . markdown_to_html($project[$PRO_SHORT_DESC]) . $lien . '</div>';
						echo '</a></div><hr class="hr">';
					}
				}
			 ?>
			<!--<div class="text-center col-sm-4 bordure-right" style="padding-left: 10px">
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
			</div>-->
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
			<?php 
				$count = count($projects_perso_data);
				if ($count > 0) {
					$col_width = intdiv(12, $count);
					foreach ($projects_perso_data as $key => $project) {
						$bordures = array();
						if ($key < $count-1) {
							$bordures[] = 'bordure-right';
						}
						if ($key > 0) {
							$bordures[] = 'bordure-left';
						}
						if ($project[$PRO_URL] != "") {
							$lien = '<a href="' . $project[$PRO_URL] . '" class="btn btn-primary bouton btn-sm">Lien du projet</a>';
						} else {
							$lien = '';
						}
						echo '<div class="text-center col-sm-' . $col_width . ' ' . implode(' ', $bordures) . '"><a class="void" href="projects_perso#pro-' . $key . '">';
						echo '<img src="' . $project[$PRO_MAIN_IMG] . '" class="img-thumbnail-mod-height" alt="Logo ' . $project[$PRO_TITLE] . '" height="150">';
						echo '<p class="margetop25"><span class="bleu-big">' . $project[$PRO_DATE_TXT] . '</span><br>';
						echo '<span class="fw-bold">' . $project[$PRO_TITLE] . '</span><br></p>';
						echo '<div class="gris">' . markdown_to_html($project[$PRO_SHORT_DESC]) . $lien . '</div>';
						echo '</div><hr class="hr">';
					}
				}
			 ?>
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
			<?php 

				$count = count($experiences_extra_data);
				if ($count > 0) {
					$col_width = intdiv(12, $count);
					foreach ($experiences_extra_data as $key => $experience) {
						$bordures = array();
						if ($key < $count-1) {
							$bordures[] = 'bordure-right';
						}
						if ($key > 0) {
							$bordures[] = 'bordure-left';
						}
						echo '<div class="text-center col-sm-' . $col_width . ' ' . implode(' ', $bordures) . '"><a class="void" href="exp_extra#exp-' . $key . '">';
						echo '<img src="' . $experience[$EXP_MAIN_IMG] . '" class="img-thumbnail-mod-height" alt="Logo ' . $experience[$EXP_NAME] . '" height="150">';
						echo '<p class="margetop25"><span class="bleu-big">' . $experience[$EXP_DATE_TXT] . '</span><br>';
						echo '<span class="fw-bold">' . $experience[$EXP_NAME] . '</span><br>';
						echo $experience[$EXP_TITLE] . '<br>';
						echo '<span class="gris">' . markdown_to_html($experience[$EXP_SHORT_DESC]) . '</span></p>';
						echo '</a></div><hr class="hr">';
					}
				}
			 ?>
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
			<?php 
				foreach ($contests_data as $key => $contest) {
					echo '<div class="col-sm-2 bordure-right">';
					echo '<p class="bleu-big">' . $contest[$CON_DATE_TXT] . '</p>';
					echo '<p class="fw-bold">' . $contest[$CON_NAME] . '</p>';
					echo '<p>' . markdown_to_html($contest[$CON_DESC]) . '</p>';
					echo '</div>';
				}
			 ?>
		</div>
	</div>
</section>

<?php include('utils/footer.php'); print_footer(); ?>

</body>
</html>

<script type="text/javascript">
	function show_hide_contact_form() {
		var contact_section = document.getElementById('contact');
		console.log(contact_section.style.display)
		if (contact_section.style.display != 'none') {
			contact_section.style.display = 'none';
		} else {
			contact_section.style.display = 'block';
		}
		console.log("ici");
	}
	show_hide_contact_form();
</script>
<script type="text/javascript" src="js/no_js.js"></script>
