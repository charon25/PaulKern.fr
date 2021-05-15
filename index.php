<?php 

session_start();

require('utils/visits.php');

require('utils/bdd.php');
require('utils/markdown.php');
require('utils/constants.php');
require_once('utils/functions.php');

$general_data = get_db_data_from_key($bdd, 'general', 1)[0];
$experiences_pro_data = get_db_data_from_key($bdd, 'pro', 3);
$experiences_extra_data = get_db_data_from_key($bdd, 'extra', 3);

$projects_perso_data = get_db_data_from_key($bdd, 'perso', 3);
$projects_sco_data = get_db_data_from_key($bdd, 'sco', 3);

$skills_data = get_db_data_from_key($bdd, 'skill', -1);

$contests_data = get_db_data_from_key($bdd, 'contest', -1);

 ?>

<?php 

if (isset($_POST['disconnect'])) {
	$_SESSION = array();
	session_destroy();
}

 ?>

<?php 


include('phpmailer/PHPMailer.php');
include('phpmailer/Exception.php');
include('phpmailer/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$was_sent = FALSE;
$clicked_send = FALSE;
if (isset($_POST[$MAIL_SUBMIT])) {
	$clicked_send = TRUE;
	if ($_POST[$MAIL_NAME] != '' && $_POST[$MAIL_EMAIL] != '' && $_POST[$MAIL_MESSAGE] != '') {
		require('bot/bot.php');
		send_contact_message_discord($_POST[$MAIL_NAME], $_POST[$MAIL_ORG], $_POST[$MAIL_EMAIL], $_POST[$MAIL_OBJECT], $_POST[$MAIL_MESSAGE]);
		$mail_body = '<h3>Formulaire de contact utilisé par <' . $_POST[$MAIL_NAME] . '> (' . $_POST[$MAIL_ORG] . ') le ' . date('d/m/Y') . ' à ' . date('H:i') . '</h3>';
		$mail_body = $mail_body . '<h3>Adresse mail entrée : \'' . $_POST[$MAIL_EMAIL] . '\'</h3><br>';
		$mail_body = $mail_body . '<p>' . str_replace("\n", "<br>", $_POST[$MAIL_MESSAGE]) . '</p>';

		$mail = new PhpMailer(TRUE);
		$mail->CharSet = 'UTF-8';
    	$mail->setFrom('contact@paulkern.fr', 'paulkern.fr');
    	$mail->addAddress('paul.kern.fr@gmail.com');
    	$mail->isHTML(true);
    	$mail->Subject = '[paulkern.fr] <' . $_POST[$MAIL_OBJECT] . '>';
    	$mail->Body = $mail_body;
    	if ($mail->send()) {
			$pos_result = "Message correctement envoyé !";
			$was_sent = TRUE;
    	} else {
			$neg_result = "Une erreur est survenue pendant l'envoi du message, veuillez réessayer s'il vous plait. Si cette erreur persiste, envoyez directement votre message à l'adresse 'paul.kern.fr@gmail.com'.";
			$was_sent = FALSE;
    	}
	} else {
		$was_sent = FALSE;
		$neg_result = "Vous n'avez pas rempli un des champs obligatoires.";
	}
}

if (!$was_sent) {
	$mail_values = array(
		$MAIL_NAME => isset($_POST[$MAIL_NAME]) ? $_POST[$MAIL_NAME] : "",
		$MAIL_ORG => isset($_POST[$MAIL_ORG]) ? $_POST[$MAIL_ORG] : "",
		$MAIL_EMAIL => isset($_POST[$MAIL_EMAIL]) ? $_POST[$MAIL_EMAIL] : "",
		$MAIL_OBJECT => isset($_POST[$MAIL_OBJECT]) ? $_POST[$MAIL_OBJECT] : "",
		$MAIL_MESSAGE => isset($_POST[$MAIL_MESSAGE]) ? $_POST[$MAIL_MESSAGE] : ""
	);
} else {
	$mail_values = array(
		$MAIL_NAME => "",
		$MAIL_ORG => "",
		$MAIL_EMAIL => "",
		$MAIL_OBJECT => "",
		$MAIL_MESSAGE => "",
	);
}

 ?>

<!DOCTYPE html>
<html>
<head>
<?php include('utils/head.php'); print_head(array('title' => "Paul Kern", "indexing" => TRUE, "meta" => TRUE)); ?>
    <meta property="og:site_name" content="Paul Kern" />
	<meta property="og:image" content="https://www.paulkern.fr/<?php echo $general_data[$GEN_PHOTO]; ?>" />
	<meta property="og:url" content="https://www.paulkern.fr/" />
	<meta property="og:title" content="Paul Kern - Etudiant en Génie Electrique à l'INSA Strasbourg" />
	<meta property="og:description" content="<?php echo $general_data[$GEN_META]; ?>" />
</head>
<body>


<?php include('utils/header.php'); print_header(); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Paul Kern</h1>
				<h3 class="titre-principal"><?php echo $general_data[$GEN_TITLE]; ?></h3>
			</div>
		</div>
		<div class="row big-screen">
			<div class="col-sm-2"></div>
			<div class="col-sm-4 txt-droite">
				<a href="<?php echo $general_data[$GEN_CV]; ?>" class="btn btn-primary bouton margetop25 width200">Télécharger mon CV</a>
			</div>
			<div class="col-sm-4">
				<a class="btn btn-primary bouton margetop25 width200" onclick="show_hide_contact_form();">Me contacter</a>
			</div>
			<div class="margebot45"></div>
		</div>
		<div class="row small-screen text-center">
			<div class="col-sm-12">
				<a href="<?php echo $general_data[$GEN_CV]; ?>" class="btn btn-primary bouton margetop25 width200">Télécharger mon CV</a>
			</div>
		</div>
		<div class="row small-screen text-center">
			<div class="col-sm-12">
				<a class="btn btn-primary bouton margetop25 width200" onclick="show_hide_contact_form();">Me contacter</a>
			</div>
			<div class="margebot45"></div>
		</div>
	</div>
</section>

<section id="anchor-contact" class="gray-section">
	<div id="contact" class="container">
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
					<p class="fw-bold">Nom <span class="asterisque">*</span> : <input type="text" name="<?php echo $MAIL_NAME ?>" class="form-control" value="<?php echo $mail_values[$MAIL_NAME]; ?>"></p>
					<p class="fw-bold">Organisme : <input type="text" name="<?php echo $MAIL_ORG ?>" class="form-control" value="<?php echo $mail_values[$MAIL_ORG]; ?>"></p>
					<p class="fw-bold">Adresse e-mail <span class="asterisque">*</span> : <input type="text" name="<?php echo $MAIL_EMAIL ?>" class="form-control" value="<?php echo $mail_values[$MAIL_EMAIL]; ?>"></p>
					<p class="fw-bold">Objet : <input type="text" name="<?php echo $MAIL_OBJECT ?>" class="form-control" value="<?php echo $mail_values[$MAIL_OBJECT]; ?>"></p>
					<p class="fw-bold">Message <span class="asterisque">*</span> : <textarea name="<?php echo $MAIL_MESSAGE; ?>" class="form-control" rows=10><?php echo $mail_values[$MAIL_MESSAGE]; ?></textarea></p>
					<div class="text-center">
						<input type="submit" name="<?php echo $MAIL_SUBMIT; ?>" class="btn btn-primary bouton" value="Envoyer">
					</div>
				</form>
				<?php if (isset($pos_result)) echo "<p class=\"resultat-positif\">$pos_result</p>"; ?>
				<?php if (isset($neg_result)) echo "<p class=\"resultat-negatif\">$neg_result</p>"; ?>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<div id="anchor-presentation" class="anchor"></div>
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

<div id="anchor-education" class="anchor"></div>
<section id="education" class="odd-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre">Formation</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 text-center bordure-right">
				<a href="https://www.insa-strasbourg.fr/fr/" class="void">
					<img src="img/formation/logo_insa.svg" class="img-thumbnail-mod-height" alt="Logo INSA Strasbourg" height=60>
					<p class="margetop25"><span class="bleu-big">2016 - 2021</span><br>
					<span class="fw-bold">INSA Strasbourg</span><br>
					Diplôme d'Ingénieur en Génie Electrique</p>
				</a>
			</div><hr class="hr">
			<div class="col-sm-6 text-center bordure-left">
				<a href="http://es-be.fr/lycee-saint-michel/" class="void">
					<img src="img/formation/logo_saint_michel.png" class="img-thumbnail-mod-height" alt="Logo Saint-Michel" height=60>
					<p class="margetop25"><span class="bleu-big">2016</span><br>
					<span class="fw-bold">Lycée Saint-Michel des Batignolles</span><br>
					Baccalauréat Général S - Spé Maths - Mention Très Bien</p>
				</a>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<div id="anchor-experiences-pro" class="anchor"></div>
<section id="experiences-pro" class="even-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre"><a href="experiences">Expériences professionnelles</a></h2>
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
						echo '<div class="text-center col-sm-' . $col_width . ' ' . implode(' ', $bordures) . '"><a class="void" href="experiences#exp-' . $key . '">';
						echo '<img src="' . $experience[$EXP_MAIN_IMG] . '" class="img-thumbnail-mod-height" alt="Logo ' . $experience[$EXP_NAME] . '" height="100">';
						echo '<p class="margetop25"><span class="bleu-big">' . $experience[$EXP_DATE_TXT] . '</span><br>';
						echo '<span class="fw-bold">' . $experience[$EXP_NAME] . '</span><br>';
						echo $experience[$EXP_TITLE] . '</p>';
						echo '<div class="gris">' . markdown_to_html($experience[$EXP_SHORT_DESC]) . '</div>';
						echo '</a></div>';
						if ($key < $count - 1) {
							echo '<hr class="hr">';
						}
					}
				}
			 ?>
		</div>
		<div class="margebot25"></div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<a class="btn btn-primary bouton" href="experiences">Voir toutes les expériences</a>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<div id="anchor-skills" class="anchor"></div>
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

