<?php 

session_start();

if (!isset($_SESSION['antibot'])) {
	$_SESSION['antibot'] = bin2hex(random_bytes(10));
}

require_once('utils/visits.php');

require_once('utils/bdd.php');
require_once('utils/markdown.php');
require_once('utils/constants.php');
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


function send_mail() {
	global $MAIL_NAME, $MAIL_ORG, $MAIL_EMAIL, $MAIL_OBJECT, $MAIL_MESSAGE, $MAIL_SUBMIT, $MAIL_HONEYPOT, $MAIL_HONEYPOT_JS, $MAIL_DUMMY_FIELD_1, $MAIL_DUMMY_FIELD_2, $MAIL_SESSION, $MAIL_BUTTON_JS, $MAIL_TIMEOUT;

	// ===== ANTI BOT
	// Pot de miel contre les bots
	if (!empty($_POST[$MAIL_HONEYPOT])) {
		return -2;
	}
	// Second pot de miel (vérifie le JS)
	if (!isset($_POST[$MAIL_HONEYPOT_JS]) || !empty($_POST[$MAIL_HONEYPOT_JS])) {
		return -2;
	}
	// Vérifie le JS
	if ($_POST[$MAIL_DUMMY_FIELD_1] != $_POST[$MAIL_DUMMY_FIELD_2]) {
		return -2;
	}
	// Session
	if ($_SESSION['antibot'] != $_POST[$MAIL_SESSION]) {
		return 2; // On renvoie 2 et pas -2 au cas où c'est une erreur avec la session de l'utilisateur
	}
	// Variables serveurs
	if (isset($_SERVER['HTTP_ORIGIN']) && strpos($_SERVER['HTTP_ORIGIN'], 'www.paulkern.fr') === FALSE) {
		return 2; // On renvoie 2 et pas -2 au cas où c'est une erreur avec l'utilisateur
	}
	if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'www.paulkern.fr') === FALSE) {
		echo $_SERVER['HTTP_REFERER'] . '/' . $_SERVER['HTTP_REFERER'];
		return 2; // On renvoie 2 et pas -2 au cas où c'est une erreur avec l'utilisateur
	}
	// Clic sur le bouton
	if ($_POST[$MAIL_BUTTON_JS] != 'amF2YXNjcmlwdA==') {
		return 2; // On renvoie 2 et pas -2 au cas où c'est une erreur avec l'utilisateur
	}

	// ===== CHECK SPAMMING
	if ($_POST[$MAIL_TIMEOUT] == 'X') {
		return 3;
	}

	// =====

	// Manque une info obligatoire
	if ($_POST[$MAIL_NAME] == '' || $_POST[$MAIL_EMAIL] == '' || $_POST[$MAIL_MESSAGE] == '') {
		return 1;
	}

	// Envoi bot discord
	try {
		require('bot/bot.php');
		send_contact_message_discord($_POST[$MAIL_NAME], $_POST[$MAIL_ORG], $_POST[$MAIL_EMAIL], $_POST[$MAIL_OBJECT], $_POST[$MAIL_MESSAGE]);
	} catch (Exception $e) {
		return 2;
	}

	$mail_body = '<h3>Formulaire de contact utilisé par \'' . $_POST[$MAIL_NAME] . '\' (' . $_POST[$MAIL_ORG] . ') le ' . date('d/m/Y') . ' à ' . date('H:i') . '</h3>';
	$mail_body = $mail_body . '<h3>Adresse mail entrée : \'' . $_POST[$MAIL_EMAIL] . '\'</h3><br>';
	$mail_body = $mail_body . '<p>' . str_replace("\n", "<br>", $_POST[$MAIL_MESSAGE]) . '</p>';

	$mail = new PhpMailer(TRUE);
	$mail->CharSet = 'UTF-8';
	$mail->setFrom('contact@paulkern.fr', 'paulkern.fr');
	$mail->addAddress('paul.kern.fr@gmail.com');
	$mail->isHTML(true);
	$mail->Subject = '[paulkern.fr] <' . $_POST[$MAIL_OBJECT] . '>';
	$mail->Body = $mail_body;

	try {
		$send_result = $mail->send();
	} catch (Exception $e) {
		return 2;
	}

	return ($send_result ? 0 : 2);
}


$result = -1;
if (isset($_POST[$MAIL_SUBMIT])) {
	$result = send_mail();
}

$was_sent = ($result == 0);
$clicked_send = ($result >= 0);

