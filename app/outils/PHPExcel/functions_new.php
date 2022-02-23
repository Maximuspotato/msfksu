<?php

include "/var/www/includes/php_writeexcel/class.writeexcel_workbook.inc.php";
include "/var/www/includes/php_writeexcel/class.writeexcel_workbookbig.inc.php";
include "/var/www/includes/php_writeexcel/class.writeexcel_worksheet.inc.php";

include_once "/var/www/includes/PHPExcel/Classes/PHPExcel.php";
include_once "/var/www/includes/PHPExcel/Classes/PHPExcel/IOFactory.php";



function db_connect() {
	
	$c=OCILogon("msf", "msf", "orcl");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( OCIError() );
		die();
	} else {
		oci_set_client_info($c, substr('php from '.$_SERVER['SCRIPT_FILENAME'],0,55));
		ocicommit($c);
	}
	return($c);
	
}

function db_connect_ksu() {
	
	$c=OCILogon("msf", "msf", "ksu");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( OCIError() );
		die();
	} else {
		oci_set_client_info($c, substr('php from '.$_SERVER['SCRIPT_FILENAME'],0,55));
		ocicommit($c);
	}
	return($c);
	
}

function db_connect_test() {
	
	$c=OCILogon("msf", "msf", "orct");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( OCIError() );
		die();
	} else {
		oci_set_client_info($c, 'php from '.substr($_SERVER['SCRIPT_FILENAME'],0,55));
		ocicommit($c);
	}
	return($c);
	
}

function db_connect_test_codif() {
	
	$c=OCILogon("msf", "msf", "orct2");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( OCIError() );
		die();
	} else {
		oci_set_client_info($c, 'php from '.$_SERVER['SCRIPT_FILENAME']);
		ocicommit($c);
	}
	return($c);
	
}

function db_connect_test2() {
	
	$c=OCILogon("msf", "msf", "orctmulti");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( OCIError() );
		die();
	} else {
		oci_set_client_info($c, 'php from '.$_SERVER['SCRIPT_FILENAME']);
		ocicommit($c);
	}
	return($c);
	
}

function db_connect_gold() {
	
	$c=OCILogon("refstock", "refstock", "gold");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( OCIError() );
		die();
	} else {
		oci_set_client_info($c, substr('php from '.$_SERVER['SCRIPT_FILENAME'],0,55));
		ocicommit($c);
	}
	return($c);
	
}


function db_connect_goldtest() {
	
	$c=OCILogon("refstock", "refstock", "goldtest");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( OCIError() );
		die();
	} else {
		oci_set_client_info($c, substr('php from '.$_SERVER['SCRIPT_FILENAME'],0,55));
		ocicommit($c);
	}
	return($c);
	
}

/**
 * Connexion sur la DB Postgres
 */
if (!function_exists(loginP)) {		// RMZ: check car dans le 1196 extranet on include le functions-global ET le intranet functions.php  ...
	function loginP(){
	
		$daoPortal = pg_connect("host=10.0.0.15 port=5432 dbname=prod user=admindb password=123");
		if(!$daoPortal){
			die("Prob connect PostGres --> ".pg_last_error());
		}
		return $daoPortal;
	}
}
/**
 * Déconnexion DB Postgres
 */
if (!function_exists(logoutP)) {	// RMZ: check car dans le 1196 extranet on include le functions-global ET le intranet functions.php  ...
	function logoutP($c){
		pg_close($c);
	}
}


function icon($type) {
	
	switch ($type) {
	case 'pdf':
	    echo "i equals 0";
	    break;
	case 'med':
	    echo "i equals 1";
	    break;
	case 'log':
	    echo "i equals 2";
	    break;
	}
}


function make_pdflink($refname,$val,$fields) {
	
	//global $fields;
	
	if ($val=="" OR $val=="&nbsp") return('');

	
	$pdficon='<img src="/images/pdf.gif" border="0" align=top>';

	foreach ($fields as $k => $field) {
		if ($field['friendlyname']==$refname AND $field['reporturl']!="") {
			return(' <a href="'.$_SERVER['PHP_SELF'].'?feedreport='.$refname.'&value='.$val.'">'.$pdficon.'</a>');
		}
	}

	return('');

}

function make_tablelink($refname,$val,$fields) {
	
	//global $fields;
	
	if ($val=="" OR $val=="&nbsp") return($val);

	
	foreach ($fields as $k => $field) {
		if ($field['friendlyname']==$refname AND $field['tablelink']!="") {
			//Dans le cas ou on fait un lien mais veut afficher un texte particulier (ou une image) et non pas la valeur
			// Verifie aussi qu'il y a bien une valeur = $val (sinon ne met pas de lien)
			if(isset($field['replaceValue']) && $field['replaceValue']!="" && str_replace(' ','',$val)!=''){
				$newfield=str_replace('%VALUE%',$val,$field['tablelink']);
				$val=$field['replaceValue'];
				$link='<a href="'.$newfield.'">'.$val.'</a>';	
			}else{
				$newfield=str_replace('%VALUE%',$val,$field['tablelink']);
				$link='<a href="'.$newfield.'">'.$val.'</a>';	
			}
			
			
			return $link;
			//'<a href="displayref.php?refname='.$refname.'&value='.$val.'">'.$val.'</a>');
		}
	}
	return($val);

}	
	
