@extends('layouts.app')

@section('content')

	<div class="section section-breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Fior Annex</h1>
				</div>
			</div>
		</div>
	</div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'fior_annex',
					'title'=>'Fior Annex'
				);

				//Si aucun filtre, on met un filtre sur les dates pour ne pas avoir trop de lignes
				if(!isset($_REQUEST['dateAfter']) &&
					!isset($_REQUEST['dateBefore'])
					){
					//$dateToday = new DateTime(date('d/m/Y'));
					$dateToday = new DateTime('NOW');
					$interval = new DateInterval('P1M');

					$dateT = new DateTime('NOW');
					$int = new DateInterval('P10D');

					$dateToday->sub($interval);
					$_REQUEST['dateAfter'] = $dateToday->format('d/m/Y');

					//$dateT->add($int);
					$_REQUEST['dateBefore'] = $dateT->format('d/m/Y');
				}

				$fields[]=array(
					'sqlfield'=>'CCT_NOM_DISP',				// champ SQL pur
					'title'=>'Dispatch',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"order-view?order_no=' || CCT_NO || '\">' || CCT_NO || '</a>'",
					'title'=>'Order',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'ORDER_NO',					//alias
					'sortsqlfield'=>'ORDER_NO',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'ART_FAA_CODE',				// champ SQL pur
					'title'=>'Group',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'ART_SFA_CODE',				// champ SQL pur
					'title'=>'Family',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_ART_CODE',				// champ SQL pur
					'title'=>'Articles',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_ART_VAR1',				// champ SQL pur
					'title'=>'Version',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_DES1',		// champ SQL pur
					'title'=>'Article description',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_DES2',				// champ SQL pur
					'title'=>'No item',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCT_DT_CMDE',				// champ SQL pur
					'title'=>'Date created',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_QTE_CMDE',		// champ SQL pur
					'title'=>'Order Qty',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',

					'aliasname'=>'ORDERQTY',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_COND_VTE',				// champ SQL pur
					'title'=>'Condition',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>
					"CASE
					WHEN CCT_TYD_CODE = 'CS' THEN NULL
					WHEN CCT_TYD_CODE = 'CC' THEN CCL_PX_VTE_NET
					END",		// champ SQL pur
					'title'=>'Unit price',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',

					'aliasname'=>'UNITPRICE',					//alias
					'sortsqlfield'=>'',					//sort	CCL_QTE_RESTE
				);

				$fields[]=array(
					'sqlfield'=>
					"CASE
					WHEN CCT_TYD_CODE = 'CS' THEN NULL
					WHEN CCT_TYD_CODE = 'CC' THEN CCL_MT_HT_LIGNE
					END",		// champ SQL pur
					'title'=>'Total price',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',

					'aliasname'=>'TOTALPRICE',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCT_DEV_CODE',		// champ SQL pur
					'title'=>'Currency',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCT_REF_CMDE_CLI1',				// champ SQL pur
					'title'=>'Ref Order',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCT_CHA_CODE',				// champ SQL pur
					'title'=>'Project Code',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCT_NOTRE_REF',				// champ SQL pur
					'title'=>'KSU ref',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"'60040'",				// champ SQL pur
					'title'=>'KSU ref',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_NO_DOSSIER',				// champ SQL pur
					'title'=>'Freight no',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'FCT_NO_FACTURE',				// champ SQL pur
					'title'=>'Tr invoice',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'FCT_MT_BASE_REMISE',				// champ SQL pur
					'title'=>'Tr total cost',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"packing-view?pk=' || PCT_NO || '\">' || PCT_NO || '</a>'",
					'title'=>'Packing',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'PK',					//alias
					'sortsqlfield'=>'PK',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_NO_FACTURE',				// champ SQL pur
					'title'=>'Goods inv',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"(SELECT FCT_DT FROM XN_FAC_CLI_TETE WHERE FCT_NO_FACTURE = PCT_NO_FACTURE)",				// champ SQL pur
					'title'=>'Goods inv date',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'INVGDDT',					//alias
					'sortsqlfield'=>'INVGDDT',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'MTR_LIB',		// champ SQL pur
					'title'=>'Transport',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'TRANSPORT',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCL_NO_SERIE_LOT',				// champ SQL pur
					'title'=>'Batch no',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCL_DT_PEREMPTION',				// champ SQL pur
					'title'=>'Expiry',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>
					"CASE
					WHEN CCT_TYD_CODE = 'CS' THEN 'DRAFT'
					WHEN CCT_TYD_CODE = 'CA' THEN 'DRAFT'
					WHEN CCT_TYD_CODE = 'CT' THEN 'TECHNICAL'
					WHEN CCT_TYD_CODE = 'CX' THEN 'CANCELLED'
					WHEN CCT_TYD_CODE = 'CC' THEN CASE
					WHEN PCL_PCT_NO IS NOT NULL AND DTR_NO IS NULL THEN 'RTS'
					WHEN DTR_NO IS NOT NULL AND DTR_INDEX <> 'Z' THEN 'ON FREIGHT'
					WHEN DTR_NO IS NOT NULL AND DTR_INDEX = 'Z' THEN 'DELIVERED'
					ELSE 'CONFIRMED'
					END
					END",		// champ SQL pur
					'title'=>'Status',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'STATUS_ALIAS',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "
				FROM XN_CMDE_CLI_TETE, XN_CMDE_CLI_LIGNE, MS_PACK_CLI_LIGNE, XN_ART, MS_PACK_CLI_TETE, XN_FAC_CLI_TETE, XN_MODE_TRANSP, MS_DOSSIER_TRANSP, XN_CLI
				WHERE PCL_CCT_NO(+) = CCL_CCT_NO
				AND PCL_ART_CODE(+) = CCL_ART_CODE
				AND CCT_NO = CCL_CCT_NO(+)
				AND ART_CODE(+) = CCL_ART_CODE
				AND PCT_NO = PCL_PCT_NO(+)
				AND PCT_CCT_NO = PCL_CCT_NO(+)
				AND PCT_CCT_NO(+) = CCT_NO
				AND PCT_CCT_NO(+) = CCL_CCT_NO
				AND FCT_CCT_REF_CMDE_CLI1(+) = TO_CHAR(PCT_NO_DOSSIER)
				AND MTR_CODE(+) = DTR_MTR_CODE
				AND DTR_NO(+) = PCT_NO_DOSSIER
				AND CLI_CODE(+) = CCT_CLI_CODE_LIVRE ";

				if(isset($_REQUEST['procode']) && trim($_REQUEST['procode']) != ""){
					$query .= " AND CCT_CHA_CODE = :procode ";
				}
				if(isset($_REQUEST['dispcode']) && trim($_REQUEST['dispcode']) != ""){
					$query .= " AND CCT_NOM_DISP = :dispcode ";
				}
				if(isset($_REQUEST['dateAfter']) && trim($_REQUEST['dateAfter']) != ""){
					$query .= " AND CCT_DT_CREAT >= TO_DATE(:dateAfter,'DD/MM/YYYY') ";
				}

				if(isset($_REQUEST['dateBefore']) && trim($_REQUEST['dateBefore']) != ""){
					$query .= " AND CCT_DT_CREAT <= TO_DATE(:dateBefore,'DD/MM/YYYY')+1 ";
				}

				if(isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) && 
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE = 'CS'
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA')) ";
				}
				if(isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) && 
				!isset($_REQUEST['cancelled'])){
					$query .= " AND PCL_PCT_NO IS NULL AND (CCT_TYD_CODE <> 'CX'
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA'))";
				}
				if(isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) && 
				!isset($_REQUEST['cancelled'])){
					$query .= " AND DTR_NO IS NULL AND (CCT_TYD_CODE <> 'CX'
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA'))";
				}
				if(isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND NOT DTR_INDEX(+) = 'Z' AND (CCT_TYD_CODE <> 'CX'
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA'))";
				}
				if(isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE <> 'CX'
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA')) ";
				}
				//DRAFT OR
				if(isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE = 'CS'
					OR (PCL_PCT_NO IS NOT NULL AND DTR_NO IS NULL)
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA')) ";
				}
				if(isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE = 'CS'
					OR (DTR_NO IS NOT NULL AND DTR_INDEX <> 'Z')
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA')) ";
				}
				if(isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE = 'CS'
					OR (DTRC_DT_RC IS NOT NULL OR (DTR_NO IS NOT NULL AND DTR_INDEX = 'Z'))
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA')) ";
				}
				if(isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE = 'CS'
					OR (CCT_TYD_CODE = 'CX')
					OR (CCT_TYD_CODE = 'CT')
					OR (CCT_TYD_CODE = 'CA')) ";
				}

				//confirmed
				if(!isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND CCT_TYD_CODE = 'CC'
					AND PCL_PCT_NO IS NULL ";
				}
				if(!isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND CCT_TYD_CODE = 'CC'
					AND DTR_NO IS NULL ";
				}
				if(!isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND CCT_TYD_CODE = 'CC'
					AND NOT DTR_INDEX(+) = 'Z' ";
				}
				if(!isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND CCT_TYD_CODE = 'CC' ";
				}
				//CONFIRMED OR
				if(!isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE = 'CC' AND PCL_PCT_NO IS NULL
					OR (DTR_NO IS NOT NULL AND DTR_INDEX <> 'Z')) ";
				}
				if(!isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE = 'CC' AND PCL_PCT_NO IS NULL 
					OR (DTRC_DT_RC IS NOT NULL OR (DTR_NO IS NOT NULL AND DTR_INDEX = 'Z'))) ";
				}
				if(!isset($_REQUEST['draft']) &&
				isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE = 'CC'
					OR (CCT_TYD_CODE IS NOT NULL AND CCT_TYD_CODE = 'CX')) 
					AND PCL_PCT_NO IS NULL ";
				}

				//rts
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND PCL_PCT_NO IS NOT NULL 
					AND DTR_NO IS NULL ";
				}
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND PCL_PCT_NO IS NOT NULL 
					AND NOT DTR_INDEX(+) = 'Z' ";
				}
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND PCL_PCT_NO IS NOT NULL ";
				}
				//RTS OR
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (PCL_PCT_NO IS NOT NULL AND DTR_NO IS NULL
					OR (DTRC_DT_RC IS NOT NULL OR (DTR_NO IS NOT NULL AND DTR_INDEX = 'Z'))) ";
				}
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				isset($_REQUEST['cancelled'])){
					$query .= " AND (PCL_PCT_NO IS NOT NULL
					OR (CCT_TYD_CODE IS NOT NULL AND CCT_TYD_CODE = 'CX')) 
					AND DTR_NO IS NULL ";
				}

				//onfreight
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND DTR_NO IS NOT NULL 
					AND DTR_INDEX <> 'Z' ";
				}
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (DTR_NO IS NOT NULL OR (DTRC_DT_RC IS NOT NULL)) ";
				}
				//onfreight or
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) &&
				isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE IS NOT NULL AND CCT_TYD_CODE = 'CX'
					OR (DTR_NO IS NOT NULL AND DTR_INDEX <> 'Z')) ";
				}

				//delivered
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				!isset($_REQUEST['cancelled'])){
					$query .= " AND (DTR_NO IS NOT NULL AND DTR_INDEX = 'Z'
					OR (DTRC_DT_RC IS NOT NULL)) ";
				}
				//delivered or
				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				isset($_REQUEST['delivered']) &&
				isset($_REQUEST['cancelled'])){
					$query .= " AND (CCT_TYD_CODE IS NOT NULL AND CCT_TYD_CODE = 'CX'
					OR (DTR_NO IS NOT NULL AND DTRC_DT_RC IS NOT NULL)) ";
				}

				if(!isset($_REQUEST['draft']) &&
				!isset($_REQUEST['confirmed']) && 
				!isset($_REQUEST['rts']) && 
				!isset($_REQUEST['onfreight']) && 
				!isset($_REQUEST['delivered']) && 
				isset($_REQUEST['cancelled'])){
					$query .= " AND CCT_TYD_CODE = 'CX' ";
				}

				if (session()->get('oc') != "") {
					$query .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
				}

				if (session()->get('country') != "") {
					$query .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
				}

				$query .= " GROUP BY CCT_NOM_DISP, CCT_NO, CCL_ART_CODE, CCL_ART_VAR1, CCL_DES1 ,CCL_DES2 ,CCT_DT_CMDE, CCL_QTE_CMDE, CCL_COND_VTE, CCL_PX_VTE_NET, 
