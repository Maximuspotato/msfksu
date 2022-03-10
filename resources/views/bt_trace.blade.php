@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Batch Traceability</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'batch_traceability',
					'title'=>'Batch Traceability'
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
					'title'=>'Batch',					// Title for the column
					
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
					'sqlfield'=>'PCT_NO',				// champ SQL pur
					'title'=>'RC No',					// Title for the column
					
					'format'=>'Packing',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_CLI_CODE_LIV',				// champ SQL pur
					'title'=>'client',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_CLI_CODE_DISP',				// champ SQL pur
					'title'=>'Dispatch',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'DTR_ZZ_DT_ETD',				// champ SQL pur
					'title'=>'Shipped Date',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCL_QTE_LIV',				// champ SQL pur
					'title'=>'Quantity',					// Title for the column
					
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
				FROM MS_PACK_CLI_TETE, MS_PACK_CLI_LIGNE, MS_DOSSIER_TRANSP
				WHERE PCL_PCT_NO = PCT_NO
				AND DTR_NO(+) = PCT_NO_DOSSIER
				AND DTR_INDEX(+) IN('P','Z') ";

				if(isset($_REQUEST['art'])){
					$query .= " AND PCL_ART_CODE = :art ";
				}

				$query .= " UNION

				SELECT  PCI_ART_CODE, PCI_ART_VAR1, PCI_DES1, PCI_NO_SERIE_LOT, PCI_DT_PEREMPTION, PCT_NO,PCT_CLI_CODE_LIV, PCT_CLI_CODE_DISP, DTR_ZZ_DT_ETD,
				PCI_QTE_LIV
				FROM MS_PACK_CLI_TETE, TR_PACK_CLI_LIGNE_INTER, MS_DOSSIER_TRANSP
				WHERE PCI_PCT_NO = PCT_NO
				AND DTR_NO(+) = PCT_NO_DOSSIER
				AND DTR_INDEX(+) IN('P','Z') ";

				if(isset($_REQUEST['art'])){
					$query .= " AND PCI_ART_CODE = :art ";
				}

				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = $fields[0]['sqlfield'];
					$_REQUEST['order']="DESC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

				$tab_filter	= array();

				if(isset($_REQUEST['art']) && trim($_REQUEST['art']) != ""){
					array_push($tab_filter,array('name'=>'art','value'=>trim($_REQUEST['art'])));
				}

				if (isset($_REQUEST['art'])) {
					$result = execute_request($c,$query,$tab_filter);
				}

			@endphp
			<div class="container" id="grille-param">
				<form method="GET" action="{{URL('/')}}/batch-traceability" autocomplete="off">
					<div class="div_filter">
					
						<label>Article:</label>
						<input type="text" name="art" id="art" value="<?php if (isset($_REQUEST['art'])) echo $_REQUEST['art'];?>" required><br><br>
					
						<input type="submit" value="Go"/><br><br>
					</div>
				</form>

			</div>
			<?php
				if (isset($_REQUEST['art'])) {
					render_table($result, $fields);
				}
			?>
		</div>
	</div>

@endsection