function rendertable($query) {
	global $fields;
	global $value;
	global $value2;
	global $value3;
	global $value4;
	global $value5;
	global $value6;
	global $value7;
	global $value8;
	global $value9;
	global $value10;
	//Malick : initialiser les variables globales
	if($value == ''){
		$value=($_REQUEST['value']!='')? $_REQUEST['value']:'';
	}
	if($value2 == ''){
		$value2=($_REQUEST['value2']!='')? $_REQUEST['value2']:'';
	}
	if($value3 == ''){
		$value3=($_REQUEST['value3']!='')? $_REQUEST['value3']:'';
	}
	if($value4 == ''){
		$value4=($_REQUEST['value4']!='')? $_REQUEST['value4']:'';
	}
	if($value5 == ''){
		$value5=($_REQUEST['value5']!='')? $_REQUEST['value5']:'';
	}
	if($value6 == ''){
		$value6=($_REQUEST['value6']!='')? $_REQUEST['value6']:'';
	}
	if($value7 == ''){
		$value7=($_REQUEST['value7']!='')? $_REQUEST['value7']:'';
	}
	if($value8 == ''){
		$value8=($_REQUEST['value8']!='')? $_REQUEST['value8']:'';
	}
	if($value9 == ''){
		$value9=($_REQUEST['value9']!='')? $_REQUEST['value9']:'';
	}
	if($value10 == ''){
		$value10=($_REQUEST['value10']!='')? $_REQUEST['value10']:'';
	}
	global $table;
	global $c;	
	
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	$recherche = OCIParse($c, $query);


	if(strpos($query,":value") || strpos($query,":VALUE")){
		if ($value!="") ocibindbyname($recherche, ":value", $value);
		if ($value2!="") ocibindbyname($recherche, ":value2", $value2);
		if ($value3!="") ocibindbyname($recherche, ":value3", $value3);
		if ($value4!="") ocibindbyname($recherche, ":value4", $value4);
		if ($value5!="") ocibindbyname($recherche, ":value5", $value5);
		if ($value6!="") ocibindbyname($recherche, ":value6", $value6);
		if ($value7!="") ocibindbyname($recherche, ":value7", $value7);
		if ($value8!="") ocibindbyname($recherche, ":value8", $value8);
		if ($value9!="") ocibindbyname($recherche, ":value9", $value9);
		if ($value10!="") ocibindbyname($recherche, ":value10", $value10);
	}
	
	
	//echo $query;
	OCIExecute($recherche, OCI_DEFAULT);
	$nrows=ocifetchstatement($recherche, $resultat,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

	
	//echo "<pre>";
//	print_r($resultat);
//	echo "<pre>";
	
	
	if ($_REQUEST['debug']==1) {
		echo "<pre>";
		print_r($query);
		echo "</pre>";
	}
	
	
	
	if ($nrows>0) {
		
		///////////
		// Envoi du tableau
		//////////
		
		?>
		<!-- script pour entête dynamique -->
		<!--<script type="text/javascript" src="/outils/jvs_header/jquery1_5.js"></script>-->
        <!--<script type="text/javascript" src="/outils/jvs_header/jquery-1.4.2.min.js"></script>-->
        
		<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.js"></script>
		<script type="text/javascript" src="/outils/jvs_header/jquery.thead-1.1.min.js"></script>
        <script type="text/javascript" src="/outils/jvs_header/picnet.table.filter.min.js"></script>-->
        
        <!--<script type="text/javascript" src="http://vintranet/includes/javascript/fixedHead/jquery.js"></script>-->
        <script type="text/javascript" src="http://vintranet/includes/javascript/jquery.js"></script>
		<script type="text/javascript" src="http://vintranet/includes/javascript/fixedHead/jquery.freezeheader.js"></script>
        <script type="text/javascript" src="http://vintranet/includes/javascript/picnet.table.filter.min.js"></script>

<?php
/*
	if($_SERVER['SCRIPT_NAME']!="/reports/gold-bce-mauvais-sscc-detail.php"){
		echo '
			<link rel="stylesheet" type="text/css" href="/outils/jvs_header/tableFilter.css">
			<link rel="stylesheet" type="text/css" href="/outils/jvs_header/tableFilter.aggregator.css">
			<!-- script filtrage -->
			<script type="text/javascript" src="/outils/jvs_header/jquery-packed.js"></script>
			<script type="text/JavaScript" src="/outils/jvs_header/jquery.cookies-packed.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/prototypes-packed.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/json-packed.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/jquery.truemouseout-packed.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/daemachTools-packed.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/jquery.tableFilter-packed.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/jquery.tableFilter.aggregator-packed.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/jquery.tableFilter.columnStyle-packed.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/jquery.tableFilter.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/jquery.tableFilter.aggregator.js"></script>
			<script type="text/javascript" src="/outils/jvs_header/jquery.tableFilter.columnStyle.js"></script>
			
			<script type="text/javascript">
				$(document).ready(function() {
					$("#tableResult").tableFilter();
			    });
			</script>
			<!-- fin -->';
	}
*/
?>
		<script type="text/javascript">
			/*************************** Script pour entête dynamique *****************************/         
			/*$(function() {
		
				// Enables the reloading of the second sample
				$('.sample2 th a').live('click', function() {
					var container = $($('.sample2').get(0)).parent();
					container.html(container.html().replace(/(\d{2,14})*(<\/(a|td)>)/g, ' ' + (new Date()).getTime() + '$2'));
					$.thead.update();
					return false;
				});
		
				// Enables the third sample
				$('.sample3').thead();
		
				// Enables the fourth sample                
				$('.sample:has(.sample4)').thead();
		
				// Adds a reloading functionality to the fourth sample                
				$('.sample4 tfoot a').live('click', function() {
					$('.sample4:first').load('table.php?ts=' + (new Date()).getTime());
					return false;
				});
				
				// Applies zebra table class names
				$('tbody').each(function() {
					$(this).find('tr:even').addClass('even');
				});
				
			});*/
				
				/**
			* Permet de mettre en place l'outils filtrage par colonne du tableau.
			*/
			//$(document).ready(function() {
				//$('#tableResult').tableFilter();
			//});
				
				/*******************************************************/
				//Pour pouvoir surligner une ligne
				function selectLigne(obj){
					if(obj.parentNode.style.backgroundColor=="rgb(209, 209, 209)"){
						//obj.parentNode.style.fontWeight="normal";
						obj.parentNode.style.backgroundColor = "#e8eef3";
						obj.parentNode.style.color = "black";
					}
					else{
						obj.parentNode.style.backgroundColor="#d1d1d1";
						obj.parentNode.style.color = "red";
					}
				}
				
		</script>
		<?php
		
		//Verfie qu il y a deja un parametre dans l URL, si pas ajoute ? puis cvs=yes
		$caractere="?";
		if(strpos($_SERVER['REQUEST_URI'],"?")){
			$caractere="&";
		}
		echo '<i><img src="/images/xls_icon.gif"/>
				 <a href="'.$_SERVER['REQUEST_URI'].$caractere.'csv=yes">This table in Excel</a></i><br>
		<div class="sample"><table class="grid jquery-thead" id="tableResult">';
		echo '<thead><tr class=titres>';

		if ($_REQUEST['order']=='ASC') $ascdesc='DESC';
		else $ascdesc='ASC';

		foreach ($fields as $k => $field) {

			if ($_REQUEST['orderby']==$field['sqlfield'] OR $_REQUEST['orderby']==$field['sortsqlfield']) {
				// le header en cours est celui sur lequel on trie !
				if ($_REQUEST['order']=="ASC") $imgtri=' <img src="/images/sort_desc.gif" alt="" border="0">';
				else $imgtri=' <img src="/images/sort_asc.gif" alt="" border="0">';


			} else $imgtri='';

			if ($field['sortsqlfield']=="") $field['sortsqlfield']=$field['sqlfield'];
			
			$url=$_SERVER['PHP_SELF'].'?refname='.$_REQUEST['refname'].'&value='.$_REQUEST['value'].'&value2='.$_REQUEST['value2'].'&value3='.$_REQUEST['value3'].'&value4='.$_REQUEST['value4'].'&value5='.$_REQUEST['value5'].'&orderby='.$field['sortsqlfield'].'&order='.$ascdesc;
			
			//Ajoute les parametreGet qui sont dans l URL 
			$pos=strpos($_SERVER['REQUEST_URI'],"?");
			if($pos>0){
				$parametreGET=substr($_SERVER['REQUEST_URI'],$pos+1);
				//echo $parametreGET;
				$listParam=explode("&",$parametreGET);
				//Pour chaque parametre GET
				foreach ($listParam as $param){
					$nomParam=substr($param,0,strpos($param,"="));
					//Rajoute le parametre si c est n est pas une value ou orderby-order
					if($nomParam!="value" && $nomParam!="value2" && $nomParam!="value3" && $nomParam!="value4" && $nomParam!="value5" 
						&& $nomParam!="refname" && $nomParam!="orderby" && $nomParam!="order"){
						$url.="&".$param;
					}
				}
			}

			if ($field['nosort']!=TRUE) {
				echo '<th title="'.$field['comment'].'"><a href="'.$url.'">'.$field['titre'].'</a>'.$imgtri.'</th>';
			}else{ 
				echo '<th title="'.$field['comment'].'">'.$field['titre'].'</th>';
			}
		}

		echo '</tr></thead><tbody id="tbodyResult">';

		//Pour creer les id de chaque element du tableau
		$idLigne=0;
		foreach ($resultat as $id => $ligne) {

			// pour chacune des lignes de résultats ...
			if ($id%2==0) $color=$table['oddcolor'];
			else $color=$table['evencolor'];
			if ($_REQUEST['debug']==1) {
				print_r($ligne);
			}
			
			echo '<tr style="background-color:'.$color.'">';

			foreach ($fields as $k => $field) {
				// pour chacun des fields a afficher ...
				//print_r($ligne);
				
				if ($field['aliasname']!="") {
					// ya un alias a la colonne
					$fieldvalue=$ligne[$field['aliasname']];
				} else {
					// pas d'alias a la colonne
					$fieldvalue=$ligne[$field['sqlfield']];
				}
				
				/*Malick: pour insérer des passages à la ligne*/
				/*if($field['newline']=="yes"){
					$tok = strtok($fieldvalue,$field['separator']);
					$string="";
					$i=1;
					$s=$tok;
					while($tok !== false){
						$tok = strtok(':');
						if(($i%7) == 0 && $i>1){
							$string.=$s.":<br>";
							$s=$tok;
						}else{
							//echo $tok.":<br>";
							$s.=":".$tok;
						}
						
						$i++;
					}
					$fieldvalue=$string;
				}*/
				
				
				$alias = $field['aliasname'];
				

				if ($field['grouping']!="nogroup" && $field['grouplikebefore']!="true") {
					// si on a pas spécifié 'nogroup'
					// si on veut grouper les memes lignes ...
					if (($fieldvalue == $resultat[$id+1][$field['sqlfield']] OR $fieldvalue == $resultat[$id+1][$alias]) AND (($fieldvalue != $resultat[$id-1][$field['sqlfield']] AND $fieldvalue != $resultat[$id-1][$alias]) OR $id==0)) {
						// la cellule est différente de la précédente, ET la meme que la suivante --> chercher combien
						$rowspan=2;
						for ($i=2;$i<(count($resultat)-$id);$i++) { // on cherche combien de lignes sont identiques
								if ($fieldvalue == $resultat[$id+$i][$field['sqlfield']] OR $fieldvalue == $resultat[$id+$i][$alias]) $rowspan++;
								else break;
						}
	
					} elseif ($id>0 AND ($fieldvalue == $resultat[$id-1][$field['sqlfield']] OR $fieldvalue == $resultat[$id-1][$alias])) {
						// la cellule est identique a -1 --> ne rien afficher
						$rowspan=0;
						
					} else {
						// classique, une cellule différente de tout
						$rowspan=1;
					}
				}

				/// CAS SPECIAUX DE COLONNES /////////////////////////////////////////////////////////////////
				if ($field['sqlfield']=="PCT_SS_DOSSIER") { // cas spécial du SDT: prendre les 2 dern chiffres
					$fieldvalue=substr($resultat[$id]['PCT_SS_DOSSIER'],-2);
				}
				
				
				$disposition=(isset($field['disposition']) && ($field['disposition']=='right' || $field['disposition']=='left')?$field['disposition']:'center');
				
				
				if ($field['format']=='prix' && $fieldvalue!="" && $fieldvalue!=null) {
					$decimal = 5;
					if(isset($field['decimal']) && $field['decimal']!=""){
						$decimal = $field['decimal']; 
					}
					
					if($fieldvalue==0){
						$decimal=0;
					}
					$fieldvalue=number_format($fieldvalue,$decimal,',','.');
					//if (stristr($fieldvalue,',')) rtrim($fieldvalue,'0');
					$disposition='right';
				}
			
				//----------------------------------------------------------//
				/// FIN DES CAS SPECIAUX /////////////////////////////////////////////////////////////////////


				if ($fieldvalue=="") $fieldvalue="&nbsp";
				
				if ($rowspan>1) $rowspanhtml=' rowspan="'.$rowspan.'" valign="top"';
				else $rowspanhtml='';

				
				$pdflink=make_pdflink($field['friendlyname'],$fieldvalue,$fields);

				
				// dans le cas ou on doit faire un lien vers une reception scannee ou quoi ou qu'est-ce
				
				$additional="";

				if ($field['file_path']!="" AND $fieldvalue!="") {
					$filepath=str_replace('%VALUE%',$fieldvalue,$field['file_path']);
					
					if (file_exists($filepath)) {
						$additional=' <a href="'.$_SERVER['PHP_SELF'].'?feedfile='.$field['friendlyname'].'&value='.$fieldvalue.'"><img src="/images/otherdoc.png" border="0" align="top"></a>';
					}

				}							
				
				$fieldvalue=make_tablelink($field['friendlyname'],$fieldvalue,$fields);								

				if ($field['nowrap']==TRUE) $nowrap=" NOWRAP";
				else $nowrap="";

				//Pour changer la couleur d'une colonne
				$couleur="";
				if($field['color']!=""){
					$couleur='bgcolor="'.$field['color'].'"';
				}
				
				if ($field['grouping']!="nogroup") {
					if($rowspan>0){
						//if(!){
						echo '<td class=data'.$rowspanhtml.' id="'.$idLigne.'" '.$couleur.' align="'.$disposition.'"'.$nowrap.' onclick="selectLigne(this);">'.utf8_encode($fieldvalue).$pdflink.$additional.'</td>';					
					}
				
				} else {
					echo '<td class=data id="'.$idLigne.'" '.$couleur.' align="'.$disposition.'"'.$nowrap.' onclick="selectLigne(this);">'.utf8_encode($fieldvalue).$pdflink.$additional.'</td>';
				}
				
				$idLigne++;
				
			}


			echo '</tr></tr>
';
		}
		
		echo '</tbody></table></div>
		
		<script>				
			$(document).ready(function() {
				$("#tableResult").freezeHeader();
				$("#tableResult").tableFilter();
			});
		</script>
';

		//////////////////////////////////////////////////////////////////////////////////////////////////////
	} else {
		echo '<i>0 lignes trouvees pour cette recherche</i>';
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////

	echo "<br><br>";
	


}


function rendertableTotLignePdsVol($query) {
	global $fields;
	global $value;
	global $value2;
	global $value3;
	global $value4;
	global $value5;
	global $value6;
	global $value7;
	global $value8;
	global $value9;
	global $value10;
	//Malick : initialiser les variables globales
	if($value == ''){
		$value=($_REQUEST['value']!='')? $_REQUEST['value']:'';
	}
	if($value2 == ''){
		$value2=($_REQUEST['value2']!='')? $_REQUEST['value2']:'';
	}
	if($value3 == ''){
		$value3=($_REQUEST['value3']!='')? $_REQUEST['value3']:'';
	}
	if($value4 == ''){
		$value4=($_REQUEST['value4']!='')? $_REQUEST['value4']:'';
	}
	if($value5 == ''){
		$value5=($_REQUEST['value5']!='')? $_REQUEST['value5']:'';
	}
	if($value6 == ''){
		$value6=($_REQUEST['value6']!='')? $_REQUEST['value6']:'';
	}
	if($value7 == ''){
		$value7=($_REQUEST['value7']!='')? $_REQUEST['value7']:'';
	}
	if($value8 == ''){
		$value8=($_REQUEST['value8']!='')? $_REQUEST['value8']:'';
	}
	if($value9 == ''){
		$value9=($_REQUEST['value9']!='')? $_REQUEST['value9']:'';
	}
	if($value10 == ''){
		$value10=($_REQUEST['value10']!='')? $_REQUEST['value10']:'';
	}
	global $table;
	global $c;		
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	$recherche = OCIParse($c, $query);
	if(strpos($query,":value") || strpos($query,":VALUE")){
		if ($value!="") ocibindbyname($recherche, ":value", $value);
		if ($value2!="") ocibindbyname($recherche, ":value2", $value2);
		if ($value3!="") ocibindbyname($recherche, ":value3", $value3);
		if ($value4!="") ocibindbyname($recherche, ":value4", $value4);
		if ($value5!="") ocibindbyname($recherche, ":value5", $value5);
		if ($value6!="") ocibindbyname($recherche, ":value6", $value6);
		if ($value7!="") ocibindbyname($recherche, ":value7", $value7);
		if ($value8!="") ocibindbyname($recherche, ":value8", $value8);
		if ($value9!="") ocibindbyname($recherche, ":value9", $value9);
		if ($value10!="") ocibindbyname($recherche, ":value10", $value10);
	}
	
	
	//echo $query;
	OCIExecute($recherche, OCI_DEFAULT);
	$nrows = ocifetchstatement($recherche, $resultat,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
	
	if ($_REQUEST['debug']==1) {
		echo "<pre>";
		print_r($query);
		echo "</pre>";
	}
		
	if ($nrows>0) {
		
		//Verfie qu il y a deja un parametre dans l URL, si pas ajoute ? puis cvs=yes
		$caractere="?";
		if(strpos($_SERVER['REQUEST_URI'],"?")){
			$caractere="&";
		}
		echo '<div><table>';
		echo '<thead><tr>';
			echo '<th>TOT Nb lignes</th>';
			echo '<th>TOT Pds (kg)</th>';
			echo '<th>TOT Vol (m³)</th>';
		echo '</tr></thead><tbody>';

		//Pour creer les id de chaque element du tableau
		$totligne = 0;
		$totpds = 0;
		$totvol = 0;
		for($i=0;$i < sizeof($resultat);$i++){
			$totligne += $resultat[$i]["NB_LIGNES"];
			$totpds += $resultat[$i]["CCT_TOT_PDS"];
			$totvol += $resultat[$i]["CCT_TOT_VOL"];
		}
		echo '<tr>';
			echo '<td>'.$totligne.'</td>';
			echo '<td>'.number_format($totpds, 3, ',', '.').'</td>';
			echo '<td>'.number_format($totvol, 3, ',', '.').'</td>';
		echo '</tr>';
		
		echo '</tbody></table></div>';

		//////////////////////////////////////////////////////////////////////////////////////////////////////
	} else {
		echo '<i>0 lignes trouvees pour cette recherche</i>';
	}
}


/**
* @author : Gorissen Malick
*/
/* Mis en commentaire avec l accord de Malick le 21/11/2012 : BMU */
/*function rendertablexls($query){
	global $fields;
	global $value;
	global $value2;
	global $value3;
	global $value4;
	global $value5;
	global $value6;
	global $value7;
	global $value8;
	global $value9;
	global $value10;
	
	//Malick : initialiser les variables globales
	if($value == ''){
		$value=($_REQUEST['value']!='')? $_REQUEST['value']:'';
	}
	if($value2 == ''){
		$value2=($_REQUEST['value2']!='')? $_REQUEST['value2']:'';
	}
	if($value3 == ''){
		$value3=($_REQUEST['value3']!='')? $_REQUEST['value3']:'';
	}
	if($value4 == ''){
		$value4=($_REQUEST['value4']!='')? $_REQUEST['value4']:'';
	}
	if($value5 == ''){
		$value5=($_REQUEST['value5']!='')? $_REQUEST['value5']:'';
	}
	if($value6 == ''){
		$value6=($_REQUEST['value6']!='')? $_REQUEST['value6']:'';
	}
	if($value7 == ''){
		$value7=($_REQUEST['value7']!='')? $_REQUEST['value7']:'';
	}
	if($value8 == ''){
		$value8=($_REQUEST['value8']!='')? $_REQUEST['value8']:'';
	}
	if($value9 == ''){
		$value9=($_REQUEST['value9']!='')? $_REQUEST['value9']:'';
	}
	if($value10 == ''){
		$value10=($_REQUEST['value10']!='')? $_REQUEST['value10']:'';
	}
	
	global $c;
	
	global $generalparams;
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	$recherche = OCIParse($c, $query);
	if(strpos($query,":value") || strpos($query,":VALUE")){
		if ($_REQUEST['value']!="") ocibindbyname($recherche, ":value", $_REQUEST['value']);
		if ($_REQUEST['value2']!="") ocibindbyname($recherche, ":value2", $_REQUEST['value2']);
		if ($_REQUEST['value3']!="") ocibindbyname($recherche, ":value3", $_REQUEST['value3']);
		if ($_REQUEST['value4']!="") ocibindbyname($recherche, ":value4", $_REQUEST['value4']);
		if ($_REQUEST['value5']!="") ocibindbyname($recherche, ":value5", $_REQUEST['value5']);
		if ($_REQUEST['value6']!="") ocibindbyname($recherche, ":value6", $_REQUEST['value6']);
		if ($_REQUEST['value7']!="") ocibindbyname($recherche, ":value7", $_REQUEST['value7']);
		if ($_REQUEST['value8']!="") ocibindbyname($recherche, ":value8", $_REQUEST['value8']);
		if ($_REQUEST['value9']!="") ocibindbyname($recherche, ":value9", $_REQUEST['value9']);
		if ($_REQUEST['value10']!="") ocibindbyname($recherche, ":value10", $_REQUEST['value10']);
	}
	OCIExecute($recherche, OCI_DEFAULT);
	$nrows=ocifetchstatement($recherche, $resultat,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
	
	if($nrows>0){
		if ($generalparams['csvname']!="") $csvrootname=$generalparams['csvname'];
		else $csvrootname="export";
		
		// Supprime les espaces de csvrootname et value (sinon le fichier ne s'enregistre pas avec l'extension
		str_replace($csvrootname," ","");
		str_replace($value," ","");
		
		$fname = tempnam("./", $csvrootname);
		$workbook = &new writeexcel_workbookbig($fname);
		$worksheet =& $workbook->addworksheet();

		# Set the column width for columns 1, 2, 3 and 4
		$worksheet->set_column(0, (sizeof($resultat)-1));
		
		# Create a format for the column headings
		$header =& $workbook->addformat();
		$header->set_bold();
		$header->set_size(12);
		$header->set_color('white');
		$header->set_bg_color('grey');
		
		# format date
		$dt =& $workbook->addformat();
		$dt->set_num_format(14);
		
		# format texte
		$text =& $workbook->addformat();
		$text->set_num_format('0#####');
		
		$i=0;
		foreach($fields as $k => $field){
			//Si on veut l afficher dans CSV (si on ne veut pas on met afficheInCSV à false)
			if($field['afficheInCSV']!='false'){
				//$worksheet->write(0, $i, html_entity_decode($field['titre'], ENT_QUOTES), $header);
				//Modifier utf8_decode par Ben le 03/07/2012
				$worksheet->write(0, $i,utf8_decode($field['titre']), $header);
				$i++;
			}
		}
		
		$i=1;
		foreach ($resultat as $id => $ligne){
			$j=0;
			// pour chacune des lignes de résultats ...
			foreach ($fields as $k => $field) {
				// pour chacun des fields a afficher ...
				if ($field['aliasname']!="") {
					// ya un alias a la colonne
					$fieldvalue=$ligne[$field['aliasname']];
				} else {
					// pas d'alias a la colonne
					$fieldvalue=$ligne[$field['sqlfield']];
				}
				$fieldvalue = strip_tags($fieldvalue);
				/// CAS SPECIAUX DE COLONNES /////////////////////////////////////////////////////////////////
				
				if ($field['format']=='prix'  && $fieldvalue!="" && $fieldvalue!=null) {
					$decimal = 5;
					if(isset($field['decimal']) && $field['decimal']!=""){
						$decimal = $field['decimal']; 
					}
					
					if($fieldvalue==0){
						$decimal=0;
					}
					
					$fieldvalue=number_format($fieldvalue,$decimal,',','');
					$disposition='right';
				}
				//----------------------------------------------------------//
				/// FIN DES CAS SPECIAUX /////////////////////////////////////////////////////////////////////
				//Si on veut l afficher dans CSV (si on ne veut pas on met afficheInCSV à false)
				if($field['afficheInCSV']!='false'){
					if($field['format']=='date'){
						$tmp = split('/', $fieldvalue);
						$val = "=DATE(".$tmp[2].";".$tmp[1].";".$tmp[0].")";
						$worksheet->write($i, $j, $val, $dt);
					}else{
						if($field['type']=='string'){
							if(is_numeric($fieldvalue) && $fieldvalue[0]=='0'){
								$nbCaractere = strlen($fieldvalue);
								$nbZero = '';
								$nb = 0;
								for($k=0;$k < $nbCaractere;$k++){
									$nbZero .= '0';
									$nb++;
								}
								$val = '=TEXT("'.$fieldvalue.'";"'.$nbZero.'")';;
								$worksheet->write($i, $j, $val);
							}else{
								$worksheet->write($i, $j, $fieldvalue);
							}
						}else{
							$worksheet->write($i, $j, $fieldvalue);
						}
					}
				}
				$j++;
			}
			$i++;
		}
		$workbook->close();

		header("Content-Type: application/x-msexcel; name=\"".$csvrootname."\"");
		header("Content-Disposition: inline; filename=\"".$csvrootname."\"");
		$fh=fopen($fname, "rb");
		fpassthru($fh);
		//readfile($fh);
		unlink($fname);
	}
}*/


/**
* @author : Gorissen Malick
*/
function rendertablexlsphp($query){
	global $fields;
	global $value;
	global $value2;
	global $value3;
	global $value4;
	global $value5;
	global $value6;
	global $value7;
	global $value8;
	global $value9;
	global $value10;
	
	//Malick : initialiser les variables globales
	if($value == ''){
		$value=($_REQUEST['value']!='')? $_REQUEST['value']:'';
	}
	if($value2 == ''){
		$value2=($_REQUEST['value2']!='')? $_REQUEST['value2']:'';
	}
	if($value3 == ''){
		$value3=($_REQUEST['value3']!='')? $_REQUEST['value3']:'';
	}
	if($value4 == ''){
		$value4=($_REQUEST['value4']!='')? $_REQUEST['value4']:'';
	}
	if($value5 == ''){
		$value5=($_REQUEST['value5']!='')? $_REQUEST['value5']:'';
	}
	if($value6 == ''){
		$value6=($_REQUEST['value6']!='')? $_REQUEST['value6']:'';
	}
	if($value7 == ''){
		$value7=($_REQUEST['value7']!='')? $_REQUEST['value7']:'';
	}
	if($value8 == ''){
		$value8=($_REQUEST['value8']!='')? $_REQUEST['value8']:'';
	}
	if($value9 == ''){
		$value9=($_REQUEST['value9']!='')? $_REQUEST['value9']:'';
	}
	if($value10 == ''){
		$value10=($_REQUEST['value10']!='')? $_REQUEST['value10']:'';
	}
	
	global $c;
	
	global $generalparams;
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$recherche = OCIParse($c, $query);
	if(strpos($query,":value") || strpos($query,":VALUE")){
		if ($value!="") ocibindbyname($recherche, ":value", $value);
		if ($value2!="") ocibindbyname($recherche, ":value2", $value2);
		if ($value3!="") ocibindbyname($recherche, ":value3", $value3);
		if ($value4!="") ocibindbyname($recherche, ":value4", $value4);
		if ($value5!="") ocibindbyname($recherche, ":value5", $value5);
		if ($value6!="") ocibindbyname($recherche, ":value6", $value6);
		if ($value7!="") ocibindbyname($recherche, ":value7", $value7);
		if ($value8!="") ocibindbyname($recherche, ":value8", $value8);
		if ($value9!="") ocibindbyname($recherche, ":value9", $value9);
		if ($value10!="") ocibindbyname($recherche, ":value10", $value10);
	}
	
	OCIExecute($recherche, OCI_DEFAULT);
	$nrows=ocifetchstatement($recherche, $resultat,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
	
	if($nrows>0){
		error_reporting(E_ALL);
		date_default_timezone_set('Europe/London');
		if ($generalparams['csvname']!="") $csvrootname=$generalparams['csvname'];
		else $csvrootname="export";
		
		// Supprime les espaces de csvrootname et value (sinon le fichier ne s'enregistre pas avec l'extension
		str_replace($csvrootname," ","");
		str_replace($value," ","");
		// font style
		$style = array(
					'font'    => array(
						'bold'      => true
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					),
					'fill' => array(
						'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
						'rotation'   => 90,
						'startcolor' => array(
							'argb' => 'FFA0A0A0'
						),
						'endcolor'   => array(
							'argb' => 'FFFFFFFF'
						)
					)
				);
		//cache PHP
		/*$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array( 'memoryCacheSize ' => '64MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);*/
		// Mon document Excel
		$objExcel = new PHPExcel();
		
		//titre
		$car = 'A';
		$j = 1;
		$objExcel->setActiveSheetIndex(0);
		foreach($fields as $k => $field){
			//Si on veut l afficher dans CSV (si on ne veut pas on met afficheInCSV à false)
			if(!isset($field['afficheInCSV']) || $field['afficheInCSV']!='false'){
				//$objExcel->getActiveSheet()->setCellValue($car.$j, utf8_encode(html_entity_decode($field['titre'])));
				$objExcel->getActiveSheet()->setCellValue($car.$j, html_entity_decode($field['titre']));
				$car++;
			}
		}
		//application du style
		$objExcel->getActiveSheet()->getStyle('A'.$j.':'.$car.$j)->applyFromArray($style);
		
		$j++;
		foreach ($resultat as $id => $ligne){
			$car = 'A';
			// pour chacune des lignes de résultats ...
			foreach ($fields as $k => $field) {
				// pour chacun des fields a afficher ...
				if (isset($field['aliasname']) && $field['aliasname']!="") {
					// ya un alias a la colonne
					$fieldvalue=$ligne[$field['aliasname']];
				} else {
					// pas d'alias a la colonne
					$fieldvalue=$ligne[$field['sqlfield']];
				}
				$fieldvalue = utf8_encode($fieldvalue);
				$fieldvalue = strip_tags($fieldvalue);
				/// CAS SPECIAUX DE COLONNES /////////////////////////////////////////////////////////////////
				
				if (isset($field['format']) && $field['format']=='prix'  && $fieldvalue!="" && $fieldvalue!=null) {
					$decimal = 5;
					if(isset($field['decimal']) && $field['decimal']!=""){
						$decimal = $field['decimal']; 
					}
					
					if($fieldvalue==0){
						$decimal=0;
					}
					
					$fieldvalue=number_format($fieldvalue,$decimal,',','');
					$disposition='right';
				}
				//----------------------------------------------------------//
				/// FIN DES CAS SPECIAUX /////////////////////////////////////////////////////////////////////
				//Si on veut l afficher dans CSV (si on ne veut pas on met afficheInCSV à false)
				if(!isset($field['afficheInCSV']) || $field['afficheInCSV']!='false'){
					if(isset($field['format']) && $field['format']=='date' && $fieldvalue != ''){
						$tabDt = explode("/", $fieldvalue);
						$objExcel->getActiveSheet()->setCellValue($car.$j, PHPExcel_Shared_Date::FormattedPHPToExcel($tabDt[2], $tabDt[1], $tabDt[0]));
						$objExcel->getActiveSheet()->getStyle($car.$j)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
						$car++;
					}else{
						if(isset($field['type']) && $field['type']=='string'){
							if(is_numeric($fieldvalue) && $fieldvalue[0]=='0'){
								$objExcel->getActiveSheet()->setCellValueExplicit($car.$j, $fieldvalue, PHPExcel_Cell_DataType::TYPE_STRING);$car++;
							}else{
								$objExcel->getActiveSheet()->setCellValue($car.$j, $fieldvalue);$car++;
							}
						}else{
							$objExcel->getActiveSheet()->setCellValue($car.$j, $fieldvalue);$car++;
						}
					}
				}
			}
			$j++;
		}
		
		// Redirect output to a client's web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$csvrootname.'.xls"');
		header('Cache-Control: max-age=0');
		// Pour le rendu
		$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
		$objWriter->save('php://output');
	}
}


function rendertablecsv($query) {
	global $fields;
	global $value;
	global $value2;
	global $value3;
	global $value4;
	global $value5;
	global $value6;
	global $value7;
	global $value8;
	global $value9;
	global $value10;
	
	//Malick : initialiser les variables globales
	if($value == ''){
		$value=($_REQUEST['value']!='')? $_REQUEST['value']:'';
	}
	if($value2 == ''){
		$value2=($_REQUEST['value2']!='')? $_REQUEST['value2']:'';
	}
	if($value3 == ''){
		$value3=($_REQUEST['value3']!='')? $_REQUEST['value3']:'';
	}
	if($value4 == ''){
		$value4=($_REQUEST['value4']!='')? $_REQUEST['value4']:'';
	}
	if($value5 == ''){
		$value5=($_REQUEST['value5']!='')? $_REQUEST['value5']:'';
	}
	if($value6 == ''){
		$value6=($_REQUEST['value6']!='')? $_REQUEST['value6']:'';
	}
	if($value7 == ''){
		$value7=($_REQUEST['value7']!='')? $_REQUEST['value7']:'';
	}
	if($value8 == ''){
		$value8=($_REQUEST['value8']!='')? $_REQUEST['value8']:'';
	}
	if($value9 == ''){
		$value9=($_REQUEST['value9']!='')? $_REQUEST['value9']:'';
	}
	if($value10 == ''){
		$value10=($_REQUEST['value10']!='')? $_REQUEST['value10']:'';
	}
	
	global $c;	
	
	global $generalparams;
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////

	$recherche = OCIParse($c, $query);
	if(strpos($query,":value") || strpos($query,":VALUE")){
		if ($value!="") ocibindbyname($recherche, ":value", $value);
		if ($value2!="") ocibindbyname($recherche, ":value2", $value2);
		if ($value3!="") ocibindbyname($recherche, ":value3", $value3);
		if ($value4!="") ocibindbyname($recherche, ":value4", $value4);
		if ($value5!="") ocibindbyname($recherche, ":value5", $value5);
		if ($value6!="") ocibindbyname($recherche, ":value6", $value6);
		if ($value7!="") ocibindbyname($recherche, ":value7", $value7);
		if ($value8!="") ocibindbyname($recherche, ":value8", $value8);
		if ($value9!="") ocibindbyname($recherche, ":value9", $value9);
		if ($value10!="") ocibindbyname($recherche, ":value10", $value10);
	}
	OCIExecute($recherche, OCI_DEFAULT);
	$nrows=ocifetchstatement($recherche, $resultat,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

	
	if ($nrows>0) {
		///////////
		// Envoi du CSV
		//////////
		
		if ($generalparams['csvname']!="") $csvrootname=$generalparams['csvname'];
		else $csvrootname="export";
		
		// Supprime les espaces de csvrootname et value (sinon le fichier ne s'enregistre pas avec l'extension
		str_replace($csvrootname," ","");
		str_replace($value," ","");
		//header("Content-Type: application/csv-tab-delimited-table");
		header("Content-Type: application/vnd.ms-excel");
		header("Content-disposition: filename=$csvrootname.xls");
		
		echo "<table border='1'><tr>";
		foreach ($fields as $k => $field) {
			//Si on veut l afficher dans CSV (si on ne veut pas on met afficheInCSV à false)
			if($field['afficheInCSV']!='false'){
				echo '<td>'.$field['titre'].'</td>';
			}
		}

		echo "</tr>";

		foreach ($resultat as $id => $ligne) {
			
			// pour chacune des lignes de résultats ...
			echo '<tr>';
			foreach ($fields as $k => $field) {
				// pour chacun des fields a afficher ...
				
				
				if ($field['aliasname']!="") {
					// ya un alias a la colonne
					$fieldvalue=$ligne[$field['aliasname']];
				} else {
					// pas d'alias a la colonne
					$fieldvalue=$ligne[$field['sqlfield']];
				}

				/// CAS SPECIAUX DE COLONNES /////////////////////////////////////////////////////////////////
				
				if ($field['format']=='prix'  && $fieldvalue!="" && $fieldvalue!=null) {
					$decimal = 5;
					if(isset($field['decimal']) && $field['decimal']!=""){
						$decimal = $field['decimal']; 
					}
					
					if($fieldvalue==0){
						$decimal=0;
					}
					
					$fieldvalue=number_format($fieldvalue,$decimal,',','');
					$disposition='right';
				}
				
				//----------------------------------------------------------//
				/// FIN DES CAS SPECIAUX /////////////////////////////////////////////////////////////////////
				//Si on veut l afficher dans CSV (si on ne veut pas on met afficheInCSV à false)
				if($field['afficheInCSV']!='false'){
					if(isset($field['type'])){
						echo "<td style='mso-number-format:\@'>".$fieldvalue."</td>";
					}else{
						echo '<td>'.$fieldvalue.'</td>';
					}
				}
			}
			echo "</tr>";
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////
	} else {
		echo '<i>0 lignes trouvées pour cette recherche</i>';
	}
	echo '</table>';
	//////////////////////////////////////////////////////////////////////////////////////////////////////

}




function feedfile($refname,$value) {
	global $fields;
	
	if ($refname!="" AND $value!="") {
		// envoyer le fichier si un 'file_path' existe pour ce champ, et si il existe !
	
	
		foreach ($fields as $k => $field) {
			if ($field['friendlyname']==$refname AND $field['file_path']!="") {
				$filepath=str_replace('%VALUE%',$value,$field['file_path']);
				if (file_exists($filepath)) {
					$filecontent=file_get_contents($filepath);
					header('Content-type: application/pdf');
					header('Content-Disposition: inline; filename="'.$refname.$value.'.pdf";');
					echo $filecontent;
					die();
				} else {
					die("Aucun fichier trouvé ($refname:$value) $filepath");
				}
			}
		}
	
		die("Aucun fichier trouvé ($refname:$value)");
	}

	
}



?>
