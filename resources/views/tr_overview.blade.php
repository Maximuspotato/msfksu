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
						'title'=>'Add Date',					// Title for the column
						
						'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
						'decimal'=>'',
					
						'aliasname'=>'BUTTONADD',					//alias
						'sortsqlfield'=>'BUTTONADD',					//sort	
					);
				}

				$fields[]=array(
					'sqlfield'=>'COMMTBL.DTC_COMM',		// champ SQL pur
					'title'=>'Comments',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'COMM',					//alias
					'sortsqlfield'=>'COMM',					//sort	
				);

				if(!isset($_REQUEST['xls']) || $_REQUEST['xls'] <> 'yes'){
					$fields[]=array(
						'sqlfield'=>"'<img src=\"ext/images/add.png\" onclick=\"commForm(''' || DTR_NO || ''')\"/>
						<img src=\"ext/images/edit.png\" onclick=\"fetchComms(''' || DTR_NO || ''')\"/>'",		// champ SQL pur
						'title'=>'Add Comment',					// Title for the column
						
						'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
						'decimal'=>'',
					
						'aliasname'=>'COMMADD',					//alias
						'sortsqlfield'=>'COMMADD',					//sort	
					);
				}

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "
				FROM MS_DOSSIER_TRANSP TR, XN_MODE_TRANSP, XN_CLI, EXT_DOSSIER_TRANSP_RC,
				(SELECT ROWNUM RN, DTC_DTR_NO, DTC_COMM, DTC_DT FROM (SELECT ROWNUM ,DTC_DTR_NO, DTC_COMM, DTC_DT FROM EXT_DOSSIER_TRANSP_COMM ORDER BY DTC_DT DESC)) COMMTBL
				WHERE MTR_CODE = DTR_MTR_CODE
				AND CLI_CODE = DTR_CLI_CODE_DISP
				AND DTRC_DTR_NO(+) = DTR_NO 
				AND COMMTBL.DTC_DTR_NO(+) = DTR_NO
				AND COMMTBL.RN(+) = 1 ";

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

				if(isset($_REQUEST['dateAfter']) && trim($_REQUEST['dateAfter']) != ""){
					$query .= " AND DTR_DT_CREAT_DOS >= TO_DATE(:dateAfter,'DD/MM/YYYY') ";
				}

				if(isset($_REQUEST['dateBefore']) && trim($_REQUEST['dateBefore']) != ""){
					$query .= " AND DTR_DT_CREAT_DOS <= TO_DATE(:dateBefore,'DD/MM/YYYY')+1 ";
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

				if(isset($_REQUEST['dateAfter']) && trim($_REQUEST['dateAfter']) != ""){
					array_push($tab_filter,array('name'=>'dateAfter','value'=>trim($_REQUEST['dateAfter'])));
				}

				if(isset($_REQUEST['dateBefore']) && trim($_REQUEST['dateBefore']) != ""){
					array_push($tab_filter,array('name'=>'dateBefore','value'=>trim($_REQUEST['dateBefore'])));
				}
				//array_push($tab_filter,array('name'=>'indsex','value'=>'sex'));
				//dd($tab_filter);

				//echo '<pre>'.$query.'</pre>';

				$result = execute_request($c,$query,$tab_filter);

				if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
					render_table_xls($result, $fields, $generalparams);	
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
					
					
					
					<label>Start date: </label>
					<input type="text" name="dateAfter" id="dateAfter" placeholder="dd/mm/yyyy" value="<?php if (isset($_REQUEST['dateAfter'])) echo $_REQUEST['dateAfter'];?>" size="9" maxlength="10"/>
					<label> End date: </label>
					<input type="text" name="dateBefore" id="dateBefore" placeholder="dd/mm/yyyy" value="<?php if (isset($_REQUEST['dateBefore'])) echo $_REQUEST['dateBefore'];?>" size="9" maxlength="10"/>
					
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
	<div class="form-popup" id="commForm">
		<div class="div_filter">
			<form id="transForm" class="form-container">
				<h1 id="commHead"></h1>
	
				<textarea name="comm" placeholder="Add comment here..." required></textarea>
	
				<input type="hidden" id="dtr_nos" name="dtr_nos" value="" required>
				<input type="hidden" id="det" name="det" value="det" required>
	
				<button type="submit" class="btn" onclick="save()" >Save</button>
				<button type="button" class="btn cancel" onclick="closeForm()">Close</button>
			</form>
		</div>
	</div>
	<div class="form-popup" id="allComms">
		<div class="div_filter" id="commsDiv" style="overflow-y: scroll">
			<h1 id="allCommsHead"></h1>
		</div>
		<button type="button" class="btn cancel" onclick="closeForm()">Close</button>
	</div>
	<script>
		function openForm(dtr_no){
			document.getElementById("trForm").style.display = "table";
			document.getElementById("trHead").innerHTML = "File no. "+dtr_no;
			document.getElementById("dtr_no").value = dtr_no;
			//console.log("{!! app_path() !!}");
		}
		function commForm(dtr_no){
			document.getElementById("commForm").style.display = "table";
			document.getElementById("commHead").innerHTML = "File no. "+dtr_no;
			document.getElementById("dtr_nos").value = dtr_no;
			//console.log("{!! app_path() !!}");
		}
		function closeForm() {
			document.getElementById("trForm").style.display = "none";
			document.getElementById("commForm").style.display = "none";
			var comClass = document.getElementsByClassName('com');
			if (comClass != null) {
				var length = comClass.length;
				for(var i = 0; i < length; i++) {
					comClass[0].remove();
				}
				document.getElementById("allComms").style.display = "none";
			}
		}
	
		// function closeForm() {
		// 	document.getElementById("trForm").style.display = "none";
		// 	document.getElementById("commForm").style.display = "none";
		// }
	
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
		function delComm(comm2del){
			var http = new XMLHttpRequest();
			http.open("POST", "{{url('/')}}/ext/utils/KSU_trans_ajax.php", true);
			http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			var params = "recieved="+document.getElementById("recieved").value+"&dtr_no="+document.getElementById("dtr_no").value;
			http.send(params);
			// http.onload = function() {
			// 	alert(http.responseText);
			// }
		}
		function fetchComms(dtr_no){
			var http = new XMLHttpRequest();
			http.open("POST", "{{url('/')}}/ext/utils/KSU_trans_ajax.php", true);
			http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			var params = "dtr_no="+dtr_no+"&det=fetch";
			http.send(params);
			http.onload = function() {
				if (http.responseText === "empty\t") {
					alert("No comment available");
				} else {
					var comClass = document.getElementsByClassName('com');
					if (comClass != null) {
						var length = comClass.length;
						for(var i = 0; i < length; i++) {
							comClass[0].remove();
						}
						document.getElementById("allComms").style.display = "none";
					}
					var resp = JSON.parse(http.responseText);
					document.getElementById("allComms").style.display = "table";
					document.getElementById("allCommsHead").innerHTML = "File no. "+dtr_no;
					var counter = 1;
					resp.forEach(comm => {
						//console.log(comm['DTC_COMM']);
						const para = document.createElement("p");
						para.setAttribute("class", "com");
						para.setAttribute("style", "color: white");
						para.innerHTML = counter+". "+comm['DTC_COMM'];

						const pic = document.createElement("img");
						pic.setAttribute("src", "ext/images/delete.gif");
						//pic.setAttribute("onclick", "delComm("+comm['DTC_COMM']+")");

						document.getElementById("commsDiv").appendChild(para);
						document.getElementById("commsDiv").appendChild(pic );
						counter++;
					});
				}
			}
		}
	</script>
@endsection

