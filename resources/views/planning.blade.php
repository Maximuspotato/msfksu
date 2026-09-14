@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>planning</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'planning',
					'title'=>'Planning'
				);

				$fields[]=array(
	'sqlfield'=>'PFB_CCL_CCT_NO',				// champ SQL pur
	'title'=>'DOC no',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort	
);

$fields[]=array(
	'sqlfield'=>'CCT_CLI_CODE_DISP',				// champ SQL pur
	'title'=>'Dispatch',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort	
);

$fields[]=array(
	'sqlfield'=>'CCL_ART_CODE',				// champ SQL pur
	'title'=>'Article',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort	
);

$fields[]=array(
	'sqlfield'=>'PFB_QTE_PLANIF',				// champ SQL pur
	'title'=>'Quantity',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort	
);

$fields[]=array(
	'sqlfield'=>"COALESCE(SUM(SEM_QTE_STK),0)",				// champ SQL pur
	'title'=>'Available',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'',
	
	'aliasname'=>'AV',					//alias
	'sortsqlfield'=>'AV',					//sort	
);

$fields[]=array(
	'sqlfield'=>'CCT_DT_FERM',		// champ SQL pur
	'title'=>'RTS date',					// Title for the column
	
	'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
	'decimal'=>'0',

	'aliasname'=>'',					//alias
	'sortsqlfield'=>'',					//sort	
);

$fields[]=array(
	'sqlfield'=>'CCT_DT_AR',		// champ SQL pur
	'title'=>'CDD',					// Title for the column
	
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
FROM TR_PLANIF_FAB@msfss, XN_CMDE_CLI_TETE@msfss, XN_CMDE_CLI_LIGNE@msfss, XN_STOCK_EMPLAC@msfss
--, XN_BL_FOUR_TETE
WHERE PFB_DEP_CODE = 'NBO'
AND PFB_INDEX = '0'
AND CCT_NO = PFB_CCL_CCT_NO
AND CCL_CCT_NO = CCT_NO
AND CCL_CCT_NO = PFB_CCL_CCT_NO
AND PFB_CCL_NO_LIGNE = CCL_NO_LIGNE
AND SEM_ART_CODE(+) = CCL_ART_CODE 
--AND SEM_QTE_STK > 0 
AND SEM_BLOQUE(+) <> 'T' 
AND SEM_BLOQUE(+) <> 'S' 
AND SEM_DEP_CODE_STK(+) = 'NBO' 
--AND (SEM_BFT_NO_BL IS NULL OR BFT_ZZ_CONFIRME_01 IN (0))
--AND PFB_ZZ_DIFF_AC IS NOT NULL
--AND BFT_NO_BL = SEM_BFT_NO_BL
GROUP BY PFB_CCL_CCT_NO, CCT_CLI_CODE_DISP, CCL_ART_CODE, PFB_QTE_PLANIF, CCT_DT_FERM, CCT_DT_AR
--ORDER BY PFB_CCL_CCT_NO DESC ";

if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = 'PFB_CCL_CCT_NO';
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
