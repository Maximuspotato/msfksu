@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>RTS Report</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			@php
				include_once(app_path() . '/outils/functions.php');

				$_REQUEST['art'] = (!isset($_REQUEST['art']) || trim($_REQUEST['art']) == ""?'%':$_REQUEST['art']);
				$_REQUEST['var1'] = (!isset($_REQUEST['var1']) || trim($_REQUEST['var1']) == ""?'%':$_REQUEST['var1']);
				$_REQUEST['batch'] = (!isset($_REQUEST['batch']) || trim($_REQUEST['batch']) == ""?'%':$_REQUEST['batch']);

				$generalparams = array(
					'xlsname'=>'rts_report',
				);

				$fields[]=array(
					'sqlfield'=>"
					CASE
						WHEN PCT_CLI_CODE_DISP = 'BEKE1-55' THEN 'BEKE1-01'
						WHEN PCT_CLI_CODE_DISP = 'BE-KE1-55' THEN 'BEKE1-01'
						WHEN PCT_CLI_CODE_DISP = 'BEKE1-63' THEN 'BEKE1-01'
						WHEN PCT_CLI_CODE_DISP = 'BE-KE1-63' THEN 'BEKE1-01'
						WHEN PCT_CLI_CODE_DISP = 'BEKE1-65' THEN 'BEKE1-01'
						WHEN PCT_CLI_CODE_DISP = 'BE-KE1-65' THEN 'BEKE1-01'
						WHEN PCT_CLI_CODE_DISP = 'BEKE1-92' THEN 'BEKE1-01'
						WHEN PCT_CLI_CODE_DISP = 'BE-KE1-92' THEN 'BEKE1-01'
						ELSE PCT_CLI_CODE_DISP
					END
					",				// champ SQL pur
					'title'=>'Client code',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'CLIENTCODE',					// alias
					'sortsqlfield'=>'',
				);

				$fields[]=array(
					'sqlfield'=>"
						CASE
							WHEN PCT_CLI_CODE_DISP = 'BEKE1-01' AND PCT_CHA_CODE = '0' THEN 'BE-KE1-63'
							WHEN PCT_CLI_CODE_DISP = 'BEKE1-55' THEN 'BE-KE1-55'
							WHEN PCT_CLI_CODE_DISP = 'BE-KE1-55' THEN 'BE-KE1-55'
							WHEN PCT_CLI_CODE_DISP = 'BEKE1-63' THEN 'BE-KE1-63'
							WHEN PCT_CLI_CODE_DISP = 'BE-KE1-63' THEN 'BE-KE1-63'
							WHEN PCT_CLI_CODE_DISP = 'BEKE1-65' THEN 'BE-KE1-65'
							WHEN PCT_CLI_CODE_DISP = 'BE-KE1-65' THEN 'BE-KE1-65'
							WHEN PCT_CLI_CODE_DISP = 'BEKE1-92' THEN 'BE-KE1-92'
							WHEN PCT_CLI_CODE_DISP = 'BE-KE1-92' THEN 'BE-KE1-92'
							ELSE PCT_CHA_CODE
						END
					",				// champ SQL pur
					'title'=>'Project code',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'PROJECTCODE',					// alias
					'sortsqlfield'=>'',
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
					'sqlfield'=>'PCL_ART_VAR1',			// champ SQL pur
					'title'=>'Version',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'PCL_DES1',				// champ SQL pur
					'title'=>'Description',				// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>"
						CASE
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'C' THEN 'LOG'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'E' THEN 'MED'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'N' THEN 'MED'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'P' THEN 'LOG'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'D' THEN 'MED'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'I' THEN 'LOG'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'Y' THEN 'LOG'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'X' THEN 'LOG'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'T' THEN 'LOG'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'L' THEN 'LOG'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'A' THEN 'LOG'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'S' THEN 'MED'
						WHEN SUBSTR(PCL_ART_CODE,1,1) = 'K' THEN CASE
							WHEN SUBSTR(PCL_ART_CODE,2,3) IN ('MED') THEN 'MED'
							WHEN SUBSTR(PCL_ART_CODE,2,3) = 'SUD' THEN 'MED'
							WHEN SUBSTR(PCL_ART_CODE,2,3) = 'SUO' THEN 'MED'
							WHEN SUBSTR(PCL_ART_CODE,2,3) = 'SUR' THEN 'MED'
							ELSE 'LOG'
						END
						END
					",				// champ SQL pur
					'title'=>'Type',				// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',
					
					'aliasname'=>'ARTGROUP',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'SUM_QTE_LIV',		// champ SQL pur
					'title'=>'Quantity',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',
					
					'aliasname'=>'SUM_QTE_LIV',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'SUM_MT_HT_LIGNE',		// champ SQL pur
					'title'=>'Price',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',
					
					'aliasname'=>'SUM_MT_HT_LIGNE',					//alias
					'sortsqlfield'=>'',					//sort
				);

				$fields[]=array(
					'sqlfield'=>'PCL_NO_SERIE_LOT',		// champ SQL pur
					'title'=>'Batch/Series',					// Title for the column
					
					'format'=>'string',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"DTPEREMP",		// champ SQL pur
					'title'=>'Expiry',					// Title for the column
					
					'format'=>'date',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'DTPEREMP',					//alias
					'sortsqlfield'=>"TO_DATE(DTPEREMP,'DD/MM/YYYY')",					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"TYPE",		// champ SQL pur
					'title'=>'Item type',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'TYPE',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_NO',		// champ SQL pur
					'title'=>'Packing NB',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>"PCT_DT_CREAT",		// champ SQL pur
					'title'=>'Packing Creation',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'PCT_DT_CREAT',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCC_NO_GROUPAGE',		// champ SQL pur
					'title'=>'Parcel from',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCC_NO_COLIS_FIN',		// champ SQL pur
					'title'=>'Parcel to',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'TOTPARCELS',		// champ SQL pur
					'title'=>'Tot parcels',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				//Filtre pour n afficher que sur l intranet
				//if(isset($_REQUEST['INTRANET'])  && $_REQUEST['INTRANET'] == 1){
					
					$fields[]=array(
						'sqlfield'=>'PCC_MAG_CODE',		// champ SQL pur
						'title'=>'MAG',					// Title for the column
						
						'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
						'decimal'=>'',
					
						'aliasname'=>'',					//alias
						'sortsqlfield'=>'',					//sort	
					);
					
					$fields[]=array(
						'sqlfield'=>'PCC_ALLEE',		// champ SQL pur
						'title'=>'ALLEE',					// Title for the column
						
						'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
						'decimal'=>'',
					
						'aliasname'=>'',					//alias
						'sortsqlfield'=>'',					//sort	
					);
					
					$fields[]=array(
						'sqlfield'=>'PCC_RANG',		// champ SQL pur
						'title'=>'RANG',					// Title for the column
						
						'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
						'decimal'=>'',
					
						'aliasname'=>'',					//alias
						'sortsqlfield'=>'',					//sort	
					);
					
					$fields[]=array(
						'sqlfield'=>'PCC_NIVEAU',		// champ SQL pur
						'title'=>'Level',					// Title for the column
						
						'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
						'decimal'=>'',
					
						'aliasname'=>'',					//alias
						'sortsqlfield'=>'',					//sort	
					);

					
					

					
				//}

				$fields[]=array(
					'sqlfield'=>'PCC_PDS',		// champ SQL pur
					'title'=>'Weight/parcel',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCC_VOL',		// champ SQL pur
					'title'=>'Vol/parcel',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_NO_DOSSIER_ORIG',		// champ SQL pur
					'title'=>'Internat. freight',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_REF_ORIG',		// champ SQL pur
					'title'=>'Original packing',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'PCT_REF_CMDE1',		// champ SQL pur
					'title'=>'Purchase order',					// Title for the column
					
					'format'=>'text',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'TOT_QTE',		// champ SQL pur
					'title'=>'Total Qty',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'0',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$fields[]=array(
					'sqlfield'=>'TOT_MONTANT',		// champ SQL pur
					'title'=>'Total Value',					// Title for the column
					
					'format'=>'number',					// text = default, number = format XX.XXX,XX, date DD/MM/YYYY or string(force a number to be a string -> for excel)
					'decimal'=>'2',

					'aliasname'=>'',					//alias
					'sortsqlfield'=>'',					//sort	
				);

				$c = db_connect();

				$query = "

				WITH PACKING_RTS AS (

					SELECT * 
						FROM MS_PACK_CLI_TETE,
							(SELECT * FROM MS_PACK_CLI_LIGNE UNION ALL SELECT * FROM TR_PACK_CLI_LIGNE_INTER) MS_PACK_CLI_LIGNE,
							MS_PACK_CLI_COLIS
							
							WHERE MS_PACK_CLI_TETE.PCT_NO = MS_PACK_CLI_COLIS.PCC_PCT_NO
								AND MS_PACK_CLI_TETE.PCT_DEP_CODE = MS_PACK_CLI_COLIS.PCC_PCT_DEP_CODE
								AND MS_PACK_CLI_TETE.PCT_DEP_SOC_CODE = MS_PACK_CLI_COLIS.PCC_PCT_DEP_SOC_CODE
								
								AND MS_PACK_CLI_COLIS.PCC_PCT_NO = MS_PACK_CLI_LIGNE.PCL_PCT_NO
								AND MS_PACK_CLI_COLIS.PCC_PCT_DEP_CODE = MS_PACK_CLI_LIGNE.PCL_DEP_CODE
								AND MS_PACK_CLI_COLIS.PCC_PCT_DEP_SOC_CODE = MS_PACK_CLI_LIGNE.PCL_DEP_SOC_CODE
								AND MS_PACK_CLI_COLIS.PCC_NO_GROUPAGE = MS_PACK_CLI_LIGNE.PCL_NO_COLIS   

								AND MS_PACK_CLI_TETE.PCT_NO_DOSSIER is null
								and ms_pack_cli_tete.pct_index NOT IN  ('0','X') --RMZ 24/3/16 Maurice
								
								AND MS_PACK_CLI_LIGNE.PCL_ART_CODE LIKE :art
								AND MS_PACK_CLI_LIGNE.PCL_ART_VAR1 LIKE :var1


				";
								
				if(isset($_REQUEST['batch']) && trim($_REQUEST['batch']) != "%"){
						$query .= " AND MS_PACK_CLI_LIGNE.PCL_NO_SERIE_LOT LIKE :batch ";
					}	
						
					if(isset($_REQUEST['dispatch']) && trim($_REQUEST['dispatch']) != ""){
						$query .= " AND PCT_CLI_CODE_DISP = :dispatch ";
					}

					if(isset($_REQUEST['expAfter']) && trim($_REQUEST['expAfter']) != ""){
						$query .= " AND PCL_DT_PEREMPTION >= TO_DATE(:expAfter,'DD/MM/YYYY') ";
					}
					
					if(isset($_REQUEST['expBefore']) && trim($_REQUEST['expBefore']) != ""){
						$query .= " AND PCL_DT_PEREMPTION <= TO_DATE(:expBefore,'DD/MM/YYYY') ";
					}
					
				$query .= "   

				)

						SELECT 
						
						";

				foreach ($fields as $k => $field) {
					$query .= $field['sqlfield'].' '.$field['aliasname'].($k < (count($fields) -1)?',':'');
				}

				$query .= "				 
							FROM 
							
							(
							
								SELECT PCT_CLI_CODE_DISP ,
									PCL_ART_CODE ,
									PCL_ART_VAR1 ,
									PCL_DES1 ,
									SUM(PCL_QTE_LIV) SUM_QTE_LIV,
									SUM(PCL_MT_HT_LIGNE) SUM_MT_HT_LIGNE,
									PCL_NO_SERIE_LOT ,
									TO_CHAR(PCL_DT_PEREMPTION,'DD/MM/YYYY') DTPEREMP,
									CASE WHEN ART_CAA_CODE <> '0' THEN ART_CAA_CODE ELSE NULL END TYPE,
									PCT_NO ,
									TO_CHAR(PCT_DT_CREAT,'YYYY/MM/DD') PCT_DT_CREAT,
									PCC_NO_GROUPAGE ,
									PCC_NO_COLIS_FIN ,
									(pcc_no_colis_fin-PCC_NO_GROUPAGE+1) TOTPARCELS,
									PCC_MAG_CODE ,
									PCC_ALLEE ,
									PCC_RANG ,
									PCC_NIVEAU ,
									PCC_PDS ,
									PCC_VOL ,
									PCT_NO_DOSSIER_ORIG ,
									NVL(TO_CHAR(PCT_NO_ORIG),PCT_REF_ORIG) PCT_REF_ORIG,
									PCT_REF_CMDE1,
									

									NULL TOT_QTE,
									NULL TOT_MONTANT  ,
				pct_cha_code					   

									FROM PACKING_RTS,
										XN_ART

										WHERE PACKING_RTS.PCL_ART_CODE = XN_ART.ART_CODE(+)
											AND PACKING_RTS.PCL_ART_VAR1 = XN_ART.ART_VAR1(+)               
											AND PACKING_RTS.PCL_ART_VAR2 = XN_ART.ART_VAR2(+)
											AND PACKING_RTS.PCL_ART_VAR3 = XN_ART.ART_VAR3(+)            

									GROUP BY PCT_CLI_CODE_DISP,
										PCL_ART_CODE,
										PCL_ART_VAR1,
										PCL_DES1,
										PCL_NO_SERIE_LOT,
										TO_CHAR (PCL_DT_PEREMPTION, 'DD/MM/YYYY'),
										ART_CAA_CODE,
										PCT_NO,
										PCT_DT_CREAT,
										PCC_NO_GROUPAGE,
										PCC_NO_COLIS_FIN,
										(pcc_no_colis_fin - PCC_NO_GROUPAGE + 1),
										PCC_MAG_CODE,
										PCC_ALLEE,
										PCC_RANG,
										PCC_NIVEAU,
										PCC_PDS,
										PCC_VOL,
										PCT_NO_DOSSIER_ORIG,
										NVL (TO_CHAR (PCT_NO_ORIG), PCT_REF_ORIG),
										PCT_REF_CMDE1,
										pct_cha_code

								UNION ALL


								SELECT PCT_CLI_CODE_DISP ,
									PCL_ART_CODE ,
									PCL_ART_VAR1,
									PCL_DES1 ,
									NULL, --SUM(PCL_QTE_LIV) SUM_QTE_LIV,
									NULL, --SUM(PCL_MT_HT_LIGNE) SUM_MT_HT_LIGNE,
									NULL, --PCL_NO_SERIE_LOT ,
									NULL, --TO_CHAR(PCL_DT_PEREMPTION,'DD/MM/YYYY') DTPEREMP,
									NULL, --CASE WHEN ART_CAA_CODE <> '0' THEN ART_CAA_CODE ELSE NULL END TYPE,
									NULL, --PCT_NO ,
									NULL, --TO_CHAR(PCT_DT_CREAT,'YYYY/MM/DD') ,
									NULL, --PCC_NO_GROUPAGE ,
									NULL, --PCC_NO_COLIS_FIN ,
									NULL, --(pcc_no_colis_fin-PCC_NO_GROUPAGE+1) TOTPARCELS,
									NULL, --PCC_MAG_CODE ,
									NULL, --PCC_ALLEE ,
									NULL, --PCC_RANG ,
									NULL, --PCC_NIVEAU ,
									NULL, --PCC_PDS ,
									NULL, --PCC_VOL ,
									NULL, --PCT_NO_DOSSIER_ORIG ,
									NULL, --NVL(TO_CHAR(PCT_NO_ORIG),PCT_REF_ORIG) ,
									NULL, --PCT_REF_CMDE1
									SUM(PCL_QTE_LIV) TOT_QTE,
									SUM(PCL_MT_HT_LIGNE) TOT_MONTANT,
										pct_cha_code

									FROM PACKING_RTS

										GROUP BY PCT_CLI_CODE_DISP ,
									PCL_ART_CODE,
									PCL_ART_VAR1,
									PCL_DES1,
										pct_cha_code

								--ORDER BY PCT_CLI_CODE_DISP,PCL_ART_CODE,PCL_ART_VAR1,PCT_NO DESC
							
							)
							
						"; 	

					
				if (!isset($_REQUEST['orderby']) OR !isset($_REQUEST['order'])) {
					$_REQUEST['orderby'] = $fields[0]['sqlfield'];
					$_REQUEST['order']="ASC";
				}

				$query .= ' ORDER BY '.$_REQUEST['orderby'].' '.$_REQUEST['order'];
				

				$tab_filter	= array(
					array('name'=>'art','value'=>$_REQUEST['art']),
					array('name'=>'var1','value'=>$_REQUEST['var1']),
					
				);	

				if(isset($_REQUEST['batch']) && trim($_REQUEST['batch']) != "%"){
					array_push($tab_filter,array('name'=>'batch','value'=>$_REQUEST['batch']));
				}
					
				if(isset($_REQUEST['dispatch']) && trim($_REQUEST['dispatch']) != ""){
					array_push($tab_filter,array('name'=>'dispatch','value'=>$_REQUEST['dispatch']));
				}

				if(isset($_REQUEST['expAfter']) && trim($_REQUEST['expAfter']) != ""){
					array_push($tab_filter,array('name'=>'expAfter','value'=>$_REQUEST['expAfter']));
				}

				if(isset($_REQUEST['expBefore']) && trim($_REQUEST['expBefore']) != ""){
					array_push($tab_filter,array('name'=>'expBefore','value'=>$_REQUEST['expBefore']));
				}
								

				//echo '<pre>'.print_r($query,true).'</pre>';				
								
				$result = execute_request($c,$query,$tab_filter);

				if(isset($_REQUEST['xls']) && $_REQUEST['xls'] == 'yes'){
					render_table_xls($result, $fields, $generalparams);	
					exit();
				}
			@endphp
			<?php
				render_table($result, $fields);
			?>
		</div>
	</div>

@endsection
