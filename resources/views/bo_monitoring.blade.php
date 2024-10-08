@extends('layouts.app')

@section('content')

	<div class="section section-breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Backorder Monitoring</h1>
				</div>
			</div>
		</div>
	</div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'back_order_monitoring',
					'title'=>'Back Order Monitoring'
				);

				//Si aucun filtre, on met un filtre sur les dates pour ne pas avoir trop de lignes
				if( !isset($_REQUEST['procode']) &&
					!isset($_REQUEST['dispcode']) &&
					!isset($_REQUEST['dateAfter']) &&
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
					'sqlfield'=>'ROW_NUMBER() OVER (ORDER BY CCT_NO DESC)',				// champ SQL pur
					'title'=>'#',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'INDEXNO',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCT_NOM_DISP',				// champ SQL pur
					'title'=>'Dispatch',					// Title for the column
					
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
					'sqlfield'=>"'<a target=\"_blank\" href=\"order-view?order_no=' || CCT_NO || '\">' || CCT_NO || '</a>'",
					'title'=>'Order',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'ORDER_NO',					//alias
					'sortsqlfield'=>'ORDER_NO',					//sort	
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
					'sqlfield'=>'CCL_DES1',		// champ SQL pur
					'title'=>'Article description',					// Title for the column
					
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

				$fields[]=array(
					'sqlfield'=>
					"CASE
					WHEN PCL_PCT_NO IS NULL THEN CCL_QTE_CMDE
					WHEN PCL_PCT_NO IS NOT NULL THEN SUM(PCL_QTE_LIV)
					END",		// champ SQL pur
					'title'=>'Order Qty',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',

					'aliasname'=>'ORDERQTY',					//alias
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
					'sqlfield'=>"CCT_DT_FERM",		// champ SQL pur
					'title'=>'RTS Date',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>"",					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"packing-view?pk=' || PCL_PCT_NO || '\">' || PCL_PCT_NO || '</a>'",
					'title'=>'Packing',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'PK',					//alias
					'sortsqlfield'=>'PK',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"freight-view?cm=' || DTR_NO || '\">' || DTR_NO || '</a>'",
					'title'=>'Manifest',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'CM',					//alias
					'sortsqlfield'=>'CM',					//sort	
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
					'sqlfield'=>
					"CASE
					WHEN DTR_NO IS NOT NULL THEN 'Mary.Karanja@brussels.msf.org'
					ELSE 'David.Mutua@brussels.msf.org'
					END",		// champ SQL pur
					'title'=>'Contact',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'CONTACT',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'DTRC_DT_RC',		// champ SQL pur
					'title'=>'Recieved',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "
				FROM XN_CMDE_CLI_TETE, XN_CMDE_CLI_LIGNE, MS_PACK_CLI_LIGNE, MS_PACK_CLI_TETE, MS_DOSSIER_TRANSP, XN_MODE_TRANSP, EXT_DOSSIER_TRANSP_RC, XN_CLI
				WHERE CCT_NO = CCL_CCT_NO
				AND MTR_CODE = CCT_MTR_CODE
				AND CCL_CCT_NO=PCL_CCT_NO(+)
				AND CCL_NO_LIGNE=PCL_CCL_NO_LIGNE(+)
				AND PCT_NO(+) = PCL_PCT_NO
				AND DTR_NO(+) = PCT_NO_DOSSIER
				AND DTR_NO= DTRC_DTR_NO(+)
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

				$query .= " GROUP BY CCT_NOM_DISP, CCT_REF_CMDE_CLI1, CCT_CHA_CODE, CCT_NO, CCL_ART_CODE, CCL_DES1, CCT_TYD_CODE, CCL_QTE_RESTE,
				DTR_INDEX, PCL_QTE_LIV, CCT_DT_FERM, PCL_PCT_NO, DTR_NO, CCT_MTR_CODE, CCL_QTE_CMDE, CCL_PX_VTE_NET, CCL_MT_HT_LIGNE, CCT_DEV_CODE, MTR_LIB, DTRC_DT_RC ";

				if (isset($_REQUEST['confirmed'])) {
					$query .= " UNION

					SELECT ROW_NUMBER() OVER (ORDER BY CCT_NO DESC), CCT_NOM_DISP, CCT_REF_CMDE_CLI1, CCT_CHA_CODE, '<a href=\"http://10.210.168.40/reports/order_view.php?order_no=' || CCT_NO || '&Go=Go\">' || CCT_NO || '</a>',
					CCL_ART_CODE, CCL_DES1, 'CONFIRMED', CCL_QTE_RESTE, CCL_PX_VTE_NET, CCL_MT_HT_LIGNE, CCT_DEV_CODE, CCT_DT_FERM,
					NULL, NULL,
					MTR_LIB,
					'MSFOCB-KSU-CustomerService@brussels.msf.org', NULL
					FROM XN_CMDE_CLI_TETE,XN_CMDE_CLI_LIGNE,XN_MODE_TRANSP, MS_DOSSIER_TRANSP, XN_CLI
					WHERE CCT_NO = CCL_CCT_NO
					AND MTR_CODE = CCT_MTR_CODE
					AND CCL_QTE_RESTE > 0
					AND CCL_INDEX = '4'
					AND CCT_TYD_CODE = 'CC'
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
					GROUP BY CCT_NOM_DISP, CCT_REF_CMDE_CLI1, CCT_CHA_CODE, CCT_NO, CCL_ART_CODE, CCL_DES1, CCT_DT_FERM, CCT_MTR_CODE, CCL_QTE_RESTE, 
					CCL_PX_VTE_NET,CCL_MT_HT_LIGNE, CCT_DEV_CODE, MTR_LIB ";
					
				}




				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = 'INDEXNO';
					$_REQUEST['order']="ASC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

				$tab_filter	= array();

				if(isset($_REQUEST['procode']) && trim($_REQUEST['procode']) != ""){
					array_push($tab_filter,array('name'=>'procode','value'=>trim($_REQUEST['procode'])));
				}

				if(isset($_REQUEST['dispcode']) && trim($_REQUEST['dispcode']) != ""){
					array_push($tab_filter,array('name'=>'dispcode','value'=>trim($_REQUEST['dispcode'])));
				}

				if(isset($_REQUEST['dateAfter']) && trim($_REQUEST['dateAfter']) != ""){
					array_push($tab_filter,array('name'=>'dateAfter','value'=>trim($_REQUEST['dateAfter'])));
				}

				if(isset($_REQUEST['dateBefore']) && trim($_REQUEST['dateBefore']) != ""){
					array_push($tab_filter,array('name'=>'dateBefore','value'=>trim($_REQUEST['dateBefore'])));
				}

				//echo '<pre>'.$query.'</pre>';

				$result = execute_request($c,$query,$tab_filter);

				if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
                    render_table_xls($result, $fields, $generalparams);	
                    exit();
                }
			@endphp
			<div class="container" id="grille-param">
				<form method="GET" action="{{URL('/')}}/bo-monitoring" autocomplete="off">

					<div class="div_filter">
						<label>Project Code:</label>
						<select name="procode">
							<option></option>
					<?php
							$query_procode = " SELECT DISTINCT CCT_CHA_CODE 
												FROM XN_CMDE_CLI_TETE, XN_CLI
												WHERE CLI_CODE(+) = CCT_CLI_CODE_LIVRE
											";
							if (session()->get('oc') != "") {
								$query_procode .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
							}

							if (session()->get('country') != "") {
								$query_procode .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
							}
							$query_procode .= "ORDER BY CCT_CHA_CODE";
						$stmt = oci_parse($c, $query_procode);
						ociexecute($stmt, OCI_DEFAULT);
						$nrows = ocifetchstatement($stmt, $result_procode,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
						
						foreach($result_procode as $one_procode){
							echo '<option '.(isset($_REQUEST['procode']) && $one_procode['CCT_CHA_CODE'] == $_REQUEST['procode']?' selected ':'').'>'.$one_procode['CCT_CHA_CODE'].'</option>';
						}
					?>
						</select>
						<div class="dropdown choose-country" style="float:right;display:inline;">
							@if (session()->get('position') == 'international' || session()->get('position') == 'hq')
								@if (session()->get('country_code') != "")
								 <a class="#" data-toggle="dropdown" href="">{{session()->get('country')}} <i class="fas fa-caret-down"></i></a>
								@else
									<a class="#" data-toggle="dropdown" href="">COUNTRY <i class="fas fa-caret-down"></i></a>
								@endif
								
								<ul id="countries" class="dropdown-menu" role="menu" style=" max-width: 200px; max-height: 200px; overflow-y: scroll; overflow-x: scroll">
									<input type="text" id="myInput" onkeyup="search()" placeholder="Search country.." title="Type in country">
									<li role="menuitem"><a href="{{URL('/country')}}?country_code=all">ALL</a></li>
									@php
										$query_country = " SELECT DISTINCT PAY_CODE, PAY_NOM 
																FROM XN_PAYS        
																ORDER BY PAY_CODE ASC
															";
										$stmt = oci_parse($c, $query_country);
										ociexecute($stmt, OCI_DEFAULT);
										$nrows = ocifetchstatement($stmt, $result_country,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
										
										foreach($result_country as $one_country){
											echo '<li role="menuitem"><a href="'.URL("/country").'?country_code='.$one_country['PAY_CODE'].'&country='.$one_country['PAY_NOM'].'">'.$one_country['PAY_NOM'].'</a></li>';	
										}
									@endphp								
								</ul>
							@else
							
								@php
									$query_country = " SELECT DISTINCT PAY_CODE, PAY_NOM 
															FROM XN_PAYS        
															WHERE PAY_CODE = :country_code
														";
									$stmt = oci_parse($c, $query_country);
									$country_code = session()->get('country_code');
									ocibindbyname($stmt, ":country_code", $country_code);
									ociexecute($stmt, OCI_DEFAULT);
									$nrows = ocifetchstatement($stmt, $result_country,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
									
									foreach($result_country as $one_country){
										session()->put('country_code', $one_country['PAY_CODE']);
										session()->put('country', $one_country['PAY_NOM']);
										echo '<a class="#" data-toggle="dropdown" href="'.URL("/country").'?country_code='.$one_country['PAY_CODE'].'&country='.$one_country['PAY_NOM'].'">'.$one_country['PAY_NOM'].'<i class="fas fa-caret-down"></i></a>';	
									}
								@endphp	
								{{-- <a class="#" data-toggle="dropdown" href="">{{session()->get('country_code')}} <i class="fas fa-caret-down"></i></a> --}}
							@endif
						</div>
						<div class="dropdown choose-country" style="float:right;display:inline;">
							@if (session()->get('position') == 'international')
								@if (session()->get('oc') != "")
									<a class="#" data-toggle="dropdown" href="">{{session()->get('oc')}} <i class="fas fa-caret-down"></i></a>
								@else
									<a class="#" data-toggle="dropdown" href="">SECTION <i class="fas fa-caret-down"></i></a>
								@endif
								<ul class="dropdown-menu" role="menu">
									<li role="menuitem"><a href="{{URL('/oc')}}?oc=all">ALL</a></li>
									<li role="menuitem"><a href="{{URL('/oc')}}?oc=OCB">OCB</a></li>
									<li role="menuitem"><a href="{{URL('/oc')}}?oc=OCBA">OCBA</a></li>
									<li role="menuitem"><a href="{{URL('/oc')}}?oc=OCA">OCA</a></li>
									<li role="menuitem"><a href="{{URL('/oc')}}?oc=OCG">OCG</a></li>
									<li role="menuitem"><a href="{{URL('/oc')}}?oc=OCP">OCP</a></li>								
								</ul>
							@else
								<a class="#" data-toggle="dropdown" href="">{{session()->get('oc')}} <i class="fas fa-caret-down"></i></a>
							@endif
						</div>
						<br><br>
					
						<label>Order status:</label>
						<input type="checkbox" name="draft" id="draft" value="draft" <?php if(isset($_REQUEST['draft']))echo 'checked=""' ?>><span>Draft</span>
						<input type="checkbox" name="confirmed" id="confirmed" value="confirmed" <?php if(isset($_REQUEST['confirmed']))echo 'checked=""' ?>><span>Confirmed</span>
						<input type="checkbox" name="rts" id="rts" value="rts" <?php if(isset($_REQUEST['rts']))echo 'checked=""' ?>><span>RTS</span>
						<input type="checkbox" name="onfreight" id="onfreight" value="onfreight" <?php if(isset($_REQUEST['onfreight']))echo 'checked=""' ?>><span>On Freight</span>
						<input type="checkbox" name="delivered" id="delivered" value="delivered" <?php if(isset($_REQUEST['delivered']))echo 'checked=""' ?>><span>Delivered</span>
						<input type="checkbox" name="cancelled" id="cancelled" value="cancelled" <?php if(isset($_REQUEST['cancelled']))echo 'checked=""' ?>><span>Cancelled</span>
						<br><br>
						<label>Date between:</label>
						<input type="text" name="dateAfter" id="dateAfter" value="<?php echo $_REQUEST['dateAfter'];?>" size="9" maxlength="10"/>
						<span>and</span>
						<input type="text" name="dateBefore" id="dateBefore" value="<?php echo $_REQUEST['dateBefore'];?>" size="9" maxlength="10"/>
						
						<input type="submit" value="Go"/>
					</div>
					
					</form>
			</div>
			<?php
				if (isset($_REQUEST['procode']) ) {
					render_table($result, $fields);
				}		
			?>
		</div>
	</div>
@endsection