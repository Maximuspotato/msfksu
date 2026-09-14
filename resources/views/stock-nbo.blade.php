@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Stock NBO</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'stock_nbo',
					'title'=>'Stock NBO'
				);

				$fields[]=array(
	'sqlfield'=>'SEM_NO_SEQ',				// champ SQL pur
	'title'=>'Id Place',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					// alias
	'sortsqlfield'=>'',
);

$fields[]=array(
	'sqlfield'=>'SEM_BFT_NO_BL',				// champ SQL pur
	'title'=>'RC number',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					// alias
	'sortsqlfield'=>'',
);

$fields[]=array(
	'sqlfield'=>'SEM_DEP_CODE_STK',				// champ SQL pur
	'title'=>'Store',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					// alias
	'sortsqlfield'=>'',
);

$fields[]=array(
	'sqlfield'=>'SEM_ART_CODE',				// champ SQL pur
	'title'=>'Article',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort
);

$fields[]=array(
	'sqlfield'=>'SEM_ART_VAR1',			// champ SQL pur
	'title'=>'Version',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort
);

$fields[]=array(
	'sqlfield'=>'ARL_DES1',				// champ SQL pur
	'title'=>'Description',				// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort
);

$fields[]=array(
	'sqlfield'=>'SEM_MAG_CODE',				// champ SQL pur
	'title'=>'Aisle',				// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort
);

$fields[]=array(
	'sqlfield'=>'SEM_ALLEE',				// champ SQL pur
	'title'=>'Rack',				// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort
);

$fields[]=array(
	'sqlfield'=>"CASE WHEN LENGTH(TO_CHAR(SEM_RANG)) = 1 THEN ('0' || TO_CHAR(SEM_RANG))
ELSE TO_CHAR(SEM_RANG)
END",				// champ SQL pur
	'title'=>'Level',				// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'LVL',					//alias
	'sortsqlfield'=>'LVL',					//sort
);

$fields[]=array(
	'sqlfield'=>'SEM_NIVEAU',				// champ SQL pur
	'title'=>'Stack',				// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort
);

// if(!isset($_REQUEST['xls']) || $_REQUEST['xls'] <> 'yes'){
// 	$fields[]=array(
// 		'sqlfield'=>"'<img src=\"/images/add.png\" onclick=\"openForm(''' || SEM_MAG_CODE || ''', ''' || SEM_ALLEE || ''', ''' || SEM_RANG || ''', ''' || SEM_NIVEAU || ''', ''' || SEM_NO_SEQ || ''', ''' || SEM_BFT_NO_BL || ''')\"/>'",		// champ SQL pur
// 		'title'=>'',					// Title for the column
		
// 		'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
// 		'decimal'=>'',
	
// 		'aliasname'=>'BUTTONADD',					//alias
// 		'sortsqlfield'=>'BUTTONADD',					//sort	
// 	);
// }

$fields[]=array(
	'sqlfield'=>'TO_CHAR(SEM_QTE_STK)',		// champ SQL pur
	'title'=>'Quantity',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'QTY',					//alias
	'sortsqlfield'=>'QTY',					//sort
);

$fields[]=array(
	'sqlfield'=>'TO_CHAR(SEM_QTE_RESERV)',		// champ SQL pur
	'title'=>'Quantity Not Available',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'QTYR',					//alias
	'sortsqlfield'=>'QTYR',					//sort
);

$fields[]=array(
	'sqlfield'=>"CASE
WHEN BFT_ZZ_CONFIRME_01 = 0 THEN TO_CHAR(SEM_QTE_STK-SEM_QTE_RESERV)
WHEN SEM_BFT_NO_BL IS NULL THEN TO_CHAR(SEM_QTE_STK-SEM_QTE_RESERV)
ELSE '0'
END",
	'title'=>'Quantity Available',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'QTYA',					//alias
	'sortsqlfield'=>'QTYA',					//sort
);

$fields[]=array(
	'sqlfield'=>'SEM_NO_SERIE_LOT',		// champ SQL pur
	'title'=>'Batch/Series',					// Title for the column
	
	'format'=>'string',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',

	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort	
);

$fields[]=array(
	'sqlfield'=>"TO_CHAR(SEM_DT_PEREMPTION,'DD/MM/YYYY')",		// champ SQL pur
	'title'=>'Expiry',					// Title for the column
	
	'format'=>'date',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',

	'aliasname'=>'DTPEREMP',					//alias
	'sortsqlfield'=>"TO_DATE(DTPEREMP,'DD/MM/YYYY')",					//sort	
);

$fields[]=array(
	'sqlfield'=>'SEM_PX_UNIT*SEM_QTE_STK',		// champ SQL pur
	'title'=>'Value(EUR)',					// Title for the column
	
	'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'2',

	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort	
);

				$c = db_connect_msfs();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "				 
FROM XN_STOCK_EMPLAC, XN_ART, XN_ART_LANGUE, XN_BL_FOUR_TETE
WHERE SEM_QTE_STK > 0
AND ART_CODE(+) = SEM_ART_CODE
AND SEM_BLOQUE <> 'T'
AND SEM_DEP_CODE_STK = 'NBO'
AND SEM_ART_CODE = ARL_ART_CODE
AND SEM_ART_VAR1 = ARL_ART_VAR1
AND (ARL_LAN_CODE='E' OR ARL_LAN_CODE IS NULL)
AND BFT_NO_BL(+) = SEM_BFT_NO_BL
AND SEM_BLOQUE <> 'S'
AND ((SEM_BFT_NO_BL IS NULL)
OR(BFT_ZZ_CONFIRME_01 IN (0)))
		";	

		$query .= "GROUP BY SEM_NO_SEQ, SEM_BFT_NO_BL, SEM_DEP_CODE_STK, SEM_ART_CODE, SEM_ART_VAR1, ARL_DES1, SEM_MAG_CODE, SEM_ALLEE, SEM_RANG, SEM_NIVEAU, SEM_QTE_STK, SEM_NO_SERIE_LOT, SEM_DT_PEREMPTION, SEM_PX_UNIT, SEM_QTE_STK, SEM_QTE_RESERV, BFT_INDEX, BFT_ZZ_CONFIRME_01";

if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = 'SEM_NO_SEQ';
					$_REQUEST['order']="DESC";
				}
				

$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

$tab_filter	= array();

					$result = execute_request($c,$query,$tab_filter);

					if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
						render_table_xls($result, $fields, $generalparams);	
						exit();
					}

			@endphp
		
			<?php
					render_table($result, $fields);
			?>
		</div>
	</div>

@endsection
