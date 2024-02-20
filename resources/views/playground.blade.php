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
                    unset($writer, $objPHPExcel);
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
                    unset($writer, $objPHPExcel);
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
                    unset($writer, $objPHPExcel);
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
                    unset($writer, $objPHPExcel);
                }
            }
            Queue::push(po());

            function op(){
                $c = db_connect();
                $queryOp = " SELECT CCT_NO OP_NO, CCT_DT_CMDE ORDER_DT, CCT_DT_VERSION END_VAL_OFF, CCT_DT_ED_PREP CUST_VAL_DT, CCT_DT_CONFIRME DT_CONF, FCT_DT INV_DT,
                CLI_CODE DISPATCH_CODE, CCT_CHA_CODE PROJECT_CODE, MTR_LIB TRANS_MODE, PAY_NOM COUNTRY,
                CASE
                WHEN CCT_DT_VERSION IS NULL THEN 0
                WHEN CCT_DT_VERSION IS NOT NULL THEN CASE
                WHEN (CCT_DT_VERSION-14) - CCT_DT_CMDE < 0 THEN 0
                ELSE (CCT_DT_VERSION-14) - CCT_DT_CMDE
                END
                END ORC_TIME,
                CASE
                WHEN (CCT_DT_VERSION IS NULL OR CCT_DT_ED_PREP IS NULL) THEN 0
                WHEN (CCT_DT_VERSION IS NOT NULL AND CCT_DT_ED_PREP IS NOT NULL) THEN CASE
                WHEN CCT_DT_ED_PREP - (CCT_DT_VERSION-14) < 0 THEN 0
                ELSE CCT_DT_ED_PREP - (CCT_DT_VERSION-14)
                END
                END MISSION_TIME,
                CASE
                WHEN (CCT_DT_ED_PREP IS NULL OR CCT_DT_ED_PREP - CCT_DT_CMDE < 0) THEN 0
                ELSE CCT_DT_ED_PREP - CCT_DT_CMDE
                END CONFIRM_TIME,
                CASE
                WHEN FCT_DT IS NULL THEN 0 ELSE FCT_DT - CCT_DT_CMDE
                END RTS_TIME
                FROM XN_CMDE_CLI_TETE, XN_MODE_TRANSP, XN_CLI, XN_PAYS, XN_FAC_CLI_TETE
                WHERE MTR_CODE = CCT_MTR_CODE
                AND CLI_CODE = CCT_CLI_CODE_DISP
                AND PAY_CODE = CLI_PAY_CODE
                AND FCT_CCT_NO(+) = CCT_NO
                AND CCT_TYD_CODE <> 'CX'
                ORDER BY CCT_NO DESC ";
                $stmtOp = oci_parse($c, $queryOp);
                ociexecute($stmtOp, OCI_DEFAULT);
                $nrowsOp = ocifetchstatement($stmtOp, $resultOp,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

                if ($nrowsOp > 0) {
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


                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'OP_NO');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'ORDER_DT');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'END_VAL_OFF');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'CUST_VAL_DT');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'DT_CONF');
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'INV_DT');
                    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'DISPATCH_CODE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'PROJECT_CODE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'TRANS_MODE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'COUNTRY');
                    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'ORC_TIME');
                    $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'MISSION_TIME');
                    $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'CONFIRM_TIME');
                    $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'RTS_TIME');

                    $rowCount = 2;
                    foreach($resultOp as $result){
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result['OP_NO']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result['ORDER_DT']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result['END_VAL_OFF']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result['CUST_VAL_DT']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $result['DT_CONF']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $result['INV_DT']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $result['DISPATCH_CODE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $result['PROJECT_CODE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $result['TRANS_MODE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $result['COUNTRY']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $result['ORC_TIME']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $result['MISSION_TIME']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $result['CONFIRM_TIME']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $result['RTS_TIME']);
                        $rowCount++;
                    }
                    $writer = new Xlsx($objPHPExcel);
                    $fileName = "/op.xlsx";
                    $uploc = public_path("powerbi").$fileName;
                    $writer->save($uploc);
                    $objPHPExcel->disconnectWorksheets();
                    unset($writer, $objPHPExcel);
                }
            }
            Queue::push(op());

            function tr(){
                $c = db_connect();
                $queryTr = " SELECT DTR_NO TR_NO, DTR_DT_CREAT_DOS DT_CREATE, DTR_ZZ_GO_AHEAD DT_GO, DTR_ZZ_DT_ETD DT_ETD, DTR_ZZ_DT_ETA DT_ETA, FCT_DT INV_DT,
                DTR_CLI_CODE_DISP DISPATCH, MTR_LIB TRANS_MODE, PAY_NOM COUNTRY,
                CASE
                WHEN FCT_DT IS NULL THEN 0
                ELSE FCT_DT - DTR_DT_CREAT_DOS
                END CONSOLDATION_TIME,
                CASE
                WHEN DTR_ZZ_GO_AHEAD IS NULL THEN 0
                ELSE DTR_ZZ_GO_AHEAD - DTR_DT_CREAT_DOS
                END GO_TIME,
                CASE
                WHEN (DTR_ZZ_GO_AHEAD IS NULL OR DTR_ZZ_DT_ETD IS NULL) THEN 0
                ELSE DTR_ZZ_DT_ETD - DTR_ZZ_GO_AHEAD
                END DEPATURE_TIME,
                CASE
                WHEN (DTR_ZZ_DT_ETA IS NULL OR DTR_ZZ_DT_ETD IS NULL) THEN 0
                ELSE DTR_ZZ_DT_ETA - DTR_ZZ_DT_ETD
                END TR_TIME
                FROM MS_DOSSIER_TRANSP, XN_MODE_TRANSP, XN_CLI, XN_PAYS, XN_FAC_CLI_TETE
                WHERE MTR_CODE = DTR_MTR_CODE
                AND CLI_CODE = DTR_CLI_CODE_DISP
                AND PAY_CODE = CLI_PAY_CODE
                AND DTR_INDEX <> 'S'
                AND FCT_CCT_REF_CMDE_CLI1(+) = TO_CHAR(DTR_NO)
                ORDER BY DTR_NO DESC ";
                $stmtTr = oci_parse($c, $queryTr);
                ociexecute($stmtTr, OCI_DEFAULT);
                $nrowsTr = ocifetchstatement($stmtTr, $resultTr,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

                if ($nrowsTr > 0) {
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


                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'TR_NO');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'DT_CREATE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'DT_GO');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'DT_ETD');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'DT_ETA');
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'INV_DT');
                    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'DISPATCH');
                    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'TRANS_MODE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'COUNTRY');
                    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'CONSOLDATION_TIME');
                    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'GO_TIME');
                    $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'DEPATURE_TIME');
                    $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'TR_TIME');

                    $rowCount = 2;
                    foreach($resultTr as $result){
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result['TR_NO']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result['DT_CREATE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result['DT_GO']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result['DT_ETD']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $result['DT_ETA']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $result['INV_DT']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $result['DISPATCH']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $result['TRANS_MODE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $result['COUNTRY']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $result['CONSOLDATION_TIME']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $result['GO_TIME']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $result['DEPATURE_TIME']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $result['TR_TIME']);
                        $rowCount++;
                    }
                    $writer = new Xlsx($objPHPExcel);
                    $fileName = "/tr.xlsx";
                    $uploc = public_path("powerbi").$fileName;
                    $writer->save($uploc);
                    $objPHPExcel->disconnectWorksheets();
                    unset($writer, $objPHPExcel);
                }
            }
            Queue::push(tr());

            function fin(){
                $c = db_connect();
                $queryFin = " SELECT 'MSFS', ROUND(CASE
                WHEN TRUNC(FCT_DT,'MM') = TRUNC(SYSDATE,'MM') THEN (FCT_MT_BASE_REMISE / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND ROWNUM = 1 AND DTX_DT_DEB = (SELECT MAX(DTX_DT_DEB) FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR'))) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND ROWNUM = 1 AND DTX_DT_DEB = (SELECT MAX(DTX_DT_DEB)  FROM XN_DEVISE_TAUX  WHERE DTX_DEV_CODE = 'USD'))
                ELSE CASE
                WHEN TRUNC(FCT_DT,'MM') < TRUNC(SYSDATE,'MM') THEN (FCT_MT_BASE_REMISE / (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'EUR' AND DTX_DT_DEB = FCT_DT)) * (SELECT DTX_TX_ACH FROM XN_DEVISE_TAUX WHERE DTX_DEV_CODE = 'USD' AND DTX_DT_DEB = FCT_DT)
                END
                END, 2) FCT_MT_BASE_REMISE, FCT_DT, PAY_NOM, CLI_SFC_CODE, FCT_DT - CCT_DT_CONFIRME
                FROM XN_FAC_CLI_TETE_NBO, XN_PAYS, XN_CLI, XN_CMDE_CLI_TETE
                WHERE FCT_DT > '31-DEC-22'
                AND PAY_CODE = CLI_PAY_CODE
                AND CLI_CODE = FCT_CLI_CODE_FAC
                AND CCT_NO(+) = FCT_CCT_NO
                UNION
                SELECT 'MSFSK', FCT_MT_BASE_REMISE, FCT_DT, PAY_NOM, CLI_SFC_CODE, FCT_DT - CCT_DT_CONFIRME
                FROM XN_FAC_CLI_TETE, XN_PAYS, XN_CLI, XN_CMDE_CLI_TETE
                WHERE FCT_DT > '31-DEC-22'
                AND PAY_CODE = CLI_PAY_CODE
                AND CLI_CODE = FCT_CLI_CODE_FAC
                AND CCT_NO(+) = FCT_CCT_NO
                AND CCT_NO <> 13524
                AND FCT_DEV_CODE <> 'KES' ";
                $stmtFin = oci_parse($c, $queryFin);
                ociexecute($stmtFin, OCI_DEFAULT);
                $nrowsFin = ocifetchstatement($stmtFin, $resultFin,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

                if ($nrowsFin > 0) {
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


                    $objPHPExcel->getActiveSheet()->SetCellValue('A1', "'MSFS'");
                    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'FCT_MT_BASE_REMISE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'FCT_DT');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'PAY_NOM');
                    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'CLI_SFC_CODE');
                    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'FCT_DT-CCT_DT_CONFIRME');

                    $rowCount = 2;
                    foreach($resultFin as $result){
                        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result["'MSFS'"]);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result['FCT_MT_BASE_REMISE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result['FCT_DT']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result['PAY_NOM']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $result['CLI_SFC_CODE']);
                        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $result['FCT_DT-CCT_DT_CONFIRME']);
                        $rowCount++;
                    }
                    $writer = new Xlsx($objPHPExcel);
                    $fileName = "/fin.xlsx";
                    $uploc = public_path("powerbi").$fileName;
                    $writer->save($uploc);
                    $objPHPExcel->disconnectWorksheets();
                    unset($writer, $objPHPExcel);
                }
            }
            Queue::push(fin());
		@endphp
	</div>

@endsection
