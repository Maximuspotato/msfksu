@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Packing Overview</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            @php
                include_once(app_path() . '/outils/functions.php');
                $generalparams = array(
                    'xlsname'=>'pk_overview',
                    'title'=>'Packing Overview'
                );

                // if( !isset($_REQUEST['cm'])){
                // 	$_REQUEST['cm'] = null;
                // }

                $fields[]=array(
					'sqlfield'=>"'<a target=\"_blank\" href=\"packing-view?pk=' || PCT_NO || '\">' || PCT_NO || '</a>'",
					'title'=>'Packing',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'PKNG',					//alias
					'sortsqlfield'=>'PKNG',					//sort	
				);

                $fields[]=array(
                    'sqlfield'=>'PCT_NOM_DISP',				// champ SQL pur
                    'title'=>'Dispatch',					// Title for the column
                    
                    'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                    'decimal'=>'',
                    
                    'aliasname'=>'',					//alias
                    'sortsqlfield'=>'',					//sort	
                );

                $fields[]=array(
                    'sqlfield'=>'PCT_DT_LIV',				// champ SQL pur
                    'title'=>'PK date',					// Title for the column
                    
                    'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                    'decimal'=>'',
                    
                    'aliasname'=>'',					//alias
                    'sortsqlfield'=>'',					//sort	
                );

                $fields[]=array(
                    'sqlfield'=>'PCT_NOM_LIV',				// champ SQL pur
                    'title'=>'Client',					// Title for the column
                    
                    'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                    'decimal'=>'',
                    
                    'aliasname'=>'',					//alias
                    'sortsqlfield'=>'',					//sort	
                );

                $fields[]=array(
                    'sqlfield'=>'PCT_TOT_PDS',				// champ SQL pur
                    'title'=>'Weight',					// Title for the column
                    
                    'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                    'decimal'=>'2',
                    
                    'aliasname'=>'',					//alias
                    'sortsqlfield'=>'',					//sort	
                );

                $fields[]=array(
                    'sqlfield'=>'PCT_TOT_VOL',				// champ SQL pur
                    'title'=>'Volume',					// Title for the column
                    
                    'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                    'decimal'=>'2',
                    
                    'aliasname'=>'',					//alias
                    'sortsqlfield'=>'',					//sort	
                );

                $fields[]=array(
                    'sqlfield'=>'PCT_NB_COLIS',				// champ SQL pur
                    'title'=>'Parcels',					// Title for the column
                    
                    'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                    'decimal'=>'0',
                    
                    'aliasname'=>'',					//alias
                    'sortsqlfield'=>'',					//sort	
                );

                $fields[]=array(
                    'sqlfield'=>'FCT_MT_BASE_REMISE',				// champ SQL pur
                    'title'=>'Value',					// Title for the column
                    
                    'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                    'decimal'=>'2',
                    
                    'aliasname'=>'',					//alias
                    'sortsqlfield'=>'',					//sort	
                );

                $fields[]=array(
                    'sqlfield'=>'PCT_NO_DOSSIER',				// champ SQL pur
                    'title'=>'Tr No',					// Title for the column
                    
                    'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
                    'decimal'=>'',
                    
                    'aliasname'=>'',					//alias
                    'sortsqlfield'=>'',					//sort	
                );

                $fields[]=array(
                    'sqlfield'=>'MTR_LIB',				// champ SQL pur
                    'title'=>'Tr Mode',					// Title for the column
                    
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
                FROM MS_PACK_CLI_TETE, XN_FAC_CLI_TETE, XN_CLI, XN_MODE_TRANSP
                WHERE FCT_PCT_NO(+) = PCT_NO
                AND PCT_NO < 1000000000
                AND CLI_CODE = PCT_CLI_CODE_LIV
                AND MTR_CODE = PCT_MTR_CODE ";

                if(!isset($_REQUEST['cm'])){
                    $query .= " AND PCT_NO_DOSSIER IS NULL ";
                }

                if (session()->get('oc') != "") {
                    $query .= " AND CLI_SFC_CODE = '".session()->get('oc')."'";
                }

                if (session()->get('country') != "") {
                    $query .= " AND CLI_PAY_CODE = '".session()->get('country_code')."'";
                }

                if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
                    $_REQUEST['orderby'] = $fields[2]['sqlfield'];
                    $_REQUEST['order']="DESC";
                }

                $query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];

                $tab_filter	= array();

                if(isset($_REQUEST['client']) && trim($_REQUEST['client']) != ""){
                    array_push($tab_filter,array('name'=>'client','value'=>trim($_REQUEST['client'])));
                }
                //dd($tab_filter);

                //echo '<pre>'.$query.'</pre>';

                $result = execute_request($c,$query,$tab_filter);

                if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
                    render_table_xls($result);	
                    exit();
                }
            @endphp

            <div id="grille-param">
                <form method="GET" action="{{URL('/')}}/pk-overview" autocomplete="off">
                    <div class="div_filter">
                        <label>Include:</label>
                        <input type="checkbox" name="cm" id="cm" value="cm" <?php if(isset($_REQUEST['cm'])) echo "checked=" ?>> Cargo Manifest<br><br>
                    
                        <input type="submit" value="Go"/>
                    </div>
                    </form>
                    <span>Weight:</span>
                    <span id="weight"></span><br>
                    <span>Volume:</span>
                    <span id="volume"></span><br>
                    <span>Parcel:</span>
                    <span id="parcel"></span><br>
                    <span>Value:</span>
                    <span id="value"></span><br><br>
            </div>
            @php
            render_table($result, $fields);   
           @endphp
        </div>
    </div>
    <script>
        var table = document.getElementById('table_request');
        var trows = table.rows;
        var totWeight = 0;
        var totVolume = 0;
        var totParcel = 0;
        var totValue = 0;
        console.log(totWeight);
        for (var i = 1; i < trows.length; i++) {
            totWeight += parseFloat(trows[i].cells[4].innerHTML.replace(',',''));
            totVolume += parseFloat(trows[i].cells[5].innerHTML.replace(',','')/1000);
            totParcel += parseInt(trows[i].cells[6].innerHTML.replace(',',''));
            if (trows[i].cells[7].innerHTML == '') {
                trows[i].cells[7].innerHTML = '0'
            }
            totValue += parseFloat(trows[i].cells[7].innerHTML.replace(',',''));
        }
        if (totWeight) {
            document.getElementById('weight').textContent = totWeight.toFixed(2) + ' Kgs';
        }
        if (totVolume) {
            document.getElementById('volume').textContent = totVolume.toFixed(2) + ' m3';
        }
        if (totParcel) {
            document.getElementById('parcel').textContent = totParcel;
        }
        if (totValue) {
            document.getElementById('value').textContent = totValue.toFixed(2);
        }
    </script>
@endsection