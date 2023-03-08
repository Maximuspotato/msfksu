@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Order Confirmation</h1>
                </div>
            </div>
        </div>
    </div>
	<div class="section">
        <div class="container">
			<?php
				include_once(app_path() . '/outils/functions.php');
				$GLOBALS['c'] = db_connect();

				function op_is_from_client($order,$clifac) {
					global $c;


					$requete_appartenance_cmde_cli_sql =	'select CCT_CLI_CODE_FACTURE, CCT_NO
													from   XN_CMDE_CLI_TETE
													where  CCT_CLI_CODE_FACTURE = :CLI_CMDE_FAC and
													CCT_NO = :NO_CMDE';

					$requete_appartenance_cmde_cli = OCIParse($c,$requete_appartenance_cmde_cli_sql);
					OCIBindByName($requete_appartenance_cmde_cli,':CLI_CMDE_FAC', $clifac);
					OCIBindByName($requete_appartenance_cmde_cli,':NO_CMDE', $order);
					OCIExecute($requete_appartenance_cmde_cli, OCI_DEFAULT);
					$nbrows = Ocifetchstatement($requete_appartenance_cmde_cli, $result_check, 0, -1, OCI_NUM);


					if ($nbrows==0) return(FALSE);
					else return(TRUE);

				}

				if (!isset($_REQUEST['order']) OR !is_numeric($_REQUEST['order'])) {
			?>
					<div id="grille-param"><form action="{{URL('/')}}/order-confirmation" method=get>
						<h2>Order Confirmation</h2>
						Dowload your order confirmation<br><br>
							KSU Order Ref: 
			<?php
					if(isset($_REQUEST['choose'])) {
						$queryS="
							SELECT DISTINCT CCT_NO, CCT_REF_CMDE_CLI1, CCT_CLI_CODE_LIVRE
								FROM XN_CMDE_CLI_TETE

									WHERE cct_cli_code_disp >= :client_liv_deb
									AND cct_cli_code_disp <= :client_liv_fin
									
									AND CCT_DT_CREAT > SYSDATE-2*364 
									--and CCT_TYD_CODE in ('CC')
									and CCT_TYD_CODE in ('CS')
								--ORDER BY CCT_REF_CMDE_CLI1 asc
								ORDER BY CCT_NO desc
						";
				
					$ref_mission = oci_parse($c, $queryS);
					ocibindbyname($ref_mission, ":client_liv_deb",$_SESSION['client_liv_deb']);
					ocibindbyname($ref_mission, ":client_liv_fin",$_SESSION['client_liv_fin']);			
					ociexecute($ref_mission, OCI_DEFAULT);
			?>
					<select name="order" id="order" style="display:<?php echo (isset($_REQUEST['radiocheck']) && $_REQUEST['radiocheck']=='xml'?'none':'inline');?>">
			<?php
					while (oci_fetch($ref_mission)){
			?>
					<option value = "<?php echo oci_result($ref_mission, "CCT_NO");?>" ><?php echo oci_result($ref_mission, "CCT_REF_CMDE_CLI1").' -- '.oci_result($ref_mission, "CCT_NO").' -- '.oci_result($ref_mission, "CCT_CLI_CODE_LIVRE");?></option>
			<?php
					}
			?>
					</select>
			<?php
					//----------------------------------------- Pour la partie Unifield, on recherche que par référence et non pas par OP
					$queryS2="SELECT DISTINCT 
					
					EXTFCT_CCT_REF_CMDE_CLI1(CCT_REF_CMDE_CLI1) CCT_REF_CMDE_CLI1,
					CCT_CLI_CODE_LIVRE, CCT_NO
					
					
									FROM XN_CMDE_CLI_TETE
									
										WHERE 
										cct_cli_code_disp >= :clidispdeb AND
										cct_cli_code_disp <= :clidispfin AND
										CCT_DT_CREAT > SYSDATE-2*364
										--and CCT_TYD_CODE in ('CC','CS')
										and CCT_TYD_CODE in ('CS')
										--ORDER BY CCT_REF_CMDE_CLI1 desc,CCT_CLI_CODE_LIVRE ASC
										ORDER BY CCT_NO desc";
					$ref_mission2 = oci_parse($c, $queryS2);
					
					ocibindbyname($ref_mission2, ":clidispdeb",$_SESSION['client_liv_deb']);
					ocibindbyname($ref_mission2, ":clidispfin",$_SESSION['client_liv_fin']);
					oci_execute($ref_mission2, OCI_DEFAULT);
					
					// on veut une deroulante
					echo '<select name="order_ref" id="order_ref" style="display:'.(isset($_REQUEST['radiocheck']) && ($_REQUEST['radiocheck']=='xml' || $_REQUEST['radiocheck']=='spreadsheet')?'inline':'none').';">';
					while (oci_fetch($ref_mission2))
					{
						echo '<option value = "'.oci_result($ref_mission2, "CCT_REF_CMDE_CLI1").'" >'.oci_result($ref_mission2, "CCT_REF_CMDE_CLI1").' -- '.oci_result($ref_mission2, "CCT_CLI_CODE_LIVRE").' </option>';
					}
					echo '</select>
					<a href="'.$_SERVER['PHP_SELF'].'">Reset</a><br>';
					}else{
			?>
					<!-- <input type="text" name="order" value="" maxlength="7" size="10"> -->
					<input type="text" name="order" value="<?php if(isset($_REQUEST['order']))echo($_REQUEST['order']) ?>" size="10" required>

					<!-- Choix Liste valeur... -->
					
					<br/>
			<?php
					}
					echo '<br><label><input checked type="radio" name="fichier" value="pdf"'.(isset($_REQUEST['radiocheck']) && $_REQUEST['radiocheck']=='pdf'?' checked=checked ':'').' onchange="changeListe(\'op\');">'."PDF format".'</label> <br>
					<label><input disabled type="radio" name="fichier" value="csv"'.(isset($_REQUEST['radiocheck']) && $_REQUEST['radiocheck']=='csv'?' checked=checked ':'').' onchange="changeListe(\'op\');">'."CSV format".'</label><br>
					
					<label><input disabled type="radio" name="fichier" value="spreadsheet"'.(isset($_REQUEST['radiocheck']) && $_REQUEST['radiocheck']=='spreadsheet'?' checked=checked ':'').' onchange="changeListe(\'unifield\');">XML Spreadsheet for Unifield</label>
					<span id="baseDonnee" style="display:'.(isset($_REQUEST['radiocheck']) && $_REQUEST['radiocheck']=='xml'?'inline':'none').';"></span>

					<br><br><br><input type="submit" value="'."Search".'"></form></div>';
				}

				if (isset($_REQUEST['fichier']) && $_REQUEST['fichier'] =='pdf') {
					include_once(app_path() . '/outils/functions.php');
					$c = db_connect();
					$query_op = " SELECT DISTINCT CCT_NO, CCT_REF_CMDE_CLI1
											FROM XN_CMDE_CLI_TETE, XN_CLI
											WHERE CLI_CODE(+) = CCT_CLI_CODE_LIVRE
											AND CCT_REF_CMDE_CLI1 = :order_ref
										";
						if (session()->get('oc') != "") {
							$query_op .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
						}

						if (session()->get('country') != "") {
							$query_op .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
						}
					$stmt = oci_parse($c, $query_op);
					ocibindbyname($stmt, ":order_ref", $_REQUEST['order']);
					ociexecute($stmt, OCI_DEFAULT);
					$nrows = ocifetchstatement($stmt, $result_op,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
					$op;
					if ($nrows > 0) {
						echo("<p><b>Files found</b></p>");
						foreach($result_op as $one_op){
							$op = $one_op['CCT_NO'];
							$reporturl='http://10.210.168.40:9002/reports/rwservlet?report=/u02/app/nodhos/msfsup/rdf/trvc324r&P_CCT_NO_DEB='.$op.'&P_CCT_NO_FIN='.$op.'&userid=msf/msf@nodhos&destype=cache&server=rep_nodhosksu&amp;paramform=no&desformat=pdf';
							//dd($reporturl);
				
							// $filename="op".$_REQUEST['order'].".pdf";

							// include_once(app_path() . '/outils/sendreport.php');
							//header('Location: '.$reporturl);
							//exit;
							echo("<a href='".$reporturl."' target='_blank'>".$op.".pdf</a>");
							echo("<br>");
						}
					}
					
				} elseif (isset($_REQUEST['fichier']) && $_REQUEST['fichier'] =='csv') {
					include_once(app_path() . '/outils/functions.php');
					$c = db_connect();

					$query_op = " SELECT DISTINCT CCT_NO, CCT_REF_CMDE_CLI1
											FROM XN_CMDE_CLI_TETE, XN_CLI
											WHERE CLI_CODE(+) = CCT_CLI_CODE_LIVRE
											AND CCT_REF_CMDE_CLI1 LIKE '%:order_ref%'
										";
						if (session()->get('oc') != "") {
							$query_op .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
						}

						if (session()->get('country') != "") {
							$query_op .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
						}
					$stmt = oci_parse($c, $query_op);
					ocibindbyname($stmt, ":order_ref", $_REQUEST['order']);
					ociexecute($stmt, OCI_DEFAULT);
					$nrows = ocifetchstatement($stmt, $result_op,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
					if ($nrows > 0) {
						//if ($nrows == 1) {
							foreach($result_op as $one_op){
                                $query = "
								SELECT CCL_DES2, CCL_ART_CODE, CCL_ART_VAR1, CCL_DES1, CCT_DT_CMDE, CCT_DT_FERM, CCL_PDS, CCL_VOL, CCL_COND_VTE, CCL_QTE_CMDE,CCL_PX_VTE_NET,
								CCL_MT_HT_LIGNE, CCT_DEV_CODE
								FROM XN_CMDE_CLI_LIGNE, XN_CMDE_CLI_TETE
								WHERE CCT_NO = CCL_CCT_NO
								AND CCL_CCT_NO = :op";


								$commande = oci_parse($c, $query);
								ocibindbyname($commande, ":op",$one_op['CCT_NO']);

								ociexecute($commande, OCI_DEFAULT);
								$nrows = ocifetchstatement($commande, $resulte,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
								
								
								$filename="op".$_REQUEST['order'].".csv";
								
								header('Content-type: application/csv');
								header("Content-disposition: filename=".$filename);
								ob_get_clean();
								echo 'Item;Code;Version;Description;Creation Date;RTS Date;Weight(kg);'.utf8_decode('Volume(dm³)').';'.'Packaging;Quantity;Pack Price;Value;Currency;'."\n";
								foreach ($resulte as $one_resulte) {
									echo $one_resulte['CCL_DES2'].';'
									.$one_resulte['CCL_ART_CODE'].';'
									.$one_resulte['CCL_ART_VAR1'].';'
									.$one_resulte['CCL_DES1'].';'
									.$one_resulte['CCT_DT_CMDE'].';'
									.$one_resulte['CCT_DT_FERM'].';'
									.number_format($one_resulte['CCL_PDS'],4,',','').';'
									.number_format($one_resulte['CCL_VOL'],4,',','').';'
									.number_format($one_resulte['CCL_COND_VTE'],0,',','').';'
									.number_format($one_resulte['CCL_QTE_CMDE'],0,',','').';'
									.number_format($one_resulte['CCL_PX_VTE_NET'],4,',','').';'
									.number_format($one_resulte['CCL_MT_HT_LIGNE'],4,',','').';'
									.$one_resulte['CCT_DEV_CODE'].';'
									."\n";
								}
								//exit;
							}
							exit;
						//}
					}
					
				} elseif (isset($_REQUEST['fichier']) && $_REQUEST['fichier'] =='xml' || isset($_REQUEST['fichier']) && $_REQUEST['fichier'] =='spreadsheet') { 
					//require_once('../includes/functions-global.php');
					include_once(app_path() . '/outils/functions-order_confirmation.php');
					
					if($_REQUEST['fichier']=='xml'){
						$xmldata=get_xml_for_unifield($_REQUEST['order']);
					}elseif($_REQUEST['fichier']=='spreadsheet'){
						$xmldata=get_xml_spreadsheet_for_unifield($_REQUEST['order']);
					}
					
					$filename=ltrim(str_replace('/','_',$_REQUEST['order']));
					$filename=str_replace(' ','',$filename);
					

					// envoyer le xml au client si valide
					if (substr($xmldata, 0,5)=='<?xml') {

						header('Content-type: application/xml');
						header('Content-Disposition: attachment; filename="'.$filename.'.xml";');
						echo $xmldata;
						die();

					} else {
						logtext('Error: generated file is not an XML. URL='.$reporturl);
						require('../includes/header.php');
						
						
						die ('<div id="errorbox"><h2>Problem</h2>Something went wrong while generating the XML file.<br>
				The output does not appear to be a valid file.<br>
				Please make sure you entered a valid reference.<br></div>');


					}

				}
			?>
		</div>
	</div>
@endsection