CCL_MT_HT_LIGNE, CCT_DEV_CODE, CCT_REF_CMDE_CLI1 ,CCT_CHA_CODE ,CCT_NOTRE_REF ,'60040', ART_FAA_CODE ,ART_SFA_CODE, PCT_NO_DOSSIER, PCT_NO, PCT_NO_FACTURE,
FCT_MT_BASE_REMISE, FCT_NO_FACTURE, FCT_MT_BASE_REMISE, MTR_LIB, PCL_NO_SERIE_LOT ,PCL_DT_PEREMPTION, CCT_TYD_CODE, PCL_PCT_NO, DTR_NO, DTR_INDEX";

				if (isset($_REQUEST['confirmed'])) {
					$query .= " UNION

					CCT_NOM_DISP, '<a href=\"http://10.210.168.40/reports/order_view.php?order_no=' || CCT_NO || '&Go=Go\">' || CCT_NO || '</a>',
					ART_FAA_CODE, ART_SFA_CODE, CCL_ART_CODE, CCL_ART_VAR1, CCL_DES1, CCL_DES2, CCT_DT_CMDE, CCL_QTE_RESTE, CCL_COND_VTE, CCL_PX_VTE_NET, CCL_MT_HT_LIGNE, CCT_DEV_CODE, CCT_REF_CMDE_CLI1, CCT_CHA_CODE,
					CCT_NOTRE_REF, '60040', FCT_NO_FACTURE, NULL, NULL, MTR_LIB, NULL, NULL, 'CONFIRMED'
					FROM XN_CMDE_CLI_TETE,XN_CMDE_CLI_LIGNE,XN_MODE_TRANSP, MS_DOSSIER_TRANSP, XN_CLI, XN_FAC_CLI_TETE
					WHERE CCT_NO = CCL_CCT_NO
					AND MTR_CODE = CCT_MTR_CODE
					AND CCL_QTE_RESTE > 0
					AND CCL_INDEX = '4'
					AND CCT_TYD_CODE = 'CC'
					AND CLI_CODE(+) = CCT_CLI_CODE_LIVRE
					AND ART_CODE = CCL_ART_CODE
					AND FCT_CCT_REF_CMDE_CLI1(+) = TO_CHAR(DTR_NO) ";
					
					if(isset($_REQUEST['procode']) && trim($_REQUEST['procode']) != ""){
						$query .= " AND CCT_CHA_CODE = :procode ";
					}
					if(isset($_REQUEST['dispcode']) && trim($_REQUEST['dispcode']) != ""){
						$query .= " AND CCT_NOM_DISP = :dispcode ";
					}
					if(isset($_REQUEST['dateAfter']) && trim($_REQUEST['dateAfter']) != ""){
						$query .= " AND CCT_DT_CREAT >= TO_DATE(:dateAfter,'DD/MM/YYYY') ";
					}
					
					if(isset($_REQUEST['dateBefore']) && trim($_REQUEST['dateBefore']) != ""){
						$query .= " AND CCT_DT_CREAT <= TO_DATE(:dateBefore,'DD/MM/YYYY')+1 ";
					}
					if(isset($_REQUEST['confirmed']) && trim($_REQUEST['confirmed']) != ""){
						$query .= " AND CCL_QTE_RESTE > 0
						AND CCL_INDEX = '4'
						";
					}
					if (session()->get('oc') != "") {
						$query .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
					}

					if (session()->get('country') != "") {
						$query .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
					}

					$query .= "
					GROUP BY CCT_NOM_DISP, CCT_REF_CMDE_CLI1, CCT_CHA_CODE, CCT_NO, CCL_ART_CODE, CCL_DES1, CCT_DT_FERM, CCT_MTR_CODE, CCL_QTE_RESTE, '60040', 
					CCL_PX_VTE_NET, CCT_DEV_CODE, MTR_LIB, ART_FAA_CODE, ART_SFA_CODE, CCL_ART_VAR1, CCL_DES2, CCT_DT_CMDE, CCL_COND_VTE, CCT_NOTRE_REF, FCT_NO_FACTURE,
					FCT_MT_BASE_REMISE, FCT_DT ";
					
				}




				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = 'CCT_NO';
					$_REQUEST['order']="ASC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];
				
				//echo "<pre>$query</pre>";
				
				$tab_filter	= array();

				if(isset($_REQUEST['dateAfter']) && trim($_REQUEST['dateAfter']) != ""){
					array_push($tab_filter,array('name'=>'dateAfter','value'=>trim($_REQUEST['dateAfter'])));
				}

				if(isset($_REQUEST['dateBefore']) && trim($_REQUEST['dateBefore']) != ""){
					array_push($tab_filter,array('name'=>'dateBefore','value'=>trim($_REQUEST['dateBefore'])));
				}

				$result = execute_request($c,$query,$tab_filter);

				if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
                    render_table_xls($result, $fields, $generalparams);	
                    exit();
                }
			@endphp
			<div class="container" id="grille-param">
				<form method="GET" action="{{URL('/')}}/fior-annex" autocomplete="off">

					<div class="div_filter">
						<label>Date between:</label>
						<input type="text" name="dateAfter" id="dateAfter" value="<?php echo $_REQUEST['dateAfter'];?>" size="9" maxlength="10"/>
						<span>and</span>
						<input type="text" name="dateBefore" id="dateBefore" value="<?php echo $_REQUEST['dateBefore'];?>" size="9" maxlength="10"/>
						
						<input type="submit" value="Go"/>
					</div>
					
					</form>
			</div>
			<?php
				render_table($result, $fields);
			?>
		</div>
	</div>
@endsection