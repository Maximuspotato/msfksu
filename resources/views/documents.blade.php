@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Search Documents</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'docs',
					'title'=>'Search Documents'
				);

				$fields[]=array(
					'sqlfield'=>'CCT_REF_CMDE_CLI1',				// champ SQL pur
					'title'=>'Mission ref',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"CASE WHEN CCT_NO IS NOT NULL THEN '<a target=\"_blank\" href=\"order-view?order_no=' || CCT_NO || '\">' || CCT_NO || '</a>
					<a target=\"_blank\" href=\"http://10.210.168.40:9002/reports/rwservlet?report=trvc324r&P_CCT_NO_DEB=' || CCT_NO || '&P_CCT_NO_FIN= '|| CCT_NO || '&userid=msf/msf@nodhos&destype=cache&server=rep_nodhosksu&paramform=no&desformat=pdf\"> <img src=\"ext/images/pdf.png\"/> </a>' END",
					'title'=>'KSU ref',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'OP',					//alias
					'sortsqlfield'=>'OP',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>"CASE WHEN PCT_NO IS NOT NULL THEN '<a target=\"_blank\" href=\"packing-view?pk=' || PCT_NO || '\">' || PCT_NO || '</a>
					<a target=\"_blank\" href=\"http://10.210.168.40:9002/reports/rwservlet?report=trvl553r&P_PCT_NO_DEB=' || PCT_NO || '&P_PCT_NO_FIN= '|| PCT_NO || '&userid=msf/msf@nodhos&destype=cache&server=rep_nodhosksu&paramform=no&desformat=pdf\"> <img src=\"ext/images/pdf.png\"/> </a>' END",
					'title'=>'packing',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'PK',					//alias
					'sortsqlfield'=>'PK',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>"CASE WHEN PCT_NO_FACTURE IS NOT NULL THEN ' '|| PCT_NO_FACTURE ||'
					<a target=\"_blank\" href=\"http://10.210.168.40:9002/reports/rwservlet?report=/u02/app/nodhos/msfsup/rdf/trvf531r&P_DEP_CODE=NBO&P_DEP_SOC_CODE=KSU&P_FCT_NO_DEB=' || PCT_NO_FACTURE || '&P_FCT_NO_FIN= '|| PCT_NO_FACTURE || '&userid=msf/msf@nodhos&destype=cache&server=rep_nodhosksu&paramform=no&desformat=pdf\"> <img src=\"ext/images/pdf.png\"/> </a>' END",				// champ SQL pur
					'title'=>'Goods inv',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'INV',					//alias
					'sortsqlfield'=>'INV',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>"CASE WHEN DTR_NO IS NOT NULL THEN '<a target=\"_blank\" href=\"freight-view?cm=' || DTR_NO || '\">' || DTR_NO || '</a>
					<a target=\"_blank\" href=\"http://10.210.168.40:9002/reports/rwservlet?report=trtr202r&P_DTR_NO=' || DTR_NO || '&userid=msf/msf@nodhos&destype=cache&server=rep_nodhosksu&paramform=no&desformat=pdf\"> <img src=\"ext/images/pdf.png\"/> </a>' END",
					'title'=>'Tr no',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'CM',					//alias
					'sortsqlfield'=>'CM',					//sort	
				);

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "
                FROM XN_CMDE_CLI_TETE, MS_PACK_CLI_TETE, XN_CLI, MS_DOSSIER_TRANSP
				WHERE CCT_NO = PCT_CCT_NO(+)
				AND DTR_NO(+) = PCT_NO_DOSSIER
				AND CLI_CODE(+) = CCT_CLI_CODE_LIVRE ";

				if(isset($_REQUEST['ref_no']) && trim($_REQUEST['ref_no']) != ""){
					$query .= " AND CCT_REF_CMDE_CLI1 LIKE '%' || :ref_no || '%' ";
				}

				if(isset($_REQUEST['order_no']) && trim($_REQUEST['order_no']) != ""){
					$query .= " AND CCT_NO = :order_no ";
				}

				if(isset($_REQUEST['pk_no']) && trim($_REQUEST['pk_no']) != ""){
					$query .= " AND PCT_NO = :pk_no ";
				}

				if(isset($_REQUEST['inv_no']) && trim($_REQUEST['inv_no']) != ""){
					$query .= " AND PCT_NO_FACTURE = :inv_no ";
				}

				if(isset($_REQUEST['tr_no']) && trim($_REQUEST['tr_no']) != ""){
					$query .= " AND DTR_NO = :tr_no ";
				}

				if (session()->get('oc') != "") {
					$query .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
				}

				if (session()->get('country') != "") {
					$query .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
				}

				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = 'PCT_NO';
					$_REQUEST['order']="DESC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

				//dd($query);

				$tab_filter	= array();

				if(isset($_REQUEST['ref_no']) && trim($_REQUEST['ref_no']) != ""){
					array_push($tab_filter,array('name'=>'ref_no','value'=>trim($_REQUEST['ref_no'])));
				}

				if(isset($_REQUEST['order_no']) && trim($_REQUEST['order_no']) != ""){
					array_push($tab_filter,array('name'=>'order_no','value'=>trim($_REQUEST['order_no'])));
				}

				if(isset($_REQUEST['pk_no']) && trim($_REQUEST['pk_no']) != ""){
					array_push($tab_filter,array('name'=>'pk_no','value'=>trim($_REQUEST['pk_no'])));
				}

				if(isset($_REQUEST['inv_no']) && trim($_REQUEST['inv_no']) != ""){
					array_push($tab_filter,array('name'=>'inv_no','value'=>trim($_REQUEST['inv_no'])));
				}

				if(isset($_REQUEST['tr_no']) && trim($_REQUEST['tr_no']) != ""){
					array_push($tab_filter,array('name'=>'tr_no','value'=>trim($_REQUEST['tr_no'])));
				}

				if (isset($_REQUEST['ref_no']) || isset($_REQUEST['order_no']) || isset($_REQUEST['pk_no']) || isset($_REQUEST['inv_no']) || isset($_REQUEST['tr_no'])) {
					$result = execute_request($c,$query,$tab_filter);

					// if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
					// 	render_table_xls($result, $fields, $generalparams);	
					// 	exit();
					// }
				}

			@endphp
			<div class="container" id="grille-param">
				<form method="GET" action="{{URL('/')}}/documents" autocomplete="off">
					<div class="div_filter">

						<label>Mission ref:</label>
						<input type="text" name="ref_no" id="ref_no" value="<?php if (isset($_REQUEST['ref_no'])) echo $_REQUEST['ref_no'];?>"><br><br>
					
						<label>KSU ref:</label>
						<input type="text" name="order_no" id="order_no" value="<?php if (isset($_REQUEST['order_no'])) echo $_REQUEST['order_no'];?>"><br><br>

						<label>Packing:</label>
						<input type="text" name="pk_no" id="pk_no" value="<?php if (isset($_REQUEST['pk_no'])) echo $_REQUEST['pk_no'];?>"><br><br>

						<label>Invoice:</label>
						<input type="text" name="inv_no" id="inv_no" value="<?php if (isset($_REQUEST['inv_no'])) echo $_REQUEST['inv_no'];?>"><br><br>

						<label>Tr no:</label>
						<input type="text" name="tr_no" id="tr_no" value="<?php if (isset($_REQUEST['tr_no'])) echo $_REQUEST['tr_no'];?>"><br><br>
					
						<input type="submit" value="Go"/><br><br>

						<p>Use only one field to search otherwise it will not work!!!</p>
					</div>
				</form>

			</div>
			<?php
				if (isset($_REQUEST['ref_no']) || isset($_REQUEST['order_no']) || isset($_REQUEST['pk_no']) || isset($_REQUEST['inv_no']) || isset($_REQUEST['tr_no'])) {
					render_table($result, $fields);
				}
			?>
		</div>
	</div>

@endsection
