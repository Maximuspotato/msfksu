@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Stock Report</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$_REQUEST['art'] = (!isset($_REQUEST['art']) || trim($_REQUEST['art']) == ""?'%':trim($_REQUEST['art']));
				$_REQUEST['var1'] = (!isset($_REQUEST['var1']) || trim($_REQUEST['var1']) == ""?'%':trim($_REQUEST['var1']));
				$_REQUEST['batch'] = (!isset($_REQUEST['batch']) || trim($_REQUEST['batch']) == ""?'%':trim($_REQUEST['batch']));
				$_REQUEST['store'] = (!isset($_REQUEST['store']) || trim($_REQUEST['store']) == ""?'%':trim($_REQUEST['store']));

				$generalparams = array(
					'xlsname'=>'stock_report',
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
					'sqlfield'=>'ART_DES1',				// champ SQL pur
					'title'=>'Description',				// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'SUM(XN_STOCK_EMPLAC.SEM_QTE_STK)',		// champ SQL pur
					'title'=>'Quantity',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'QTY',					//alias
					'sortsqlfield'=>'',					//sort
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
					'sqlfield'=>"SUM(XN_STOCK_EMPLAC.SEM_PX_UNIT*XN_STOCK_EMPLAC.SEM_QTE_STK)/SUM(XN_STOCK_EMPLAC.SEM_QTE_STK)",		// champ SQL pur
					'title'=>'AVG Unit price (KES)',					// Title for the column
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'PXUNIT',					//alias
					'sortsqlfield'=>"",					//sort	
				);

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "				 
					FROM XN_STOCK_EMPLAC,XN_ART
						WHERE XN_STOCK_EMPLAC.SEM_ART_CODE = XN_ART.ART_CODE
							AND XN_STOCK_EMPLAC.SEM_ART_VAR1 = XN_ART.ART_VAR1            
							AND XN_STOCK_EMPLAC.SEM_ART_VAR2 = XN_ART.ART_VAR2
							AND XN_STOCK_EMPLAC.SEM_ART_VAR3 = XN_ART.ART_VAR3
							
							AND XN_STOCK_EMPLAC.SEM_ART_CODE LIKE :art
							AND XN_STOCK_EMPLAC.SEM_ART_VAR1 LIKE :var1
						";	
						
					if(isset($_REQUEST['store']) && trim($_REQUEST['store']) != "%"){
						$query .= " AND XN_STOCK_EMPLAC.SEM_DEP_CODE_STK LIKE :store ";
					}	
					
					if(isset($_REQUEST['batch']) && trim($_REQUEST['batch']) != "%"){
						$query .= " AND XN_STOCK_EMPLAC.SEM_NO_SERIE_LOT LIKE :batch ";
					}	
					
					if(isset($_REQUEST['expAfter']) && trim($_REQUEST['expAfter']) != ""){
						$query .= " AND XN_STOCK_EMPLAC.SEM_DT_PEREMPTION >= TO_DATE(:expAfter,'DD/MM/YYYY') ";
					}
					
					if(isset($_REQUEST['expBefore']) && trim($_REQUEST['expBefore']) != ""){
						$query .= " AND XN_STOCK_EMPLAC.SEM_DT_PEREMPTION <= TO_DATE(:expBefore,'DD/MM/YYYY') ";
					}
					
				$query .= "
					GROUP BY XN_STOCK_EMPLAC.SEM_DEP_CODE_STK,
									XN_STOCK_EMPLAC.SEM_ART_CODE,
									XN_STOCK_EMPLAC.SEM_ART_VAR1,
									XN_ART.ART_DES1,
									XN_STOCK_EMPLAC.SEM_NO_SERIE_LOT,
									XN_STOCK_EMPLAC.SEM_DT_PEREMPTION
									
					HAVING SUM(XN_STOCK_EMPLAC.SEM_QTE_STK) > 0					
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

				if(isset($_REQUEST['batch']) && trim($_REQUEST['batch']) != "%"){
					array_push($tab_filter,array('name'=>'batch','value'=>$_REQUEST['batch']));
				}

				if(isset($_REQUEST['store']) && trim($_REQUEST['store']) != "%"){
					array_push($tab_filter,array('name'=>'store','value'=>$_REQUEST['store']));
				}

				if(isset($_REQUEST['expAfter']) && trim($_REQUEST['expAfter']) != ""){
					array_push($tab_filter,array('name'=>'expAfter','value'=>trim($_REQUEST['expAfter'])));
				}

				if(isset($_REQUEST['expBefore']) && trim($_REQUEST['expBefore']) != ""){
					array_push($tab_filter,array('name'=>'expBefore','value'=>trim($_REQUEST['expBefore'])));
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