if ($result == 0) {
	$pos_result = "Message correctement envoyé !";
} elseif ($result == 1) {
	$neg_result = "Vous n'avez pas rempli un des champs obligatoires.";
} elseif ($result == 2) {
	$neg_result = "Une erreur est survenue pendant l'envoi du message, veuillez réessayer s'il vous plait. Si cette erreur persiste, envoyez directement votre message à l'adresse 'paul.kern.fr[at]gmail.com'.";
} elseif ($result == 3) {
	$neg_result = "Vous tentez d'envoyer plusieurs messages trop rapidement. Attendez quelques secondes avant de retenter, et si l'erreur persiste, <a href=\".?btn\">actualisez la page</a>.";
}

if (isset($_GET['btn'])) {
	$clicked_send = TRUE;
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
	<meta property="og:title" content="Paul Kern - <?php echo $general_data[$GEN_TITLE]; ?>" />
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
				<p class="gris">Aucune information entrée ici ne sera enregistrée sur le site.</p>
				<div class="margebot45"></div>
			</div>
		</div>
		<?php 
			if (isset($pos_result) || isset($neg_result)) {
				echo '<div class="row"><div class="col-sm-3"></div><div class="col-sm-6">';
				if (isset($pos_result)) {
					echo '<div class="alert alert-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg> ';
					echo $pos_result;
				} else {
					echo '<div class="alert alert-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16"><path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/></svg> <span class="fw-bold">Erreur ! </span>';
					echo $neg_result;
				}
				echo '</div></div></div>';
			}
		 ?>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<form method="post" action="#contact" id="contact-form">
					<p class="fw-bold">Nom <span class="asterisque">*</span> : <input type="text" name="<?php echo $MAIL_NAME ?>" class="form-control" value="<?php echo $mail_values[$MAIL_NAME]; ?>"></p>
					<p class="contact-first-name fw-bold">Prénom : <input type="text" name="<?php echo $MAIL_HONEYPOT ?>" class="form-control"></p>
					<p class="fw-bold">Organisme : <input type="text" name="<?php echo $MAIL_ORG ?>" class="form-control" value="<?php echo $mail_values[$MAIL_ORG]; ?>"></p>
					<p class="fw-bold">Adresse e-mail <span class="asterisque">*</span> : <input type="text" name="<?php echo $MAIL_EMAIL ?>" class="form-control" value="<?php echo $mail_values[$MAIL_EMAIL]; ?>"></p>
					<p class="fw-bold">Objet : <input type="text" name="<?php echo $MAIL_OBJECT ?>" class="form-control" value="<?php echo $mail_values[$MAIL_OBJECT]; ?>"></p>
					<p class="fw-bold">Message <span class="asterisque">*</span> : <textarea name="<?php echo $MAIL_MESSAGE; ?>" class="form-control" rows=10><?php echo $mail_values[$MAIL_MESSAGE]; ?></textarea></p>
					<p style="display: none;">
						<input type="text" name="<?php echo $MAIL_DUMMY_FIELD_1; ?>" value="amUgbSdhcHBlbGxlIHBhdWw=" style="display: none;">
						<input type="text" name="<?php echo $MAIL_DUMMY_FIELD_2; ?>" style="display: none;">
						<input type="text" name="<?php echo $MAIL_SESSION; ?>" value="<?php echo $_SESSION['antibot']; ?>" style="display: none;">
						<input type="text" name="<?php echo $MAIL_BUTTON_JS; ?>" id="<?php echo $MAIL_BUTTON_JS; ?>" style="display: none;" value="<?php echo ($clicked_send ? "amF2YXNjcmlwdA==" : "") ?>">
						<input type="text" name="<?php echo $MAIL_TIMEOUT; ?>" id="<?php echo $MAIL_TIMEOUT; ?>" value="<?php echo ($result == -1 ? 'O' : 'X'); ?>">
					</p>
					<div class="text-center">
						<input type="submit" name="<?php echo $MAIL_SUBMIT; ?>" class="btn btn-primary bouton" value="Envoyer">
					</div>
				</form>
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
					Diplôme d'Ingénieur en Génie Electrique<br>Spécialité Systèmes Embarqués & IoT</p>
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
						echo '<span class="fw-bold">' . $experience[$EXP_NAME] . ($experience[$EXP_PLACE] != '' ? ' — ' . $experience[$EXP_PLACE] : '') . '</span><br>';
						echo $experience[$EXP_TITLE] . '</p></a>';
						echo '<div class="gris">' . markdown_to_html($experience[$EXP_SHORT_DESC]) . '</div>';
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
				<a class="btn btn-primary bouton" href="experiences">Voir la liste complète</a>
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
				<h3 class="sous-titre">Générales</h3>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach ($skills_data as $key => $skill) {
					if ($skill[$SKI_TYPE] == 'general') {
						echo '<div class="text-center col-sm-3">';
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
				<h4 class="sous-titre">Niveau intermédiaire</h4>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach ($skills_data as $key => $skill) {
					if ($skill[$SKI_TYPE] == 'programming' && ($skill[$SKI_LEVEL] == 'inter' || $skill[$SKI_LEVEL] == 'begin')) {
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
				<h3 class="sous-titre">Logiciels, OS & Technologies</h3>
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
					if ($skill[$SKI_TYPE] == 'software' && $skill[$SKI_LEVEL] == 'master') {
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
					if ($skill[$SKI_TYPE] == 'software' && ($skill[$SKI_LEVEL] == 'inter' || $skill[$SKI_LEVEL] == 'begin')) {
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
				<h3 class="sous-titre">Humaines</h3>
			</div>
		</div>
		<div class="row">
			<?php 
				foreach ($skills_data as $key => $skill) {
					if ($skill[$SKI_TYPE] == 'human') {
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
				<h3 class="sous-titre"><a href="scolaire">Étudiants</a></h3>
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
						echo '<span class="fw-bold">' . $project[$PRO_TITLE] . '</span><br></p></a>';
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
				<a class="btn btn-primary bouton" href="scolaire">Voir la liste complète</a>
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
						echo '<span class="fw-bold">' . $project[$PRO_TITLE] . '</span><br></p></a>';
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
				<a class="btn btn-primary bouton" href="personnel">Voir la liste complète</a>
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
						echo '<span class="fw-bold">' . $experience[$EXP_NAME] . ($experience[$EXP_PLACE] != '' ? ' — ' . $experience[$EXP_PLACE] : '') . '</span><br>';
						echo $experience[$EXP_TITLE] . '<br></a>';
						echo '<span class="gris">' . markdown_to_html($experience[$EXP_SHORT_DESC]) . '</span></p>';
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
				<a class="btn btn-primary bouton" href="associations">Voir la liste complète</a>
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
		<!--<div class="row text-center">-->
			<?php 
				foreach ($contests_data as $key => $contest) {
					if ($key % 6 == 0) {
						echo '<div class="row text-center' . ($key > 0 ? ' margetop45' : '') . '">';
					}
					echo '<div class="col-sm-2 ' . ($key % 6 == 5 ? 'paddingtop10' : 'bordure-right-no-padding-right') . '">';
					echo '<p class="bleu-big">' . $contest[$CON_DATE_TXT] . '</p>';
					echo '<p class="fw-bold">' . $contest[$CON_NAME] . '</p>';
					echo '<p>' . markdown_to_html($contest[$CON_DESC]) . '</p>';
					echo '</div>';
					if ($key % 6 == 5) {
						echo '</div>';
					}
				}
			 ?>
		<!--</div>-->
	</div>
</section>

<?php include('utils/footer.php'); print_footer(); ?>

</body>
</html>

<script type="text/javascript">
	function show_hide_contact_form() {
		var contact_section = document.getElementById('contact');
		if (contact_section.style.display != 'none') {
			contact_section.style.display = 'none';
		} else {
			contact_section.style.display = 'block';
		}

		// Vérifie que l'utilisateur a bien cliqué sur le bouton
		document.getElementById('<?php echo $MAIL_BUTTON_JS; ?>').value = "amF2YXNjcmlwdA==";
	}
	if (<?php echo (!$clicked_send ? 'true' : 'false'); ?>) {
		show_hide_contact_form();
	}
</script>

<script type="text/javascript">
	var menuHeight = window.getComputedStyle(document.getElementById('menu-inside')).height;
	Array.from(document.getElementsByClassName("anchor")).forEach(element => element.style.top = "-" + menuHeight);
</script>

<script type="text/javascript">
	var contact_form = document.getElementById('contact-form');
	// Create p
	var title_form_p = document.createElement('p');
	title_form_p.className += 'fw-bold ';
	title_form_p.className += 'contact-title';
	title_form_p.innerText = "Titre : ";
	// Create input
	var title_form_input = document.createElement('input');
	title_form_input.setAttribute('type', 'text');
	title_form_input.setAttribute('name', '<?php echo $MAIL_HONEYPOT_JS; ?>');
	title_form_input.className += 'form-control';
	title_form_p.appendChild(title_form_input);
	contact_form.appendChild(title_form_p);
	// =====
	var form_field1 = document.getElementsByName('<?php echo $MAIL_DUMMY_FIELD_1; ?>')[0];
	var form_field2 = document.getElementsByName('<?php echo $MAIL_DUMMY_FIELD_2; ?>')[0];
	form_field2.value = form_field1.value;
	// Timeout
	function timeout_end() {
		document.getElementById('<?php echo $MAIL_TIMEOUT; ?>').value = "O";
	}
	setTimeout(timeout_end, 4000);
</script>

<script type="text/javascript" src="js/no_js.js"></script>
