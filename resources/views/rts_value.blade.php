@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>RTS Value Report</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$_REQUEST['art'] = (!isset($_REQUEST['art']) || trim($_REQUEST['art']) == ""?'%':$_REQUEST['art']);
				$_REQUEST['var1'] = (!isset($_REQUEST['var1']) || trim($_REQUEST['var1']) == ""?'%':$_REQUEST['var1']);

				$generalparams = array(
					'xlsname'=>'rts_value_report',
				);

				$fields[]=array(
					'sqlfield'=>'PCT_CLI_CODE_DISP',				// champ SQL pur
					'title'=>'Destination',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					// alias
					'sortsqlfield'=>'',
				);

				$fields[]=array(
					'sqlfield'=>'PCL_ART_CODE',				// champ SQL pur
					'title'=>'Article',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'PCL_ART_VAR1',			// champ SQL pur
					'title'=>'Version',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'CASE WHEN ART_DES1 IS NULL THEN MIN(PCL_DES1) ELSE ART_DES1 END',				// champ SQL pur
					'title'=>'Description',				// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'DESCRIPTION',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'SUM(PCL_QTE_LIV)',		// champ SQL pur
					'title'=>'Total Quantity',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'QTE_LIV_TOT',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'SUM(MS_PACK_CLI_LIGNE.PCL_MT_HT_LIGNE)',		// champ SQL pur
					'title'=>'Total Price',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'PCL_MT_HT_LIGNE',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'ROUND(AVG(((MS_PACK_CLI_LIGNE.PCL_MT_HT_LIGNE) / MS_PACK_CLI_LIGNE.PCL_QTE_LIV) / NVL(MS_PACK_CLI_LIGNE.PCL_UNITE_PX_VTE,1)),2)',		// champ SQL pur
					'title'=>'Average unit price',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'MOY_PX_VTE_UNI',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'PCT_DEV_CODE',			// champ SQL pur
					'title'=>'Currency',					// Title for the column
					
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
							FROM MS_PACK_CLI_TETE,
							(SELECT * FROM MS_PACK_CLI_LIGNE UNION ALL SELECT * FROM TR_PACK_CLI_LIGNE_INTER) MS_PACK_CLI_LIGNE,
							MS_PACK_CLI_COLIS,
							XN_ART
							
						WHERE MS_PACK_CLI_TETE.PCT_NO = MS_PACK_CLI_COLIS.PCC_PCT_NO
							AND MS_PACK_CLI_TETE.PCT_DEP_CODE = MS_PACK_CLI_COLIS.PCC_PCT_DEP_CODE
							AND MS_PACK_CLI_TETE.PCT_DEP_SOC_CODE = MS_PACK_CLI_COLIS.PCC_PCT_DEP_SOC_CODE
							
							AND MS_PACK_CLI_COLIS.PCC_PCT_NO = MS_PACK_CLI_LIGNE.PCL_PCT_NO
							AND MS_PACK_CLI_COLIS.PCC_PCT_DEP_CODE = MS_PACK_CLI_LIGNE.PCL_DEP_CODE
							AND MS_PACK_CLI_COLIS.PCC_PCT_DEP_SOC_CODE = MS_PACK_CLI_LIGNE.PCL_DEP_SOC_CODE
							AND MS_PACK_CLI_COLIS.PCC_NO_GROUPAGE = MS_PACK_CLI_LIGNE.PCL_NO_COLIS   

							AND MS_PACK_CLI_TETE.PCT_NO_DOSSIER is null
							
							AND MS_PACK_CLI_LIGNE.PCL_ART_CODE = XN_ART.ART_CODE(+)
							AND MS_PACK_CLI_LIGNE.PCL_ART_VAR1 = XN_ART.ART_VAR1(+)               
							AND MS_PACK_CLI_LIGNE.PCL_ART_VAR2 = XN_ART.ART_VAR2(+)
							AND MS_PACK_CLI_LIGNE.PCL_ART_VAR3 = XN_ART.ART_VAR3(+)
							
							AND MS_PACK_CLI_LIGNE.PCL_QTE_LIV > 0
							
							AND MS_PACK_CLI_LIGNE.PCL_ART_CODE LIKE :art
							AND MS_PACK_CLI_LIGNE.PCL_ART_VAR1 LIKE :var1
							
						";
						
				if(isset($_REQUEST['dispatch']) && trim($_REQUEST['dispatch']) != ""){
					$query .= " AND PCT_CLI_CODE_DISP = :dispatch ";
				}		

				$query .= " 
							GROUP BY MS_PACK_CLI_TETE.PCT_CLI_CODE_DISP,MS_PACK_CLI_TETE.PCT_DEV_CODE,MS_PACK_CLI_LIGNE.PCL_ART_CODE,MS_PACK_CLI_LIGNE.PCL_ART_VAR1,XN_ART.ART_DES1
						";
						
				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = $fields[0]['sqlfield'];
					$_REQUEST['order']="ASC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];
						
				$tab_filter	= array(
					array('name'=>'art','value'=>$_REQUEST['art']),
					array('name'=>'var1','value'=>$_REQUEST['var1']),
					
				);	

				if(isset($_REQUEST['dispatch']) && trim($_REQUEST['dispatch']) != ""){
					array_push($tab_filter,array('name'=>'dispatch','value'=>$_REQUEST['dispatch']));
				}
										
				//echo '<pre>'.print_r($query,true).'</pre>';				
								
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
