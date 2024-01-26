@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Playground</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        @php
			use PhpOffice\PhpSpreadsheet\Spreadsheet;
			use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

			include_once(app_path() . '/outils/functions.php');

			$c = db_connect();

			$queryAp = " SELECT DFL_DFT_NO AP_NO, DFL_ART_CODE ARTICLE
			FROM MS_DEVIS_FOUR_LIGNE, MS_DEVIS_FOUR_TETE
			WHERE DFL_A_CMDER = 'O'
			AND DFT_NO_DEVIS = DFL_DFT_NO
			ORDER BY DFL_DFT_NO DESC ";
			$stmtAp = oci_parse($c, $queryAp);
			ociexecute($stmtAp, OCI_DEFAULT);
			$nrowsAp = ocifetchstatement($stmtAp, $resultAp,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

			if ($nrowsAp > 0) {
				$objPHPExcel    =   new Spreadsheet();

				//$objPHPExcel->setActiveSheetIndex(0);
				//NAME WORKSHEET
				$objPHPExcel->getActiveSheet()->setTitle("Sheet");

				$objPHPExcel->getActiveSheet()
					->getPageSetup()
					->setOrientation(PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

				$objPHPExcel->getActiveSheet()
					->getPageSetup()
					->setPaperSize(PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

				//$objPHPExcel->getActiveSheet()->SetCellValue('A12', 'ROW1');
				//$objPHPExcel->getActiveSheet()->SetCellValue('B12', 'ROW2');
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'AP_NO');
				$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ARTICLE');

				$rowCount = 2;
				foreach($resultAp as $result){
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result['AP_NO']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result['ARTICLE']);
					$rowCount++;
				}
				$writer = new Xlsx($objPHPExcel);
				$fileName = "/ap.xlsx";
				$uploc = public_path("powerbi").$fileName;
				$writer->save($uploc);
			}

			$queryAphead = " SELECT DFT_NO_DEVIS AP_NO, DFT_REF_CLIENT OP_NO, DFT_DT AP_DT, CCT_DT_CMDE ORDER_DT, DFT_DT-CCT_DT_CMDE QUOTATION_DAYS
			FROM MS_DEVIS_FOUR_TETE, XN_CMDE_CLI_TETE
			WHERE DFT_INDEX = 'W'
			AND CCT_NO = DFT_REF_CLIENT
			ORDER BY DFT_NO_DEVIS DESC ";
			$stmtAphead = oci_parse($c, $queryAphead);
			ociexecute($stmtAphead, OCI_DEFAULT);
			$nrowsAphead = ocifetchstatement($stmtAphead, $resultAphead,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

			if ($nrowsAphead > 0) {
				$objPHPExcel    =   new Spreadsheet();

				//$objPHPExcel->setActiveSheetIndex(0);
				//NAME WORKSHEET
				$objPHPExcel->getActiveSheet()->setTitle("Sheet");

				$objPHPExcel->getActiveSheet()
					->getPageSetup()
					->setOrientation(PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

				$objPHPExcel->getActiveSheet()
					->getPageSetup()
					->setPaperSize(PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

				//$objPHPExcel->getActiveSheet()->SetCellValue('A12', 'ROW1');
				//$objPHPExcel->getActiveSheet()->SetCellValue('B12', 'ROW2');
				$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'AP_NO');
				$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'OP_NO');
				$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'AP_DT');
				$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ORDER_DT');
				$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'QUOTATION_DAYS');

				$rowCount = 2;
				foreach($resultAphead as $result){
					$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result['AP_NO']);
					$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result['OP_NO']);
					$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result['AP_DT']);
					$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result['ORDER_DT']);
					$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $result['QUOTATION_DAYS']);
					$rowCount++;
				}
				$writer = new Xlsx($objPHPExcel);
				$fileName = "/apHead.xlsx";
				$uploc = public_path("powerbi").$fileName;
				echo $uploc;
				$writer->save($uploc);
			}
		@endphp
	</div>

@endsection
