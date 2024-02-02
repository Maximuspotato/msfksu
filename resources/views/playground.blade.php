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
            use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

            include(app_path() . '/outils/functions.php');

            function ap(){
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
                        ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                    $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setPaperSize(PageSetup::PAPERSIZE_A4);

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
                    $objPHPExcel->disconnectWorksheets();
                    unset($objPHPExcel);
                }
            }
            Queue::push(ap());

            function aphead(){
                $c = db_connect();
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
                        ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                    $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setPaperSize(PageSetup::PAPERSIZE_A4);

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
                    $writer->save($uploc);
                    $objPHPExcel->disconnectWorksheets();
                    unset($objPHPExcel);
                }
            }
            Queue::push(aphead());
            
            function art(){
                $c = db_connect();
                $queryArt = " SELECT ART_CODE ARTICLE, ART_ZZ_TYPE ARTICLE_TYPE FROM XN_ART ORDER BY ART_CODE ASC ";
                $stmtArt = oci_parse($c, $queryArt);
                ociexecute($stmtArt, OCI_DEFAULT);
                $nrowsArt = ocifetchstatement($stmtArt, $resultArt,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

                if ($nrowsArt > 0) {
                    $objPHPExcel    =   new Spreadsheet();

                    //$objPHPExcel->setActiveSheetIndex(0);
                    //NAME WORKSHEET
                    $objPHPExcel->getActiveSheet()->setTitle("Sheet");

                    $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                    $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setPaperSize(PageSetup::PAPERSIZE_A4);


                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ARTICLE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ARTICLE_TYPE');

                    $rowCount = 2;
                    foreach($resultArt as $result){
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result['ARTICLE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result['ARTICLE_TYPE']);
                        $rowCount++;
                    }
                    $writer = new Xlsx($objPHPExcel);
                    $fileName = "/art.xlsx";
                    $uploc = public_path("powerbi").$fileName;
                    $writer->save($uploc);
                    $objPHPExcel->disconnectWorksheets();
                    unset($objPHPExcel);
                }
            }
            Queue::push(art());

            function po(){
                $c = db_connect();
                $queryPo = " SELECT CFL_CFT_NO_CMDE PO_NO, CFL_ART_CODE ARTICLE,
                ROUND(SUM(CASE
                WHEN CFT_DEV_CODE = 'USD' THEN CFL_MT_HT_LIGNE
                WHEN CFT_DEV_CODE = 'KES' THEN
                CASE
                WHEN TRUNC(CFT_DT_CMDE,'MM') = TRUNC(SYSDATE,'MM') THEN CFL_MT_HT_LIGNE * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND ROWNUM = 1 AND DTX_DT_DEB = (SELECT MAX(DTX_DT_DEB)  FROM XN_DEVISE_TAUX  WHERE DTX_DEV_CODE = 'USD'))
                ELSE CASE
                WHEN TRUNC(SYSDATE,'MM') > (SELECT DTX_DT_DEB FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_FIN IS NULL) THEN CFL_MT_HT_LIGNE * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND ROWNUM = 1 AND DTX_DT_DEB = (SELECT MAX(DTX_DT_DEB)  FROM XN_DEVISE_TAUX  WHERE DTX_DEV_CODE = 'USD'))
                ELSE CFL_MT_HT_LIGNE * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = TRUNC(CFT_DT_CMDE, 'MM') AND 
                DTX_DT_FIN = LAST_DAY(CFT_DT_CMDE))
                END
                END
                WHEN CFT_DEV_CODE = 'EUR' THEN
                CASE
                WHEN TRUNC(CFT_DT_CMDE,'MM') = TRUNC(SYSDATE,'MM') THEN (CFL_MT_HT_LIGNE / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND ROWNUM = 1 AND DTX_DT_DEB = (SELECT MAX(DTX_DT_DEB) FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR'))) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND ROWNUM = 1 AND DTX_DT_DEB = (SELECT MAX(DTX_DT_DEB)  FROM XN_DEVISE_TAUX  WHERE DTX_DEV_CODE = 'USD'))
                ELSE CASE
                WHEN TRUNC(SYSDATE,'MM') > (SELECT DTX_DT_DEB FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND DTX_DT_FIN IS NULL) THEN (CFL_MT_HT_LIGNE / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND ROWNUM = 1 AND DTX_DT_DEB = (SELECT MAX(DTX_DT_DEB) FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR'))) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND ROWNUM = 1 AND DTX_DT_DEB = (SELECT MAX(DTX_DT_DEB)  FROM XN_DEVISE_TAUX  WHERE DTX_DEV_CODE = 'USD'))
                ELSE (CFL_MT_HT_LIGNE / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND DTX_DT_DEB = TRUNC(CFT_DT_CMDE, 'MM') AND 
                DTX_DT_FIN = LAST_DAY(CFT_DT_CMDE))) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = TRUNC(CFT_DT_CMDE, 'MM') AND 
                DTX_DT_FIN = LAST_DAY(CFT_DT_CMDE))
                END
                END
                END), 2) TOTAL_PRICE, CFT_DT_CMDE PO_DT, FOU_NOM SUPPLIER
                FROM XN_CMDE_FOUR_LIGNE, XN_CMDE_FOUR_TETE, XN_FOUR
                WHERE CFL_INDEX = 'W'
                AND CFT_NO_CMDE = CFL_CFT_NO_CMDE
                AND FOU_CODE = CFT_FOU_CODE
                GROUP BY CFL_CFT_NO_CMDE, CFL_ART_CODE, CFL_MT_HT_LIGNE, CFT_DEV_CODE, CFT_DT_CMDE, FOU_NOM
                ORDER BY CFL_ART_CODE ASC ";
                $stmtPo = oci_parse($c, $queryPo);
                ociexecute($stmtPo, OCI_DEFAULT);
                $nrowsPo = ocifetchstatement($stmtPo, $resultPo,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

                if ($nrowsPo > 0) {
                    $objPHPExcel    =   new Spreadsheet();

                    //$objPHPExcel->setActiveSheetIndex(0);
                    //NAME WORKSHEET
                    $objPHPExcel->getActiveSheet()->setTitle("Sheet");

                    $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                    $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setPaperSize(PageSetup::PAPERSIZE_A4);


                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'PO_NO');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ARTICLE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'TOTAL_PRICE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PO_DT');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'SUPPLIER');

                    $rowCount = 2;
                    foreach($resultPo as $result){
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result['PO_NO']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result['ARTICLE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result['TOTAL_PRICE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result['PO_DT']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $result['SUPPLIER']);
                        $rowCount++;
                    }
                    $writer = new Xlsx($objPHPExcel);
                    $fileName = "/po.xlsx";
                    $uploc = public_path("powerbi").$fileName;
                    $writer->save($uploc);
                    $objPHPExcel->disconnectWorksheets();
                    unset($objPHPExcel);
                }
            }
            Queue::push(po());
		@endphp
	</div>

@endsection
