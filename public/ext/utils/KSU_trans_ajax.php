<?php
	include_once('..\..\..\app\outils\functions.php');
	
	$c = db_connect();

	
	
	if(isset($_REQUEST['dtr_no']) || isset($_REQUEST['dtr_nos'])){
		if(isset($_REQUEST['det'])){
			if ($_REQUEST['det'] === 'fetch') {
				$query = "SELECT * FROM EXT_DOSSIER_TRANSP_COMM WHERE DTC_DTR_NO = :dtr_no ORDER BY DTC_DT DESC";
									
				$stmt = oci_parse($c, $query);
				ocibindbyname($stmt, ":dtr_no", $_REQUEST['dtr_no']);	
				ociexecute($stmt, OCI_DEFAULT);
				$nrows = ocifetchstatement($stmt, $result,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

				if ($nrows > 0) {
					echo json_encode($result);
				} else {
					echo "empty";
				}
				
			} else {
				$query = "INSERT INTO EXT_DOSSIER_TRANSP_COMM (DTC_DTR_NO, DTC_DT, DTC_COMM) VALUES (:dtr_nos, SYSDATE, :comm) ";
				$stmt = oci_parse($c, $query);
				ocibindbyname($stmt, ":dtr_nos", $_REQUEST['dtr_nos']);
				ocibindbyname($stmt, ":comm", $_REQUEST['comm']);
				
				oci_execute($stmt, OCI_DEFAULT);
				oci_commit($c);
			}
		}else{
			$query = "SELECT * FROM EXT_DOSSIER_TRANSP_RC WHERE DTRC_DTR_NO = :dtr_no ";
									
			$stmt = oci_parse($c, $query);
			ocibindbyname($stmt, ":dtr_no", $_REQUEST['dtr_no']);	
			ociexecute($stmt, OCI_DEFAULT);
			$nrows = ocifetchstatement($stmt, $result,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
			
			if($nrows > 0){
				if ($_REQUEST['recieved'] != "") {
					$query = "UPDATE EXT_DOSSIER_TRANSP_RC SET DTRC_DT_RC = :recieved WHERE DTRC_DTR_NO = :dtr_no ";
					$stmt = oci_parse($c, $query);
					ocibindbyname($stmt, ":dtr_no", $_REQUEST['dtr_no']);
					$strToDate = strtotime($_REQUEST['recieved']);
					$dt = date('d-M-y', $strToDate);
					ocibindbyname($stmt, ":recieved", $dt);	
					
					oci_execute($stmt, OCI_DEFAULT);
					oci_commit($c);
				} else {
					$query = "DELETE FROM EXT_DOSSIER_TRANSP_RC WHERE DTRC_DTR_NO = :dtr_no ";
					$stmt = oci_parse($c, $query);
					ocibindbyname($stmt, ":dtr_no", $_REQUEST['dtr_no']);
					
					oci_execute($stmt, OCI_DEFAULT);
					oci_commit($c);
				}
			}else{
				$query = "INSERT INTO EXT_DOSSIER_TRANSP_RC (DTRC_DTR_NO, DTRC_DT_RC) VALUES (:dtr_no, :recieved) ";
				$stmt = oci_parse($c, $query);
				ocibindbyname($stmt, ":dtr_no", $_REQUEST['dtr_no']);
				$strToDate = strtotime($_REQUEST['recieved']);
				$dt = date('d-M-y', $strToDate);
				ocibindbyname($stmt, ":recieved", $dt);
				
				oci_execute($stmt, OCI_DEFAULT);
				oci_commit($c);
			}
		}
	}
?>	