<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Demande d'envoi d'un rapport a un client, par mail ou directement dans le browser
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  $_REQUEST['permail']   :   "permail" (oui)     ou "" (non)
///  $reporturl    :   url complete du rapport a envoyer
///  $filename :  nom du fichier a envoyer   ou  "" pour "doc-renaud.pdf"
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//require_once('db_connect.php');
require_once('functions.php');


// Verifier qu'on est bien authentifi� /////////////////////////////////////////////////////////////////////////////////


// if ($logged_in != 1) {
// 	die ("Restricted area - Please <a href=login.php>login</a>.");
// }



// Check si les variables necessaires ont �t� pass�es au script. /////////////////////////////////////


// if (!($_REQUEST['permail']=="" || $_REQUEST['permail']=="permail" || $reporturl !="")) {
// 	die('<div class="errorbox">This page cannot be called manually. Please <a href="login.php">login</a>.</div>');
// }


// Traitements sur les variables utilis�es  (rajouter des backslash etc..) /////////////////////////

$reporturl=addslashes($reporturl);

// par defaut faire un nom genre doc-renaud.pdf
// sauf si on a deja une variable $filename, alors utiliser ce nom la (packing-213213213.pdf)
if ($filename=="") $filename='doc-'.str_replace(" ", "_", $_SESSION['username']).'.pdf';

//$_REQUEST['permail'] = 1;
//if (isset($_REQUEST['permail']) == '') {
	/////////////////////////////////////////////////////////////
	// we want it in the browser
	/////////////////////////////////////////////////////////////

	$startTime = array_sum(explode(" ",microtime()));

	//dd($reporturl);
	$f = fopen($reporturl, 'r');
	if (!$f) {
		logtext('Error: could not contact report server! URL='.$reporturl);

		die('Error contacting report server.');
	}
	$l = fgets($f);
	$startTime2 = array_sum(explode(" ",microtime()));

	if  (strncmp($l,"%PDF-1.",7) != 0) {
		//require('header.php');
		//logtext('Error: generated file is not a PDF. URL='.$reporturl);
		die ('<div id="errorbox"><h2>Problem</h2>Something went wrong while generating the PDF file.<br>
The output does not appear to be as expected.<br>
Please make sure you entered all parameters correctly.<br>
<i>Debug: '.$reporturl.'</i></div>');
	}

	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="'.$filename.'";');
	print $l;

	while ($l = fgets($f)) {
		print $l;
	}


	fclose($f);
	//logtext('pdf downloaded in '.round((array_sum(explode(" ",microtime())) - $startTime),1).'s gen:'.round((array_sum(explode(" ",microtime())) - $startTime2),1).'s '.$_SERVER['SCRIPT_NAME']);

	//	exec('/bin/rm /tmp/doc-'.$_SESSION['username'].'.pdf');
	//exec('/bin/touch /tmp/docTEST.pdf');

// } 
//else {


// 	/////////////////////////////////////////////////////////////
// 	// we want it per mail ...
// 	/////////////////////////////////////////////////////////////

	
// 	$pdfcontent=implode('',file($reporturl));
	
// 	if (strlen($pdfcontent)<2000) {
// 		require('header.php');
// 		logtext('Error: generated file is too small. URL='.$reporturl);

// 		die ('<div id="errorbox"><h2>Problem</h2>Something went wrong while generating the PDF file.<br>
// The output does not appear to be as expected (empty pdf, or no pdf at all).<br>
// This Error can also be shown when the requested document is empty. (trying to consult other client\'s documents, etc.)</div>');
// 	}
	

// 	require('header.php');

// 	$taille_fichier=round(strlen($pdfcontent)/1024);

// 	echo '<div id=action_success_box>'._SENDREPORT_PDFSENT.' <b>'.$userinfos['EMAIL'].'</b><br>'._SENDREPORT_FILESIZEIS.' <b>'.$taille_fichier.' Kb </b>(zip)</div>';
// 	logtext('PDF sent successfully per mail.('.$taille_fichier.' kb)');

// 	// nouvelle facon d'envoyer les mails
// 	require("/outils/phpmailer/class.phpmailer.php");

// 	$mail = new phpmailer;
// 	$mail->From = "extranet-msfsupply@brussels.msf.org";
// 	$mail->Sender = "extranet-msfsupply@brussels.msf.org";
// 	$mail->FromName = "MSF Supply Extranet";
// 	//$mail->AddAddress($_SESSION['email']);
// 	$mail->AddAddress("benoit.muret@brussels.msf.org");
// 	$mail->WordWrap = 50;    // set word wrap
// 	$mail->AddStringAttachment($pdfcontent,$filename,'base64','application/pdf');
// 	$mail->IsHTML(false);    // set email format to HTML
// 	$mail->Subject = "Your document from MSF Supply Extranet";
// 	$mail->Body = "Hello,
// Please find in attachment the file you have asked for on MSF Supply Extranet (http://www.msfsupply.be/extranet).

// MSF Supply Extranet team.
// extranet-msfsupply@brussels.msf.org
// +32-2-2491065

// ";
// 	$mail->Send();
	

// }

?>
