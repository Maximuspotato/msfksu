@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Order View</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'order_view',
					'title'=>'Order View'
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
					'sqlfield'=>'CCL_ART_CODE',				// champ SQL pur
					'title'=>'Article',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_ART_VAR1',				// champ SQL pur
					'title'=>'Verion',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_DES1',				// champ SQL pur
					'title'=>'Description',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'CCL_QTE_CMDE',				// champ SQL pur
					'title'=>'Order qty',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'CCL_QTE_LIV',				// champ SQL pur
					'title'=>'Delivered qty',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"packing-view?pk=' || PCT_NO || '\">' || PCT_NO || '</a>'",
					'title'=>'packing',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'PK',					//alias
					'sortsqlfield'=>'PK',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'CCL_QTE_RESTE',				// champ SQL pur
					'title'=>'Remaining qty',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
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
					'sqlfield'=>"'<a target=\"_blank\" href=\"freight-view?cm=' || PCT_NO_DOSSIER || '\">' || PCT_NO_DOSSIER || '</a>'",
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
                FROM XN_CMDE_CLI_TETE, XN_CMDE_CLI_LIGNE, MS_PACK_CLI_TETE, MS_PACK_CLI_LIGNE, XN_CLI
				WHERE CCT_NO(+) = CCL_CCT_NO
				AND PCT_NO(+) = PCL_PCT_NO
				AND CCT_NO = PCT_CCT_NO(+)
				AND CCL_CCT_NO = PCL_CCT_NO(+)
				AND CCL_ART_CODE = PCL_ART_CODE(+)
				AND CLI_CODE = CCT_CLI_CODE_LIVRE ";

				if(isset($_REQUEST['order_no'])){
					$query .= " AND CCT_NO = :order_no ";
				}

				if (session()->get('oc') != "") {
					$query .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
				}

				if (session()->get('country') != "") {
					$query .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
				}

				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = 'CCT_NO';
					$_REQUEST['order']="DESC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

				$tab_filter	= array();

				if(isset($_REQUEST['order_no']) && trim($_REQUEST['order_no']) != ""){
					array_push($tab_filter,array('name'=>'order_no','value'=>trim($_REQUEST['order_no'])));
				}

				if (isset($_REQUEST['order_no'])) {
					$result = execute_request($c,$query,$tab_filter);

					if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
						render_table_xls($result, $fields, $generalparams);	
						exit();
					}
				}

			@endphp
			<div class="container" id="grille-param">
				<form method="GET" action="{{URL('/')}}/order-view" autocomplete="off">
					<div class="div_filter">
					
						<label>Order:</label>
						<input type="text" name="order_no" id="order_no" value="<?php if (isset($_REQUEST['order_no'])) echo $_REQUEST['order_no'];?>" required><br><br>
					
						<input type="submit" value="Go"/><br><br>
					</div>
				</form>

			</div>
			<?php
				if (isset($_REQUEST['order_no'])) {
					render_table($result, $fields);
				}
			?>
		</div>
	</div>

@endsection
