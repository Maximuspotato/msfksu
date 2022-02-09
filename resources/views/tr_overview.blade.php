@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Transport Overview</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'tr_overview',
					'title'=>'TR Overview'
				);

				if( !isset($_REQUEST['indx'])
					){
					$_REQUEST['indx'] = 'Z';

				}

				$fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"freight-view?cm=' || DTR_NO || '\">' || DTR_NO || '</a>'",
					'title'=>'File',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'DTR',					//alias
					'sortsqlfield'=>'DTR',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'MTR_LIB',				// champ SQL pur
					'title'=>'Mode',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CLI_NOM',				// champ SQL pur
					'title'=>'Client',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CLI_CODE',				// champ SQL pur
					'title'=>'Dispatch',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'DTR_NB_COLIS_EFFECT',				// champ SQL pur
					'title'=>'Parcels',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'DTR_PDS_EFFECT',		// champ SQL pur
					'title'=>'Weight (Kgs)',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"DTR_VOL_EFFECT",		// champ SQL pur
					'title'=>'Volume (M3)',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"DTR_VAL_MARCHANDE",		// champ SQL pur
					'title'=>'Goods Cost (Ksh)',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	CCL_QTE_RESTE
				);

				$fields[]=array(
					'sqlfield'=>"
					CASE
					WHEN DTR_INDEX = 'S' THEN 'CREATED'
					WHEN DTR_INDEX = 'P' THEN 'DISPATCHED'
					WHEN DTR_INDEX = 'Z' THEN 'CLOSED'
					WHEN DTR_INDEX = 'R' THEN 'PREPARE'
					END
					",		// champ SQL pur
					'title'=>'Status',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'STATUS',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'DTR_ZZ_DT_ETA',		// champ SQL pur
					'title'=>'ETA',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'DTR_ZZ_DT_ETD',		// champ SQL pur
					'title'=>'ETD',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
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

				if(!isset($_REQUEST['xls']) || $_REQUEST['xls'] <> 'yes'){
					$fields[]=array(
						'sqlfield'=>"'<img src=\"ext/images/add.png\" onclick=\"openForm(''' || DTR_NO || ''')\"/>'",		// champ SQL pur
						'title'=>'',					// Title for the column
						
						'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
						'decimal'=>'',
					
						'aliasname'=>'BUTTONADD',					//alias
						'sortsqlfield'=>'BUTTONADD',					//sort	
					);
				}

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "
				FROM MS_DOSSIER_TRANSP, XN_MODE_TRANSP, XN_CLI, EXT_DOSSIER_TRANSP_RC
				WHERE MTR_CODE = DTR_MTR_CODE
				AND CLI_CODE = DTR_CLI_CODE_DISP
				AND DTRC_DTR_NO(+) = DTR_NO ";

				if(isset($_REQUEST['country']) && trim($_REQUEST['country']) != ""){
					if ($_REQUEST['country'] == 'KE') {
						$query .= " AND cli_pay_code = 'KE' ";
					}
					elseif ($_REQUEST['country'] == 'RG') {
						$query .= " AND cli_pay_code <> 'KE' ";
					}
				}


				if(isset($_REQUEST['indx']) && trim($_REQUEST['indx']) != ""){
					$query .= " AND DTR_INDEX <> :indx ";
				}

				if (session()->get('oc') != "") {
					$query .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
				}

				if (session()->get('country') != "") {
					$query .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
				}

				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = $fields[0]['sqlfield'];
					$_REQUEST['order']="DESC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

				$tab_filter	= array();

				if(isset($_REQUEST['indx']) && trim($_REQUEST['indx']) != ""){
					array_push($tab_filter,array('name'=>'indx','value'=>trim($_REQUEST['indx'])));
				}
				//array_push($tab_filter,array('name'=>'indsex','value'=>'sex'));
				//dd($tab_filter);

				//echo '<pre>'.$query.'</pre>';

				$result = execute_request($c,$query,$tab_filter);

				if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
					render_table_xls($result);	
					exit();
				}
			@endphp
			<div class="container" >
				<form method="GET" id="grille-param" action="{{URL('/')}}/tr-overview" autocomplete="off">
					<div class="div_filter">
					<label>File status:</label>
					<input type="checkbox" name="indx" id="indx" <?php if(!isset($_REQUEST['indx']))echo 'value="W"' ?> 
					<?php if(isset($_REQUEST['indx']))echo 'value=""' ?> 
					<?php if($_REQUEST['indx'] == '')echo 'checked=""' ?>><span>Z</span><br><br>
					
					<label>Country selection:</label>
					<select name="country">
							<option></option>
							<option value="KE" <?php if (isset($_REQUEST['country']) && $_REQUEST['country'] == "KE") echo "selected=selected"; ?>>Kenya</option>
							<option value="RG" <?php if (isset($_REQUEST['country']) && $_REQUEST['country'] == "RG") echo "selected=selected"; ?>>Region</option>
						</select><br><br>
					
					<input type="submit" value="Go"/>
					</div>
					</form>
					
					<?php
							render_table($result, $fields);
					?>
			</div>
		</div>
	</div>
	<div class="form-popup" id="trForm">
		<div class="div_filter">
			<form id="transForm" class="form-container">
				<h1 id="trHead"></h1>
	
				<label for="recieved"><b>Recieved</b></label>
				<input type="date" id="recieved" name="recieved">
	
				<input type="hidden" id="dtr_no" name="dtr_no" value="" required>
	
				<button type="submit" class="btn" onclick="save()" >Save</button>
				<button type="button" class="btn cancel" onclick="closeForm()">Close</button>
			</form>
		</div>
	</div>
	<script>
		function openForm(dtr_no){
			document.getElementById("trForm").style.display = "table";
			document.getElementById("trHead").innerHTML = "File no. "+dtr_no;
			document.getElementById("dtr_no").value = dtr_no;
			//console.log("{!! app_path() !!}");
		}
	
		function closeForm() {
			document.getElementById("trForm").style.display = "none";
		}
	
		function save(){
			var http = new XMLHttpRequest();
			http.open("POST", "{{url('/')}}/ext/utils/KSU_trans_ajax.php", true);
			http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			var params = "recieved="+document.getElementById("recieved").value+"&dtr_no="+document.getElementById("dtr_no").value;
			http.send(params);
			// http.onload = function() {
			// 	alert(http.responseText);
			// }
		}
	</script>
@endsection