<div id="anchor-projects" class="anchor"></div>
<section id="projects" class="even-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre">Projets</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre"><a href="scolaire">Scolaires</a></h3>
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
							$lien = '<a href="' . $project[$PRO_URL] . '" class="btn btn-primary bouton btn-sm" style="margin-bottom: 1rem;">Lien du projet</a>';
						} else {
							$lien = '';
						}
						echo '<div class="text-center col-sm-' . $col_width . ' ' . implode(' ', $bordures) . '"><a class="void" href="scolaire#pro-' . $key . '">';
						echo '<img src="' . $project[$PRO_MAIN_IMG] . '" class="img-thumbnail-mod-height" alt="Logo ' . $project[$PRO_TITLE] . '" height="150">';
						echo '<p class="margetop25"><span class="bleu-big">' . $project[$PRO_DATE_TXT] . '</span><br>';
						echo '<span class="fw-bold">' . $project[$PRO_TITLE] . '</span><br></p>';
						echo '<div class="gris">' . markdown_to_html($project[$PRO_SHORT_DESC]) . $lien . '</div>';
						echo '</a></div>';
						if ($key < $count - 1) {
							echo '<hr class="hr">';
						}
					}
				}
			 ?>
		</div>
		<div class="margebot25"></div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<a class="btn btn-primary bouton" href="scolaire">Voir toutes les projets scolaires</a>
			</div>
		</div>		
		<div class="margebot45"></div>
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sous-titre"><a href="personnel">Personnels</a></h3>
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
							$lien = '<a href="' . $project[$PRO_URL] . '" class="btn btn-primary bouton btn-sm" style="margin-bottom: 1rem;">Lien du projet</a>';
						} else {
							$lien = '';
						}
						echo '<div class="text-center col-sm-' . $col_width . ' ' . implode(' ', $bordures) . '"><a class="void" href="personnel#pro-' . $key . '">';
						echo '<img src="' . $project[$PRO_MAIN_IMG] . '" class="img-thumbnail-mod-height" alt="Logo ' . $project[$PRO_TITLE] . '" height="150">';
						echo '<p class="margetop25"><span class="bleu-big">' . $project[$PRO_DATE_TXT] . '</span><br>';
						echo '<span class="fw-bold">' . $project[$PRO_TITLE] . '</span><br></p>';
						echo '<div class="gris">' . markdown_to_html($project[$PRO_SHORT_DESC]) . $lien . '</div>';
						echo '</div>';
						if ($key < $count - 1) {
							echo '<hr class="hr">';
						}
					}
				}
			 ?>
		</div>
		<div class="margebot25"></div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<a class="btn btn-primary bouton" href="personnel">Voir toutes les projets personnels</a>
			</div>
		</div>
		<div class="margebot25"></div>
