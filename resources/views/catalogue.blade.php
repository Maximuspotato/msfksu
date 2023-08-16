@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>All items</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'catalogue',
					'title'=>'Catalogue'
				);

				$fields[]=array(
					'sqlfield'=>'ART_ZZ_MSF_ID',				// champ SQL pur
					'title'=>'MSF ID',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
                    'sqlfield'=>"'<a target=\"_blank\" href=\"https://unicat.msf.org/cat?search=' || ART_CODE || '&order=name+asc\">' || ART_CODE || '</a>'",
					'title'=>'Article',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'ART',					//alias
					'sortsqlfield'=>'ART',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'ART_DES1',				// champ SQL pur
					'title'=>'Description',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                if (!Auth::guest()){
                    $fields[]=array(
                        'sqlfield'=>"CASE
                        WHEN TAC_PX_ACTUEL IS NOT NULL THEN TAC_PX_ACTUEL
                        ELSE (SELECT PRICE FROM (SELECT CCL_ART_CODE,AVG(CCL_PX_VTE_NET) PRICE, CCT_NTC_CODE, MAX(CCL_DT_CREAT)
                        FROM XN_CMDE_CLI_LIGNE, XN_CMDE_CLI_TETE
                        WHERE CCL_TYD_CODE = 'CC'
                        AND CCL_INDEX = 'Z'
                        AND CCL_CCT_NO = CCT_NO
                        AND CCT_NTC_CODE = 'US'
                        AND CCL_ART_CODE = ART_CODE
                        GROUP BY CCL_ART_CODE, CCT_NTC_CODE
                        ORDER BY MAX(CCL_DT_CREAT))WHERE ROWNUM <= 3)
                        END",				// champ SQL pur
                        'title'=>'Price(USD)',					// Title for the column
                        
                        'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                        'decimal'=>'2',
                        
                        'aliasname'=>'PRICE',					//alias
                        'sortsqlfield'=>'PRICE',					//sort	
                    );
                }

                if (!Auth::guest()) {
                    $fields[]=array(
                        'sqlfield'=>"CASE
                        WHEN TAC_PX_ACTUEL IS NOT NULL THEN 'ACTUAL'
                        ELSE 'INDICATIVE/NONE'
                        END",				// champ SQL pur
                        'title'=>'Pricing',					// Title for the column
                        
                        'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                        'decimal'=>'',
                        
                        'aliasname'=>'PRICING',					//alias
                        'sortsqlfield'=>'PRICING',					//sort	
                    );
                }

                $fields[]=array(
					'sqlfield'=>'ART_PDS',				// champ SQL pur
					'title'=>'Weight(kd)',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'1',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'ART_VOL',
					'title'=>'Volume(dm3)',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'1',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'ART_COND_VTE',				// champ SQL pur
					'title'=>'UoM',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>"CASE WHEN CAA_CODE = '0' THEN '' ELSE CAA_LIB END",				// champ SQL pur
					'title'=>'Category',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'DGR',					//alias
					'sortsqlfield'=>'DGR',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'ART_ZZ_ON_LINE_OBS',				// champ SQL pur
					'title'=>'Online order remarks',					// Title for the column
					
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
                FROM XN_ART, XN_TARIF_CLI, XN_CAT_ART
                WHERE ART_ZZ_ON_LINE_AFF_01 = '1'
                AND TAC_ART_CODE(+) = ART_CODE
                AND TAC_NTC_CODE(+) = 'US'
				AND CAA_CODE = ART_CAA_CODE ";


				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = 'ART_CODE';
					$_REQUEST['order']="ASC";
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
			Session::put('articles', $result);
			@endphp
			<a href="{{URL('/ufExport')}}" class="btn btn-secondary">Export Unifield</a>
			<?php
				//if (isset($_REQUEST['order_no'])) {
					render_table($result, $fields);
				//}
			?>
		</div>
	</div>

@endsection
