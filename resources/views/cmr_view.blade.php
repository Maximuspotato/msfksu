@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>CMR View</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$generalparams = array(
					'xlsname'=>'cmr_view',
					'title'=>'CMR View'
				);

				$fields[]=array(
					'sqlfield'=>'DTR_NO',				// champ SQL pur
					'title'=>'File no',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'SDT_NO',				// champ SQL pur
					'title'=>'Subfile',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"
					CASE
					WHEN DTR_MTR_CODE = 'R' THEN DTR_NO_BL_TRANSP
					WHEN DTR_MTR_CODE = 'A' THEN DTR_MAWB
					END
					",				// champ SQL pur
					'title'=>'DN no/AWB',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'DNAWN',					//alias
					'sortsqlfield'=>'DNAWN',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'FCT_NO_FACTURE',				// champ SQL pur
					'title'=>'Freight invoice',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_OBS2',				// champ SQL pur
					'title'=>'Mission ref',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_CHA_CODE',				// champ SQL pur
					'title'=>'Project code',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"packing-view?pk=' || PCT_NO || '\">' || PCT_NO || '</a>'",
					'title'=>'Packing',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'PK',					//alias
					'sortsqlfield'=>'PK',					//sort	
				);

                $fields[]=array(
					'sqlfield'=>'PCT_NO_FACTURE',				// champ SQL pur
					'title'=>'Goods invoice',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
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
					'sqlfield'=>'PCL_DT_PEREMPTION',				// champ SQL pur
					'title'=>'Expiry',					// Title for the column
					
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
					'sqlfield'=>'FOU_NOM',				// champ SQL pur
					'title'=>'Manufacturer',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PAY_NOM',				// champ SQL pur
					'title'=>'Country',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCL_QTE_LIV',				// champ SQL pur
					'title'=>'Qty delivered',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCL_PX_REMISE',				// champ SQL pur
					'title'=>'Amount',					// Title for the column
					
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
                FROM MS_DOSSIER_TRANSP, MS_SSDOSSIER_TRANSP, XN_FAC_CLI_TETE, MS_PACK_CLI_TETE, MS_PACK_CLI_LIGNE, XN_FOUR, XN_PAYS, XN_CLI
				WHERE DTR_NO(+) = SDT_DTR_NO
				AND TO_CHAR(SDT_DTR_NO) = FCT_PCT_NO(+)
				AND PCT_NO_DOSSIER(+) = DTR_NO
				AND PCL_PCT_NO(+) = PCT_NO
				AND FOU_CODE = DTR_FOU_CODE
				AND PAY_CODE = DTR_PAY_CODE_DISP
				AND CLI_CODE = DTR_CLI_CODE_DISP ";

				if(isset($_REQUEST['cmr'])){
					$query .= " AND SDT_LTA_CMR_TC = :cmr ";
				}

				if (session()->get('oc') != "") {
					$query .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
				}

				if (session()->get('country') != "") {
					$query .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
				}

				$query .= " GROUP BY DTR_NO, SDT_NO, FCT_NO_FACTURE, PCT_OBS2, PCT_CHA_CODE, PCT_NO, PCT_NO_FACTURE, PCL_ART_CODE, PCL_DES1, PCL_ART_VAR1, PCL_DT_PEREMPTION,
							PCL_NO_SERIE_LOT, FOU_NOM, PAY_NOM, PCL_QTE_LIV, PCL_PX_REMISE, DTR_MTR_CODE, DTR_NO_BL_TRANSP, DTR_MAWB, SDT_LTA_CMR_TC ";

				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = $fields[0]['sqlfield'];
					$_REQUEST['order']="DESC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

				$tab_filter	= array();

				if(isset($_REQUEST['cmr']) && trim($_REQUEST['cmr']) != ""){
					array_push($tab_filter,array('name'=>'cmr','value'=>trim($_REQUEST['cmr'])));
				}

				if(isset($_REQUEST['cmr'])){
					$result = execute_request($c,$query,$tab_filter);
				}
			@endphp
			<div class="container" id="grille-param">
				<form method="GET" action="{{URL('/')}}/cmr-view" autocomplete="off">
					<div class="div_filter">
					
						<label>CMR:</label>
						<input type="text" name="cmr" id="cmr" value="<?php if (isset($_REQUEST['cmr'])) echo $_REQUEST['cmr'];?>" required><br><br>
					
						<input type="submit" value="Go"/><br><br>
					</div>
				</form>
			</div>
			<?php
				if (isset($_REQUEST['cmr'])) {
					render_table($result, $fields);
				}
			?>
		</div>
	</div>

@endsection