</section>

<div id="anchor-experiences-perso" class="anchor"></div>
<section id="experiences-perso" class="odd-section">
	<div class="container">
		<div class="row">
			<div class="text-center col-sm-12">
				<h2 class="titre"><a href="associations">Expériences extra-professionnelles</a></h2>
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
						echo '<div class="text-center col-sm-' . $col_width . ' ' . implode(' ', $bordures) . '"><a class="void" href="associations#exp-' . $key . '">';
						echo '<img src="' . $experience[$EXP_MAIN_IMG] . '" class="img-thumbnail-mod-height" alt="Logo ' . $experience[$EXP_NAME] . '" height="150">';
						echo '<p class="margetop25"><span class="bleu-big">' . $experience[$EXP_DATE_TXT] . '</span><br>';
						echo '<span class="fw-bold">' . $experience[$EXP_NAME] . '</span><br>';
						echo $experience[$EXP_TITLE] . '<br>';
						echo '<span class="gris">' . markdown_to_html($experience[$EXP_SHORT_DESC]) . '</span></p>';
						echo '</a></div>';
						if ($key < $count - 1) {
							echo '<hr class="hr">';
						}
					}
				}
			 ?>
		</div>
		<div class="margebot25"></div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<a class="btn btn-primary bouton" href="associations">Voir toutes les expériences</a>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<div id="anchor-contests" class="anchor"></div>
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
	if (<?php echo (!$clicked_send ? 'true' : 'false'); ?>) {
		show_hide_contact_form();
	}
</script>

<script type="text/javascript">
	var menuHeight = window.getComputedStyle(document.getElementById('menu-inside')).height;
	Array.from(document.getElementsByClassName("anchor")).forEach(element => element.style.top = "-" + menuHeight);
</script>

<script type="text/javascript" src="js/no_js.js"></script>
