@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Frieght Reception</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			<?php
				include_once(app_path() . '/outils/functions.php');
				//require_once(app_path() . '/outils/domxml-php4-to-php5.php');
				$c = db_connect();
			?>
			{{-- <link rel="stylesheet" id="stylesheet" href="css/special_xml.css" type="text/css" /> --}}
    <!--<div id="rightfloat"><img src="images/xls.gif" border="0" align="middle"> <a href="'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&csv=1">'._TXT_EXELFILE.'</a></div>';-->


			<div id="grille-param">
				<h2><?php echo 'Freight reception';?></h2>
				<i>Export an XML file per freight</i>
				
				<form action="{{URL('/')}}/freight-reception">
				<div style="margin-top:10px;">
					<?php echo 'Freight Number'.': ';?>
			<?php	
				if (isset($_REQUEST['choose'])) { // on veut une deroulante
			?>
			<select name="dtr_no">
                <option value="%"><?php echo 'All';?></option>
			<?php                
				$ref_mission = oci_parse($c, "SELECT DISTINCT dtr_no, dtr_eta, mtr_lib, dtr_etd
												FROM ms_dossier_transp dtr, ms_pack_cli_tete pct, xn_mode_transp mtr
												WHERE dtr.dtr_no = pct.pct_no_dossier 
												AND dtr.dtr_mtr_code = mtr.mtr_code 
												AND to_char(dtr_dt_creat,'YYYY') > '2004' 
												AND dtr.dtr_mtr_code in ('A','S','R') 
												ORDER BY dtr_no DESC");
															
				ociexecute($ref_mission, OCI_DEFAULT);
			
				while (oci_fetch($ref_mission)) {
					echo '<option value = "'.oci_result($ref_mission, "DTR_NO").'">'.oci_result($ref_mission, "DTR_NO").' -- '.oci_result($ref_mission, "MTR_LIB").' -- ETD:'.oci_result($ref_mission, "DTR_ETD").' -- ETA:'.oci_result($ref_mission, "DTR_ETA").' </option>';
				}
			?>
			</select>
			<?php
				} else { // on veut pas de deroulante
			?>
			<input type="text" name="dtr_no" value="<?php echo isset($_REQUEST['DTR']);?>" maxlength="25" size="20"> 
			<a href="<?php echo URL('/').'/freight-reception?&choose=O';?>"><?php echo 'Search list';?></a>
			<?php        
				}
			?>
			</div>
    
				<div style="margin-top:20px;">
					<b style="color:#e46c03">Unifield:</b>
					<span style="margin-left:20px;">
						<input type="submit" name="search" value="<?php echo 'Search';?>">
					</span>
				</div>                
				</form>
			</div>
			<?php
				if(isset($_REQUEST['search'])){
					$query = "SELECT MS_PACK_CLI_TETE.PCT_NO_DOSSIER,
							MS_PACK_CLI_TETE.PCT_REF_CMDE1,
							XN_MODE_TRANSP.MTR_LIB,
							MS_PACK_CLI_LIGNE.PCL_DES2,
							MS_PACK_CLI_LIGNE.PCL_ART_CODE,
							TO_CHAR(MS_PACK_CLI_LIGNE.PCL_DT_PEREMPTION,'DD/MM/YYYY') PCL_DT_PEREMPTION,
							MS_PACK_CLI_LIGNE.PCL_NO_SERIE_LOT,
							MIN(MS_PACK_CLI_LIGNE.PCL_DES1) PCL_DES1,
							SUM(MS_PACK_CLI_LIGNE.PCL_QTE_LIV) QTE,
							AVG(MS_PACK_CLI_LIGNE.PCL_MT_HT_LIGNE/MS_PACK_CLI_LIGNE.PCL_QTE_LIV) PX
									
					FROM MS_PACK_CLI_TETE,
						(SELECT * FROM MS_PACK_CLI_LIGNE UNION ALL SELECT * FROM TR_PACK_CLI_LIGNE_INTER) MS_PACK_CLI_LIGNE,
						MS_DOSSIER_TRANSP,
						XN_MODE_TRANSP
									
						WHERE MS_PACK_CLI_TETE.PCT_NO_DOSSIER = :FRET
							AND MS_DOSSIER_TRANSP.DTR_NO = MS_PACK_CLI_TETE.PCT_NO_DOSSIER
									
							AND MS_DOSSIER_TRANSP.DTR_MTR_CODE = XN_MODE_TRANSP.MTR_CODE(+) 
									
							AND MS_PACK_CLI_TETE.PCT_NO = MS_PACK_CLI_LIGNE.PCL_PCT_NO
							AND MS_PACK_CLI_TETE.PCT_DEP_CODE = MS_PACK_CLI_LIGNE.PCL_DEP_CODE
							AND MS_PACK_CLI_TETE.PCT_DEP_SOC_CODE = MS_PACK_CLI_LIGNE.PCL_DEP_SOC_CODE 
												
					GROUP BY MS_PACK_CLI_TETE.PCT_NO_DOSSIER,
									MS_PACK_CLI_TETE.PCT_REF_CMDE1,
									XN_MODE_TRANSP.MTR_LIB,
									MS_PACK_CLI_LIGNE.PCL_DES2,
									MS_PACK_CLI_LIGNE.PCL_ART_CODE,
									TO_CHAR(MS_PACK_CLI_LIGNE.PCL_DT_PEREMPTION,'DD/MM/YYYY'),
									MS_PACK_CLI_LIGNE.PCL_NO_SERIE_LOT
												
					ORDER BY MS_PACK_CLI_TETE.PCT_REF_CMDE1,PCL_DES2,MS_PACK_CLI_LIGNE.PCL_ART_CODE
							";
					$stmt = oci_parse($c,$query);
					
					oci_bind_by_name($stmt,":fret",$_REQUEST['dtr_no']);
					ociexecute($stmt, OCI_DEFAULT);
					$nrows=ocifetchstatement($stmt, $resultat,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);								

					$lastRfCmde = "";

					//echo '<pre>';print_r($query);echo '</pre>';


					foreach($resultat as $uneLigne){
						if($lastRfCmde == "" || $lastRfCmde <> $uneLigne['PCT_REF_CMDE1']){
							if($lastRfCmde != ""){
								$filename=ltrim(str_replace('/','_',$lastRfCmde));
								$filename=str_replace(' ','',$filename);
							
								$doc->dump_file('/tmp/'.$_REQUEST['dtr_no'].'_incoming_'.$filename.'.xml', false, true);		
								$tabDoc[] = $_REQUEST['dtr_no'].'_incoming_'.$filename;	
							}
							
							$doc = new DOMDocument('1.0');

							$doc->formatOutput = true;
							
							$root = $doc->createElement("data");
							$doc->appendChild($root);
							
							$record = $doc->createElement("record");
							$record->setAttribute("model","stock.picking");
							$record->setAttribute("key","name");
							$root->appendChild($record);
							
							$freight = $doc->createElement("field");
							$freight->setAttribute("name","freight");
							$record->appendChild($freight);
							
							$name = $doc->createElement("field");
							$name->setAttribute("name","name");
							$name->appendChild($doc->createTextNode($uneLigne['PCT_NO_DOSSIER']));
							$record->appendChild($name);
							
							$origin = $doc->createElement("field");
							$origin->setAttribute("name","origin");
							$origin->appendChild($doc->createTextNode($uneLigne['PCT_REF_CMDE1']));
							$record->appendChild($origin);
							
							$partner_id = $doc->createElement("field");
							$partner_id->setAttribute("name","partner_id");
							$partner_id->setAttribute("key","name");
							$record->appendChild($partner_id);
							
							$nameSupply = $doc->createElement("field");
							$nameSupply->setAttribute("name","name");
							$nameSupply->appendChild($doc->createTextNode('MSF Supply'));
							$partner_id->appendChild($nameSupply);
							
							$transport_mode = $doc->createElement("field");
							$transport_mode->setAttribute("name","transport_mode");
							$transport_mode->appendChild($doc->createTextNode(ucfirst(strtolower($uneLigne['MTR_LIB']))));
							$record->appendChild($transport_mode);
							
							$note = $doc->createElement("field");
							$note->setAttribute("name","note");
							$record->appendChild($note);
							
							$message_esc = $doc->createElement("field");
							$message_esc->setAttribute("name","message_esc");
							$record->appendChild($message_esc);
							
							$move_lines = $doc->createElement("field");
							$move_lines->setAttribute("name","move_lines");
							$record->appendChild($move_lines);
						}
						
						
						$recordLine = $doc->createElement("record");
						//$record->appendChild($recordLine);
						$move_lines->appendChild($recordLine);
						
						$line_number = $doc->createElement("field");
						$line_number->setAttribute("name","line_number");
						$line_number->appendChild($doc->createTextNode($uneLigne['PCL_DES2']));
						$recordLine->appendChild($line_number);
						
						$product_id_line = $doc->createElement("field");
						$product_id_line->setAttribute("name","product_id");
						$product_id_line->setAttribute("key","default_code,name");
						$recordLine->appendChild($product_id_line);
						
						$product_code = $doc->createElement("field");
						$product_code->setAttribute("name","product_code");
						$product_code->appendChild($doc->createTextNode($uneLigne['PCL_ART_CODE']));
						$product_id_line->appendChild($product_code);
						
						$product_name = $doc->createElement("field");
						$product_name->setAttribute("name","product_name");
						$product_name->appendChild($doc->createTextNode(utf8_decode($uneLigne['PCL_DES1'])));
						$product_id_line->appendChild($product_name);
						
						$product_qty = $doc->createElement("field");
						$product_qty->setAttribute("name","product_qty");
						$product_qty->appendChild($doc->createTextNode($uneLigne['QTE']));
						$recordLine->appendChild($product_qty);
						
						$product_uom = $doc->createElement("field");
						$product_uom->setAttribute("name","product_uom");
						$product_uom->setAttribute("key","name");
						$recordLine->appendChild($product_uom);
						
						$product_uom_name = $doc->createElement("field");
						$product_uom_name->setAttribute("name","name");
						$product_uom_name->appendChild($doc->createTextNode('PCE'));
						$product_uom->appendChild($product_uom_name);
						
						$price_unit = $doc->createElement("field");
						$price_unit->setAttribute("name","price_unit");
						$price_unit->appendChild($doc->createTextNode(number_format($uneLigne['PX'],3,".","")));
						$recordLine->appendChild($price_unit);
						
						$price_currency_id = $doc->createElement("field");
						$price_currency_id->setAttribute("name","price_currency_id");
						$price_currency_id->setAttribute("key","name");
						$recordLine->appendChild($price_currency_id);
						
						$price_currency_id_name = $doc->createElement("field");
						$price_currency_id_name->setAttribute("name","name");
						$price_currency_id_name->appendChild($doc->createTextNode('EUR'));
						$price_currency_id->appendChild($price_currency_id_name);
						
						$prodlot_id = $doc->createElement("field");
						$prodlot_id->setAttribute("name","prodlot_id");
						$prodlot_id->appendChild($doc->createTextNode($uneLigne['PCL_NO_SERIE_LOT']));
						$recordLine->appendChild($prodlot_id);
						
						$expired_date = $doc->createElement("field");
						$expired_date->setAttribute("name","expired_date");
						$expired_date->appendChild($doc->createTextNode($uneLigne['PCL_DT_PEREMPTION']));
						$recordLine->appendChild($expired_date);
						
						$packing_list = $doc->createElement("field");
						$packing_list->setAttribute("name","packing_list");
						$recordLine->appendChild($packing_list);
						
						$message_esc1 = $doc->createElement("field");
						$message_esc1->setAttribute("name","message_esc1");
						$recordLine->appendChild($message_esc1);
						
						$message_esc2 = $doc->createElement("field");
						$message_esc2->setAttribute("name","message_esc2");
						$recordLine->appendChild($message_esc2);
						
						$lastRfCmde = $uneLigne['PCT_REF_CMDE1'];
					}
					
					$filename=ltrim(str_replace('/','_',$lastRfCmde));
					$filename=str_replace(' ','',$filename);

					
					header('Content-type: text/xml');
    				header('Content-disposition: attachment; filename="'.$_REQUEST['dtr_no'].'_incoming_'.$filename.'.xml"');
					ob_get_clean();
					if ($nrows>0) echo $doc->saveXML();
					exit;
					$tabDoc[] = $_REQUEST['dtr_no'].'_incoming_'.$filename;
				}
			?>

		</div>
	</div>

@endsection
