<?php

/***************************************************************************************************************************************
	Function to connect to the DB
****************************************************************************************************************************************/	
function db_connect() {	
	$c = ocilogon("MSF", "MSF", "192.168.125.26:1521/ORCL");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( oci_error() );
		die();
	}
	return($c);
}

function db_connect_msfs() {	
	$c = ocilogon("msf", "msf", "//172.30.1.11/ORCL");
	if ( ! $c ) {
		echo "Unable to connect: " . var_dump( oci_error() );
		die();
	}
	return($c);
}


/***************************************************************************************************************************************
	Function that renders the result of the request
****************************************************************************************************************************************/
function execute_request($c,$query,$tab_filter) {
	
	$stmt = oci_parse($c, $query);
	
	// filters of the request
	//dd($query);
	foreach($tab_filter as $one_filter){
		if($one_filter['value'] !="") ocibindbyname($stmt, ":".$one_filter['name'], $one_filter['value']);	
	}
	
	ociexecute($stmt, OCI_DEFAULT);
	$nrows = ocifetchstatement($stmt, $result,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
	
	return $result;
}


/***************************************************************************************************************************************
	Function that renders the result of the request
****************************************************************************************************************************************/
function render_table($result, $fields) {
?>	
	<script type="text/javascript" src="/javascript/jquery1_5.js"></script>
	<script type="text/javascript" src="/javascript/jquery-plugin-numericInput/numericInput.js"></script>
    <script type="text/javascript" src="/javascript/jquery.maskedinput-1.3.js"></script>
	<script type="text/javascript" src="/javascript/jquery.freezeheader.js"></script>
    <script type="text/javascript" src="/javascript/picnet.table.filter.min.js"></script>
    
    <script>
		$(document).ready(function() {
			$("#table_request").freezeHeader();
			$("#table_request").tableFilter();
		});
	</script>
    
<?php
	//echo '<pre>'.print_r($result,true).'</pre>';	
	if(count($result) > 0){
	$fullurl = Request::fullUrl();
	if(strpos($fullurl, '?')){
		$fullurl .="&xls=yes";
	}else {
		$fullurl .="?xls=yes";
	}

?>	
	<i class="i_excel">
    	<img src="<?php echo url('/') ?>/ext/images/xls_icon.gif"/>
		<a href="<?php echo $fullurl ?>">This table in Excel</a>
    </i>
    <br>
	<table class="table_request" id="table_request">
    	<thead id="tablenav">
        	<tr>
<?php
			$urlRequest = $_SERVER['PHP_SELF'];
			$urlParam = $_SERVER['QUERY_STRING'];
			
			//Delete the parameter order and orderby, we suppose that order and orderby parameter are together
			$posOrder = strpos($urlParam,"&order=");
			$posOrderBy = strpos($urlParam,"&orderby=");
			
			if($posOrder !== FALSE && $posOrderBy !== FALSE){
				$posNextParam = strpos($urlParam,"&",($posOrder>$posOrderBy?$posOrder:$posOrderBy)+1);
				$urlNoOrder = $_SERVER['PHP_SELF'].'?'.substr($_SERVER['QUERY_STRING'],0,($posOrder>$posOrderBy?$posOrderBy:$posOrder)).($posNextParam > 0?substr($_SERVER['QUERY_STRING'],$posNextParam):'');
			}else{
				$urlNoOrder = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
			}
			
			foreach ($fields as $k=>$field){        
?>
				<th>
                	<a href="<?php echo $urlNoOrder.'&orderby='.($field['sortsqlfield']==""?$field['sqlfield']:$field['sortsqlfield'])."&order=".($_REQUEST['order']=='ASC'?'DESC':'ASC');?>">
<?php 					
						echo $field['title'];
						
						if ($_REQUEST['orderby'] == ($field['sortsqlfield']==""?$field['sqlfield']:$field['sortsqlfield']) ) {
?>							
								<img style="margin-bottom:-3px;" src="<?php echo url('/') ?>/ext/images/<?php echo ($_REQUEST['order']=="ASC"?'arrow_down_16.png':'arrow_up_16.png');?>" />
<?php					}	?>
					</a>                        
                </th>
<?php						
			}
?>			
        	</tr>
        </thead>
        <tbody>
<?php
			foreach ($result as $k=>$line){  
?>			
				<tr>
<?php            
				foreach ($fields as $k => $field) {
					$fieldvalue = ($field['aliasname']!=""?$line[$field['aliasname']]:$line[$field['sqlfield']]);
					
					if($field['format'] == 'number' && $fieldvalue != ""){
						$fieldvalue = number_format($fieldvalue,(isset($field['decimal']) && trim($field['decimal']) != "" && $field['decimal'] >= 0?$field['decimal']:5),'.',',');
					}
?>
					<td style=" <?php echo ($field['format'] == 'number'?'text-align:right;':'');?>"><?php echo utf8_encode($fieldvalue);?></td>
<?php						
				}
?>
				</tr>
<?php			
			}
?>	        
        
        </tbody>
	</table>
<?php	
	}else{
?>
		<div class="div_no_result">No result!</div>
<?php		
	}
}



function render_table_xls($result, $fields, $generalparams){

	//global $generalparams;
	//echo memory_get_usage()."-";
	
	include_once "PHPExcel/Classes/PHPExcel.php";
	include_once "PHPExcel/Classes/PHPExcel/IOFactory.php";

	error_reporting(E_ALL);
	date_default_timezone_set('Europe/London');
		
	// font style
	$style = array(
				'font'    => array(
					'bold'      => true
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				),
				'fill' => array(
					'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
					'rotation'   => 90,
					'startcolor' => array(
						'argb' => 'FFA0A0A0'
					),
					'endcolor'   => array(
						'argb' => 'FFFFFFFF'
					)
				)
			);
			

	$objExcel = new PHPExcel();
	
	//title
	$car = 'A';
	$j = 1;
	$objExcel->setActiveSheetIndex(0);
	
	foreach($fields as $k => $field){
		//If we want the field in the excel (if we don't we put displayXLS to false)
		if(!isset($field['displayXLS']) || $field['displayXLS']!='false'){
			//$objExcel->getActiveSheet()->setCellValue($car.$j, utf8_encode(html_entity_decode($field['titre'])));
			$objExcel->getActiveSheet()->setCellValue($car.$j, html_entity_decode($field['title']));
			$car++;
		}
	}
	
	
	//the css style
	$objExcel->getActiveSheet()->getStyle('A'.$j.':'.$car.$j)->applyFromArray($style);
	$j++;
	
	foreach ($result as $k=>$line){  
		$car = 'A';
		foreach ($fields as $k => $field) {
			$fieldvalue = ($field['aliasname']!=""?$line[$field['aliasname']]:$line[$field['sqlfield']]);
			
			if($field['format'] == 'number' && $fieldvalue != ""){
				$fieldvalue = number_format($fieldvalue,(isset($field['decimal']) && trim($field['decimal']) != "" && $field['decimal'] >= 0?$field['decimal']:5),'.','');
			}
			
			if(isset($field['format']) && $field['format']=='date' && $fieldvalue != ''){
				$tabDt = explode("/", $fieldvalue);
				$objExcel->getActiveSheet()->setCellValue($car.$j, PHPExcel_Shared_Date::FormattedPHPToExcel($tabDt[2], $tabDt[1], $tabDt[0]));
				$objExcel->getActiveSheet()->getStyle($car.$j)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
			}elseif(isset($field['format']) && $field['format']=='string'){
				$objExcel->getActiveSheet()->setCellValueExplicit($car.$j, utf8_encode($fieldvalue), PHPExcel_Cell_DataType::TYPE_STRING);
			}else{
				$objExcel->getActiveSheet()->setCellValue($car.$j, utf8_encode($fieldvalue));
			}
			
			$car++;
		}
		
		$j++;
	}
	
	
	// Resize column
	foreach(range('A',$car) as $columnID){
		$objExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	}
	
	$generalparams['xlsname'] = (trim($generalparams['xlsname']) == ""?"export":str_replace(" ","",$generalparams['xlsname']));
		
	// Redirect output to a client's web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$generalparams['xlsname'].'.xls"');
	
	header('Cache-Control: max-age=0');
	ob_get_clean();
	$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
	
	$objWriter->save('php://output');
	exit;
}

function logtext($log_text)
{
  	syslog(LOG_INFO, $_SERVER['REMOTE_ADDR'].'@'.$_SERVER['SCRIPT_FILENAME'].' '.$_SESSION['username'].' '.$log_text);
}
?>
