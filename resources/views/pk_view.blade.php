@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Packing View</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');
				$generalparams = array(
					'xlsname'=>'packing_view',
					'title'=>'Packing View'
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
					'sqlfield'=>'PCL_ART_VAR1',				// champ SQL pur
					'title'=>'Version',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCL_DES1',				// champ SQL pur
					'title'=>'Description',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCL_NO_SERIE_LOT',				// champ SQL pur
					'title'=>'Batch no',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCL_DT_PEREMPTION',				// champ SQL pur
					'title'=>'Expiry',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'PCL_QTE_LIV',				// champ SQL pur
					'title'=>'Quantity',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'PCC_NO_GROUPAGE',				// champ SQL pur
					'title'=>'From parcel',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'PCC_NO_COLIS_FIN',				// champ SQL pur
					'title'=>'To parcel',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'PCL_PDS',				// champ SQL pur
					'title'=>'Weight',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'PCL_VOL',				// champ SQL pur
					'title'=>'Volume',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$c = db_connect();

				$query = "SELECT ";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "
                FROM MS_PACK_CLI_LIGNE, MS_PACK_CLI_COLIS, MS_PACK_CLI_TETE, XN_CLI
                WHERE PCC_PCT_NO = PCL_PCT_NO
                AND PCC_NO_REGROUPEMENT = PCL_NO_COLIS
                AND PCT_NO = PCL_PCT_NO
                AND CLI_CODE = PCT_CLI_CODE_LIV ";

				if(isset($_REQUEST['pk'])){
					$query .= " AND PCL_PCT_NO = :pk ";
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

				if(isset($_REQUEST['pk']) && trim($_REQUEST['pk']) != ""){
					array_push($tab_filter,array('name'=>'pk','value'=>trim($_REQUEST['pk'])));
				}

				//echo '<pre>'.$query.'</pre>';
				if (isset($_REQUEST['pk'])) {
					$result = execute_request($c,$query,$tab_filter);
				}

				if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
                    render_table_xls($result, $fields, $generalparams);	
                    exit();
                }
			@endphp
			<div class="container" id="grille-param">
				<form method="GET" action="{{URL('/')}}/packing-view" autocomplete="off">
					<div class="div_filter">
					
						<label>Packing:</label>
						<input type="text" name="pk" id="pk" value="<?php if (isset($_REQUEST['pk'])) echo $_REQUEST['pk'];?>" required><br><br>
					
						<input type="submit" value="Go"/><br><br>
					</div>
				</form>
                <div class="div_filter">
                    <?php
                        if (isset($_REQUEST['pk'])) {
                            echo '<label>Mission ref: </label>';
                            $query_pk = " SELECT PCT_OBS2, PCT_CCT_NO, PCT_NB_COLIS, PCT_TOT_PDS, PCT_TOT_VOL, PCT_NO_FACTURE FROM MS_PACK_CLI_TETE, XN_CLI WHERE PCT_NO = :pk AND CLI_CODE = PCT_CLI_CODE_LIV ";
                            if (session()->get('oc') != "") {
								$query_pk .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
							}

							if (session()->get('country') != "") {
								$query_pk .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
							}
                            $stmt = oci_parse($c, $query_pk);
                            ocibindbyname($stmt, ":pk", $_REQUEST['pk']);
                            ociexecute($stmt, OCI_DEFAULT);
                            $nrows = ocifetchstatement($stmt, $result_pk,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
                            
                            foreach($result_pk as $one_pk){
                                echo ' '.$one_pk['PCT_OBS2'];
                                echo '<br>';
                            }

                            echo '<label>Order no: </label>';
                            foreach($result_pk as $one_pk){
                                echo ' '.$one_pk['PCT_CCT_NO'];
                                echo '<br>';
                            }

                            echo '<label>Nb parcel: </label>';
                            foreach($result_pk as $one_pk){
                                echo ' '.$one_pk['PCT_NB_COLIS'];
                                echo '<br>';
                            }

                            echo '<label>Total weight: </label>';
                            foreach($result_pk as $one_pk){
                                echo ' '.$one_pk['PCT_TOT_PDS'].' kg';
                                echo '<br>';
                            }

                            echo '<label>Total vol: </label>';
                            foreach($result_pk as $one_pk){
                                echo ' '.$one_pk['PCT_TOT_VOL'].' dm<sup>3</sup>';
                                echo '<br>';
                            }

                            echo '<label>Goods inv: </label>';
                            foreach($result_pk as $one_pk){
                                echo ' '.$one_pk['PCT_NO_FACTURE'];
                                echo '<br>';
                            }
                        }
					?>
                </div>
			</div>
            @php
				if (isset($_REQUEST['pk'])) {
					render_table($result, $fields);
				}
			@endphp
		</div>
	</div>

@endsection
