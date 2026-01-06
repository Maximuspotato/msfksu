@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Transport Cost per Packing</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'tr_cost_pk',
					'title'=>'Tr Cost Per Packing'
				);

				$fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"packing-view?pk=' || PCT_NO || '\">' || PCT_NO || '</a>'",
					'title'=>'Packing No',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'PKNO',					//alias
					'sortsqlfield'=>'PKNO',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"order-view?order_no=' || PCT_CCT_NO || '\">' || PCT_CCT_NO || '</a>'",
					'title'=>'Client Order',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'OP',					//alias
					'sortsqlfield'=>'OP',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_CHA_CODE',				// champ SQL pur
					'title'=>'Project',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_TOT_PDS',				// champ SQL pur
					'title'=>'Weight',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_TOT_VOL',				// champ SQL pur
					'title'=>'Volume',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				// $fields[]=array(
				// 	'sqlfield'=>'MTR_LIB',				// champ SQL pur
				// 	'title'=>'Tr Mode',					// Title for the column
					
				// 	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
				// 	'decimal'=>'0',
					
				// 	'aliasname'=>'',					//alias
				// 	'sortsqlfield'=>'',					//sort	
				// );

				if (isset($_REQUEST['cm'])) {
				$fields[]=array(
					'sqlfield'=>"
					ROUND(SUM(CASE
					WHEN MTR_LIB = 'Air' THEN CASE
WHEN FCT_DEV_CODE = 'USD' THEN (FCT_MT_BASE_REMISE * PCT_TOT_PDS / TOT.WGHT)
WHEN FCT_DEV_CODE = 'KES' THEN (FCT_MT_BASE_REMISE * PCT_TOT_PDS / TOT.WGHT) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT_CREAT)
WHEN FCT_DEV_CODE = 'EUR' THEN ((FCT_MT_BASE_REMISE * PCT_TOT_PDS / TOT.WGHT) / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND DTX_DT_DEB = FCT_DT_CREAT)) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT_CREAT)
END
					WHEN MTR_LIB = 'Road' THEN CASE
WHEN FCT_DEV_CODE = 'USD' THEN (FCT_MT_BASE_REMISE * PCT_TOT_VOL / TOT.VOL)
WHEN FCT_DEV_CODE = 'KES' THEN (FCT_MT_BASE_REMISE * PCT_TOT_VOL / TOT.VOL) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT_CREAT)
WHEN FCT_DEV_CODE = 'EUR' THEN ((FCT_MT_BASE_REMISE * PCT_TOT_VOL / TOT.VOL) / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND DTX_DT_DEB = FCT_DT_CREAT)) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT_CREAT)
END
					WHEN MTR_LIB = 'Sea' THEN CASE
