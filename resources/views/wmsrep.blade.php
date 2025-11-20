@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>WMS Report</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'wms_report',
					'title'=>'WMS Report'
				);

				$fields[]=array(
					'sqlfield'=>"
					CASE
					WHEN EPD_PICKED = 'YES' THEN '<a target=\"_blank\" href=\"storage/uploads/' || EPD_PICKER || '_' || EPD_PICK || '_picked.xlsx' || '\">' || EPD_PICK || '</a>'
					ELSE '<a target=\"_blank\" href=\"storage/uploads/' || EPD_PICKER || '_' || EPD_PICK || '.xlsx' || '\">' || EPD_PICK || '</a>'
					END",
					'title'=>'Picking no',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'PIKIN',					//alias
					'sortsqlfield'=>'PIKIN',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'EPD_PICKER',				// champ SQL pur
					'title'=>'Picker',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'EPD_PICKED',				// champ SQL pur
					'title'=>'Picked',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'EPD_DATE',				// champ SQL pur
					'title'=>'Pick date',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'EAP_PKNO',				// champ SQL pur
					'title'=>'Packing no',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'EAP_PACKER',				// champ SQL pur
					'title'=>'Packer',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'EAP_PACKED',		// champ SQL pur
					'title'=>'Packed',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'EAP_DATE',				// champ SQL pur
					'title'=>'Pack date',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "
                FROM EXT_PICK_DETAILS@msfss, EXT_AUTO_PACK@msfss
				WHERE SUBSTR(EAP_PKNO(+), 1, LENGTH(EAP_PKNO(+)) - 2) = EPD_PICK ";


				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = 'EPD_PICK';
					$_REQUEST['order']="DESC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

				$tab_filter	= array();

				if(isset($_REQUEST['order_no']) && trim($_REQUEST['order_no']) != ""){
					array_push($tab_filter,array('name'=>'order_no','value'=>trim($_REQUEST['order_no'])));
				}

				//if (isset($_REQUEST['order_no'])) {
					$result = execute_request($c,$query,$tab_filter);

					if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
						render_table_xls($result, $fields, $generalparams);	
						exit();
					}
				//}

			@endphp
			<?php
				//if (isset($_REQUEST['order_no'])) {
					render_table($result, $fields);
				//}
			?>
		</div>
	</div>

@endsection