WHEN FCT_DEV_CODE = 'USD' THEN (FCT_MT_BASE_REMISE * PCT_TOT_VOL / TOT.VOL)
WHEN FCT_DEV_CODE = 'KES' THEN (FCT_MT_BASE_REMISE * PCT_TOT_VOL / TOT.VOL) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT_CREAT)
WHEN FCT_DEV_CODE = 'EUR' THEN ((FCT_MT_BASE_REMISE * PCT_TOT_VOL / TOT.VOL) / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND DTX_DT_DEB = FCT_DT_CREAT)) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT_CREAT)
END
					END),2) ",				// champ SQL pur
					'title'=>'Costs',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'AMTCOST',					//alias
					'sortsqlfield'=>'',					//sort	
				);
				}

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "
				FROM MS_PACK_CLI_TETE, XN_MODE_TRANSP, MS_DOSSIER_TRANSP , XN_FAC_CLI_TETE, XN_CLI,
				(SELECT SUM(PCT_TOT_PDS)WGHT, SUM(PCT_TOT_VOL)VOL, PCT_NO_DOSSIER CM FROM MS_PACK_CLI_TETE GROUP BY PCT_NO_DOSSIER)TOT
				WHERE MTR_CODE = DTR_MTR_CODE
				AND DTR_NO = PCT_NO_DOSSIER
				AND FCT_CCT_REF_CMDE_CLI1 = TO_CHAR(PCT_NO_DOSSIER)
				AND CLI_CODE = PCT_CLI_CODE_LIV ";

				if(isset($_REQUEST['cm'])){
					$query .= " AND PCT_NO_DOSSIER = :cm ";
					$query .= " AND TOT.CM = :cm ";
				}

				if (session()->get('oc') != "") {
					$query .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
				}

				if (session()->get('country') != "") {
					$query .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
				}


				$query .= "GROUP BY PCT_NO, PCT_CCT_NO, PCT_CHA_CODE, PCT_TOT_PDS, PCT_TOT_VOL, MTR_LIB";

				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = $fields[0]['sqlfield'];
					$_REQUEST['order']="DESC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

				$tab_filter	= array();

				if(isset($_REQUEST['cm']) && trim($_REQUEST['cm']) != ""){
					array_push($tab_filter,array('name'=>'cm','value'=>trim($_REQUEST['cm'])));
				}

				//echo '<pre>'.$query.'</pre>';
				if(isset($_REQUEST['cm'])){
					$result = execute_request($c,$query,$tab_filter);
				}

				if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
                    render_table_xls($result, $fields, $generalparams);	
                    exit();
                }
			@endphp
			<div class="container" id="grille-param">
				<form method="GET" action="{{URL('/')}}/tr-packing" autocomplete="off">
					<div class="div_filter">
					
						<label>Cargo Manifest:</label>
						<input type="text" name="cm" id="cm" value="<?php if (isset($_REQUEST['cm'])) echo $_REQUEST['cm'];?>" required><br><br>
					
						<input type="submit" value="Go"/><br><br>
					</div>
				</form>
				<div class="div_filter">
					<?php
					if (isset($_REQUEST['cm'])) {
						echo '<label>Invoice(s): </label>';
						$query_inv = " SELECT FCT_NO_FACTURE FROM XN_FAC_CLI_TETE WHERE FCT_CCT_REF_CMDE_CLI1 = :cm ";
						$stmt = oci_parse($c, $query_inv);
						ocibindbyname($stmt, ":cm", $_REQUEST['cm']);
						ociexecute($stmt, OCI_DEFAULT);
						$nrows = ocifetchstatement($stmt, $result_inv,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
						
						foreach($result_inv as $one_inv){
							echo $one_inv['FCT_NO_FACTURE'].' ,';
						}
						
						echo '<br>';
						echo '<label>Total Invoice: </label>';
						$query_amt = " SELECT SUM(CASE
WHEN FCT_DEV_CODE = 'USD' THEN FCT_MT_BASE_REMISE
WHEN FCT_DEV_CODE = 'KES' THEN FCT_MT_BASE_REMISE * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT_CREAT)
WHEN FCT_DEV_CODE = 'EUR' THEN (FCT_MT_BASE_REMISE / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND DTX_DT_DEB = FCT_DT_CREAT)) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT_CREAT)
END) AMT, 'USD' CURR FROM XN_FAC_CLI_TETE
						WHERE FCT_CCT_REF_CMDE_CLI1 = :cm ";
						$stmt = oci_parse($c, $query_amt);
						ocibindbyname($stmt, ":cm", $_REQUEST['cm']);
						ociexecute($stmt, OCI_DEFAULT);
						$nrows = ocifetchstatement($stmt, $result_amt,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
						
						foreach($result_amt as $one_amt){
							echo $one_amt['AMT'].' '.$one_amt['CURR'];
	}

						echo '<br>';
						echo '<label>Tr Mode: </label>';
						$query_tr = " SELECT MTR_LIB FROM XN_MODE_TRANSP, MS_DOSSIER_TRANSP WHERE MTR_CODE = DTR_MTR_CODE AND DTR_NO = :cm ";
						$stmt = oci_parse($c, $query_tr);
						ocibindbyname($stmt, ":cm", $_REQUEST['cm']);
						ociexecute($stmt, OCI_DEFAULT);
						$nrows = ocifetchstatement($stmt, $result_tr,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
						
						foreach($result_tr as $one_tr){
							echo $one_tr['MTR_LIB'];
						}
						echo '<br><br>';
					}
					?>
				</div>
			</div>
			@php
				if (isset($_REQUEST['cm'])) {
					render_table($result, $fields);
				}
			@endphp
		</div>
	</div>

@endsection
