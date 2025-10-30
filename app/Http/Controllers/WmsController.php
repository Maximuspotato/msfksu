<?php

namespace App\Http\Controllers;

use App\Mail\PackerEmail;
use App\Mail\PickerEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use Maatwebsite\Excel\Facades\Excel;
//use PhpOffice\PhpSpreadsheet\IOFactory;

class WmsController extends Controller
{
    public function uploadPick(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        // Check if the file is valid
        if ($request->file('file')->isValid()) {
            $fullfilename = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($fullfilename, PATHINFO_FILENAME);
            $extension = pathinfo($fullfilename, PATHINFO_EXTENSION);

            $pickername = $request->picker;

            if (Storage::exists($filename.'.'.$extension)) {
                return back()->with('failed', 'File already exists');
            }else{
                $emailname = str_replace(" ",".",$pickername);
                $email = $emailname.'@BRUSSELS.MSF.ORG';
                Mail::to($email)->send(new PickerEmail(['name' => $pickername]));
                // Store the file in the 'uploads' directory on the 'public' disk
                $filePath = $request->file('file')->storeAs('uploads',$pickername.'_'.$filename.'.'.$extension, 'public');
                // Return success response
                return back()->with('success', 'File uploaded successfully')->with('file', $filePath);
            }
        }
        // Return error response
        return back()->with('error', 'File upload failed');
    }

    public function delfile(Request $request){
        $file_path = public_path('storage/uploads/'.$request->fl);
        File::delete($file_path);
        return back()->with('success', 'File deleted successfully');
    }

    public function pickfile(Request $request){
        $file_path = public_path('storage/uploads/'.$request->fl);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        return view('picking')->with(['active' => 'wms', 'rows' => $rows, 'rowCount' => 1, 'header' => 0, 'filepath' => $file_path]);
    }

    public function updatePick(Request $request){
        //fetch excel data
        $file_path = $request->filepath;
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rowCount = $request->rowCount;
        if ($request->pg == 'next') {
            //update data
            $rowCount += 1;
            $cellFrom = 'M'.$rowCount;
            $cellTo = 'N'.$rowCount;
            $cellPlt = 'O'.$rowCount;
            $cellRmk = 'P'.$rowCount;
            $cellWeight = 'K'.$rowCount;
            $worksheet->setCellValue($cellFrom,$request->from);
            $worksheet->setCellValue($cellTo,$request->to);
            $worksheet->setCellValue($cellPlt,$request->plt);
            $worksheet->setCellValue($cellRmk,$request->rmk);
            $worksheet->setCellValue($cellWeight,$request->wgt);
            $writer = new Xlsx($spreadsheet);
            $writer->save($file_path);
        } else if($request->pg == 'back') {
            $rowCount -= 1;
        } else if($request->pg == 'jump') {
            $rowCount = $request->jmp;
        }else if($request->pg == 'confirm'){
            include_once(app_path() . '/outils/functions.php');
            $c = db_connect();
            $rowCount += 1;
           $cellFrom = 'M'.$rowCount;
            $cellTo = 'N'.$rowCount;
            $cellPlt = 'O'.$rowCount;
            $cellRmk = 'P'.$rowCount;
            $cellWeight = 'K'.$rowCount;
            $worksheet->setCellValue($cellFrom,$request->from);
            $worksheet->setCellValue($cellTo,$request->to);
            $worksheet->setCellValue($cellPlt,$request->plt);
            $worksheet->setCellValue($cellRmk,$request->rmk);
            $worksheet->setCellValue($cellWeight,$request->wgt);
            $writer = new Xlsx($spreadsheet);
            $writer->save($file_path);

            $oldPath = $file_path;
            $typePath = substr($oldPath, 0, -5);
            $newPath = $typePath."_picked.xlsx";
            File::move($oldPath,$newPath);

            $allfiles = Storage::disk('public')->allFiles('uploads');
            $filenameOnly = array();
            foreach ($allfiles as $onefile) {
                array_push($filenameOnly,substr($onefile,8));
            }
            $queryPacker = " SELECT EAP_PKNO, EAP_PACKER, EAP_PACKED, EAP_INT FROM EXT_AUTO_PACK@msfss ";
            $stmtPacker = oci_parse($c, $queryPacker);
            ociexecute($stmtPacker, OCI_DEFAULT);
            ocifetchstatement($stmtPacker, $queryPackers,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
            //dd($filenameOnly);
            return view('wms')->with(['active' => 'wms', 'filenames' => $filenameOnly, 'queryPackers' => $queryPackers]);
        }
        $rows = $worksheet->toArray();
        return view('picking')->with(['active' => 'wms', 'rows' => $rows, 'rowCount' => $rowCount, 'header' => 0, 'filepath' => $file_path]);
    }

    public function choosePacker(Request $request){
        include_once(app_path() . '/outils/functions.php');
        $c = db_connect();
        $query = "INSERT INTO EXT_AUTO_PACK@msfss (EAP_PKNO, EAP_PACKER)
		VALUES (:pk_no, :packer) ";
		$stmt = oci_parse($c, $query);
        $pk_no = $request->pk_no;
        $packer = $request->packer;
		ocibindbyname($stmt, ":pk_no", $pk_no);
		ocibindbyname($stmt, ":packer", $packer);
		oci_execute($stmt, OCI_DEFAULT);
		oci_commit($c);

        $emailname = str_replace(" ",".",$packer);
        $email = $emailname.'@BRUSSELS.MSF.ORG';
        Mail::to($email)->send(new PackerEmail(['name' => $packer]));

        return back();
    }

    public function delPacker(Request $request){
        include_once(app_path() . '/outils/functions.php');
        $c = db_connect();
        $query = " DELETE FROM EXT_AUTO_PACK@msfss WHERE EAP_PKNO = :pkno ";
		$stmt = oci_parse($c, $query);
        $pkno = $request->pkno;
		ocibindbyname($stmt, ":pkno", $pkno);
		oci_execute($stmt, OCI_DEFAULT);
		oci_commit($c);

        $queryLigne = " DELETE FROM EXT_AUTO_PACKER_LIGNE@msfss WHERE APL_PK = :pkno ";
		$stmtLigne = oci_parse($c, $queryLigne);
		ocibindbyname($stmtLigne, ":pkno", $pkno);
		oci_execute($stmtLigne, OCI_DEFAULT);
		oci_commit($c);

        return back();
    }

    public function packing(Request $request){
        $rowCount = 0;
        include_once(app_path() . '/outils/functions.php');
        $c = db_connect();
        $query = " SELECT PCL_PCT_NO, PCL_ART_CODE, PCL_DES1, PCL_QTE_LIV, PCL_NO_SERIE_LOT, PCL_DT_PEREMPTION, PCC_NO_GROUPAGE, PCC_NO_COLIS_FIN
        FROM MS_PACK_CLI_LIGNE@msfss, MS_PACK_CLI_COLIS@msfss
        WHERE PCL_PCT_NO = :pkno
        AND PCC_PCT_NO = PCL_PCT_NO
        AND PCL_NO_COLIS = PCC_NO_REGROUPEMENT ";
		$stmt = oci_parse($c, $query);
        $pkno = $request->pkno;
		ocibindbyname($stmt, ":pkno", $pkno);
		oci_execute($stmt, OCI_DEFAULT);
		ocifetchstatement($stmt, $query_results,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

        $queryPack = " SELECT APL_ROW, APL_PK, APL_RMK
        FROM EXT_AUTO_PACKER_LIGNE@msfss
        WHERE APL_PK = :pkno
        AND APL_ROW = :rowCount ";
		$stmtPack = oci_parse($c, $queryPack);
		ocibindbyname($stmtPack, ":pkno", $pkno);
        ocibindbyname($stmtPack, ":rowCount", $rowCount);
		oci_execute($stmtPack, OCI_DEFAULT);
		ocifetchstatement($stmtPack, $query_packs,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

        return view('packing')->with(['active' => 'wms', 'rows' => $query_results, 'rmks' => $query_packs, 'rowCount' => $rowCount]);
    }

    public function updatePack (Request $request){
        include_once(app_path() . '/outils/functions.php');
        $c = db_connect();
        $queryRmk = " MERGE INTO EXT_AUTO_PACKER_LIGNE@msfss TRGT
        USING (SELECT :APL_ROW APL_ROW, :APL_PK APL_PK, :APL_RMK APL_RMK FROM DUAL) SRC
        ON (TRGT.APL_ROW = SRC.APL_ROW AND TRGT.APL_PK = SRC.APL_PK)
        WHEN MATCHED THEN
        UPDATE SET
        TRGT.APL_RMK = SRC.APL_RMK
        WHEN NOT MATCHED THEN
        INSERT (APL_ROW, APL_PK, APL_RMK)
        VALUES (SRC.APL_ROW, SRC.APL_PK, SRC.APL_RMK) ";
		$stmtRmk = oci_parse($c, $queryRmk);
        $rowCount = $request->rowCount;
        $pkno = $request->pkno;
        $rmk = $request->rmk;
        ocibindbyname($stmtRmk, ":APL_ROW", $rowCount);
		ocibindbyname($stmtRmk, ":APL_PK", $pkno);
        ocibindbyname($stmtRmk, ":APL_RMK", $rmk);
		oci_execute($stmtRmk, OCI_DEFAULT);
		oci_commit($c);

        if ($request->pg == 'next') {
            $rowCount++;
        } else if ($request->pg == 'back') {
            $rowCount--;
        } else if ($request->pg == 'jump') {
            $rowCount = $request->jmp-1;
        }
        
        $query = " SELECT PCL_PCT_NO, PCL_ART_CODE, PCL_DES1, PCL_QTE_LIV, PCL_NO_SERIE_LOT, PCL_DT_PEREMPTION, PCC_NO_GROUPAGE, PCC_NO_COLIS_FIN
        FROM MS_PACK_CLI_LIGNE@msfss, MS_PACK_CLI_COLIS@msfss
        WHERE PCL_PCT_NO = :pkno
        AND PCC_PCT_NO = PCL_PCT_NO
        AND PCL_NO_COLIS = PCC_NO_REGROUPEMENT ";
		$stmt = oci_parse($c, $query);
        $pkno = $request->pkno;
		ocibindbyname($stmt, ":pkno", $pkno);
		oci_execute($stmt, OCI_DEFAULT);
		ocifetchstatement($stmt, $query_results,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

        $queryPack = " SELECT APL_ROW, APL_PK, APL_RMK
        FROM EXT_AUTO_PACKER_LIGNE@msfss
        WHERE APL_PK = :pkno
        AND APL_ROW = :rowCount ";
		$stmtPack = oci_parse($c, $queryPack);
		ocibindbyname($stmtPack, ":pkno", $pkno);
        ocibindbyname($stmtPack, ":rowCount", $rowCount);
		oci_execute($stmtPack, OCI_DEFAULT);
		ocifetchstatement($stmtPack, $query_packs,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

        if ($request->pg == 'confirm') {
            $queryCon = " UPDATE EXT_AUTO_PACK@msfss SET EAP_PACKED = 'YES' WHERE EAP_PKNO = :pkno ";
		$stmtCon = oci_parse($c, $queryCon);
		ocibindbyname($stmtCon, ":pkno", $pkno);
		oci_execute($stmtCon, OCI_DEFAULT);
		oci_commit($c);

            $query = " SELECT PCT_NO FROM MS_PACK_CLI_TETE@msfss WHERE PCT_DEP_CODE_CMDE = 'NBO' AND PCT_INDEX <> 'Z' ";
        $stmt = oci_parse($c, $query);
        ociexecute($stmt, OCI_DEFAULT);
        ocifetchstatement($stmt, $query_results,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

        $queryPacker = " SELECT EAP_PKNO, EAP_PACKER, EAP_PACKED, EAP_INT FROM EXT_AUTO_PACK@msfss ";
        $stmtPacker = oci_parse($c, $queryPacker);
        ociexecute($stmtPacker, OCI_DEFAULT);
        ocifetchstatement($stmtPacker, $queryPackers,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

        $allfiles = Storage::disk('public')->allFiles('uploads');
        $filenameOnly = array();
        foreach ($allfiles as $onefile) {
            array_push($filenameOnly,substr($onefile,8));
        }
        //dd($filenameOnly);
        return view('wms')->with([
            'active' => 'wms',
            'filenames' => $filenameOnly,
            'query_results' => $query_results,
            'queryPackers' => $queryPackers]);
        }

        return view('packing')->with(['active' => 'wms', 'rows' => $query_results, 'rmks' => $query_packs, 'rowCount' => $rowCount]);

        //return back();
    }

    public function intPack (Request $request){
        include_once(app_path() . '/outils/functions.php');
        $c = db_connect();

        $query = " SELECT PCC_PCT_NO FROM MS_PACK_CLI_COLIS@msfss WHERE PCC_PCT_NO = :pctno ";
        $stmt = oci_parse($c, $query);
        $pctno = $request->pkno;
        ocibindbyname($stmt, ":pctno", $pctno);
        ociexecute($stmt, OCI_DEFAULT);
        $nrows = ocifetchstatement($stmt, $query_results,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

        if ($nrows == 0) {
            return back()->with('failed', 'Parcel does not exist');
        } else {
            $allfiles = Storage::disk('public')->allFiles('uploads');
            $filenameOnly = array();
            foreach ($allfiles as $onefile) {
                array_push($filenameOnly,substr($onefile,8));
            }

            return view('integratepk')->with(['active' => 'wms', 'pctno' => $pctno, 'filenames' => $filenameOnly]);
        }
        

    }

    public function updpick(Request $request){
        include_once(app_path() . '/outils/functions.php');
        $c = db_connect();

        $file_path = public_path('storage/uploads/'.$request->fl);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $querySeq = "SELECT XNSEQ_BCE.NEXTVAL SEQ FROM DUAL@msfst ";
        $stmtSeq = oci_parse($c, $querySeq);
        ociexecute($stmtSeq, OCI_DEFAULT);
        ocifetchstatement($stmtSeq, $query_seqs,"0","-1",OCI_FETCHSTATEMENT_BY_ROW); 
        //dd($query_seqs[0]['SEQ']); 
        
        $i = 0;
        foreach ($rows as $row) {
            if ($i > 0) {
                $querySem = "SELECT SEM_BFT_NO_BL, SEM_ART_CODE,SEM_NO_SEQ FROM XN_STOCK_EMPLAC@msfst WHERE SEM_NO_SEQ = :seq AND SEM_QTE_STK > 0 ";
                $stmtSem = oci_parse($c, $querySem);
                //dd($row[1]);
                ocibindbyname($stmtSem, ":seq", $row[1]);
                ociexecute($stmtSem, OCI_DEFAULT);
                ocifetchstatement($stmtSem, $query_sems,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

                if ($query_sems) {
                    //dd($query_sems);
                    $queryRc = "SELECT BFL_COND_ACHAT
                    FROM XN_BL_FOUR_LIGNE@msfst WHERE BFL_BFT_NO_BL = :rc AND BFL_ART_CODE = :bfl_art ";
                    $stmtRc = oci_parse($c, $queryRc);
                    ocibindbyname($stmtRc, ":rc", $query_sems[0]['SEM_BFT_NO_BL']);
                    ocibindbyname($stmtRc, ":bfl_art", $query_sems[0]['SEM_ART_CODE']);
                    ociexecute($stmtRc, OCI_DEFAULT);
                    ocifetchstatement($stmtRc, $query_rcs,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
                    //dd($query_rcs[0]['BFL_COND_ACHAT']);

                    $queryLine = "SELECT BCL_NO_LIGNE
                    FROM XN_BL_CLI_LIGNE@msfst WHERE BCL_BCT_NO = :pick AND BCL_ART_CODE = :art ";
                    $stmtLine = oci_parse($c, $queryLine);
                    $pickno = (string)$request->pickno;
                    ocibindbyname($stmtLine, ":pick", $pickno);
                    ocibindbyname($stmtLine, ":art", $row[2]);
                    ociexecute($stmtLine, OCI_DEFAULT);
                    ocifetchstatement($stmtLine, $query_lines,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
                    //dd($query_lines[0]['BCL_NO_LIGNE']);

                    $queryCon = " INSERT INTO XN_BL_CLI_EMPLAC (BCE_QTE, BCE_QTE_PACK, BCE_COND,
                    BCE_SEM_NO_REEL, BCE_BCL_NO, BCE_BCL_DEP_SOC_CODE, BCE_BCL_DEP_CODE, BCE_BCL_NO_LIGNE, BCE_INDEX) 
                    VALUES(:BCE_QTE, :BCE_QTE_PACK, :BCE_COND,:BCE_SEM_NO_REEL, :BCE_BCL_NO,
                    :BCE_BCL_DEP_SOC_CODE, :BCE_BCL_DEP_CODE, :BCE_BCL_NO_LIGNE, 'Z') ";
                    $stmtCon = oci_parse($c, $queryCon);
                    $tsf = 'TSF';
                    $bru = 'BRU';
                    ocibindbyname($stmtCon, ":BCE_QTE", $row[8], -1, SQLT_INT);
                    ocibindbyname($stmtCon, ":BCE_QTE_PACK", $row[8], -1, SQLT_INT);
                    ocibindbyname($stmtCon, ":BCE_COND", $query_rcs[0]['BFL_COND_ACHAT'], -1, SQLT_CHR);
                    ocibindbyname($stmtCon, ":BCE_SEM_NO_REEL", $query_sems[0]['SEM_NO_SEQ'], -1, SQLT_INT);
                    ocibindbyname($stmtCon, ":BCE_BCL_NO", $pickno, -1, SQLT_CHR);
                    ocibindbyname($stmtCon, ":BCE_BCL_DEP_SOC_CODE", $tsf, -1, SQLT_CHR);
                    ocibindbyname($stmtCon, ":BCE_BCL_DEP_CODE", $bru, -1, SQLT_CHR);
                    ocibindbyname($stmtCon, ":BCE_BCL_NO_LIGNE", $query_lines[0]['BCL_NO_LIGNE'], -1, SQLT_INT);
                    if (!oci_execute($stmtCon, OCI_NO_AUTO_COMMIT)) {
                        $e = oci_error($stmtInsert);
                        dd("Insert failed: " . $e['message']);
                        oci_rollback($c);
                        exit;
                    }
                    //oci_commit($c);
                }
            }
            $i++;
            
        }
    }

    public function intpkg (Request $request){
        include_once(app_path() . '/outils/functions.php');
        $c = db_connect();

        $file_path = public_path('storage/uploads/'.$request->fl);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        //dd($weight);

        $i = 0;
        foreach ($rows as $row) {
            if ($i > 0) {
                $pctno = $request->pctno;

                $dims = str_replace(' ', '', $row[20]);
                $exdims = explode('/', $dims);
                $weight = $exdims[1];

                $exparas = explode('-', $exdims[0]);
                $vol = $exparas[0]*$exparas[1]*$exparas[2];

                $queryCon = " INSERT INTO MS_PACK_CLI_COLIS@msfss (PCC_PCT_NO, PCC_PCT_DEP_SOC_CODE, PCC_PCT_DEP_CODE, PCC_NO_GROUPAGE, PCC_NO_COLIS_FIN, PCC_PDS, PCC_VOL, PCC_LONG,
                PCC_LARG, PCC_HAUT, PCC_NO_REGROUPEMENT, PCC_NO_SSCC) VALUES(:PCC_PCT_NO, 'TSF', 'NBO', :PCC_NO_GROUPAGE, :PCC_NO_COLIS_FIN, :PCC_PDS, :PCC_VOL, 
                :PCC_LONG, :PCC_LARG, :PCC_HAUT, :PCC_NO_REGROUPEMENT, :PCC_NO_SSCC) ";
                $stmtCon = oci_parse($c, $queryCon);
                ocibindbyname($stmtCon, ":PCC_PCT_NO", $pctno);
                ocibindbyname($stmtCon, ":PCC_NO_GROUPAGE", $row[16]);
                ocibindbyname($stmtCon, ":PCC_NO_COLIS_FIN", $row[17]);
                ocibindbyname($stmtCon, ":PCC_PDS", $weight);
                ocibindbyname($stmtCon, ":PCC_VOL", $vol);
                ocibindbyname($stmtCon, ":PCC_LONG",  $exparas[0]);
                ocibindbyname($stmtCon, ":PCC_LARG", $exparas[1]);
                ocibindbyname($stmtCon, ":PCC_HAUT", $exparas[2]);
                ocibindbyname($stmtCon, ":PCC_NO_REGROUPEMENT", $row[16]);
                ocibindbyname($stmtCon, ":PCC_NO_SSCC", $row[19]);
                oci_execute($stmtCon, OCI_DEFAULT);
                oci_commit($c);

//                 $querySem = "SELECT SEM_NO_SEQ, SEM_BFT_NO_BL, SEM_BFT_DEP_SOC_CODE, SEM_BFT_DEP_CODE,
//                 SEM_ART_CODE FROM XN_STOCK_EMPLAC@msfss WHERE SEM_NO_SEQ = :seq ";
//                 $stmtSem = oci_parse($c, $querySem);
//                 ocibindbyname($stmtSem, ":seq", $row[1]);
//                 ociexecute($stmtSem, OCI_DEFAULT);
//                 ocifetchstatement($stmtSem, $query_sems,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
//                 if($query_sems[0]['SEM_NO_SEQ'] != ''){
//                     $queryRc = "SELECT BFL_NO_LIGNE, BFL_NO_ORDRE, BFL_MAJ_STK, BFL_DECOMPOSE, BFL_MT_HT_LIGNE,
//                     BFL_MT_HT, BFL_TVA_CODE, BFL_LONG, BFL_PX_NET_ON, BFL_LARG, BFL_ETAT_PART, BFL_DES1, BFL_TX_REM_LIG4,
//                     BFL_TX_REM_LIG3, BFL_TX_REM_LIG2, BFL_TX_REM_LIG1, BFL_SURF, BFL_PROMO, BFL_SERIE_LOT, BFL_COND_ACHAT
//                     FROM XN_BL_FOUR_LIGNE@msfss WHERE BFL_BFT_NO_BL = :rc AND BFL_ART_CODE = :bfl_art ";
//                     $stmtRc = oci_parse($c, $queryRc);
//                     ocibindbyname($stmtRc, ":rc", $query_sems[0]['SEM_BFT_NO_BL']);
//                     ocibindbyname($stmtRc, ":bfl_art", $query_sems[0]['SEM_ART_CODE']);
//                     ociexecute($stmtRc, OCI_DEFAULT);
//                     ocifetchstatement($stmtRc, $query_rcs,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);

//                     $queryOp = "SELECT CCL_PX_REVIENT, CCL_PX_VTE_NET, CCL_QTE_LIV,	CCL_QTE_LIV, CCL_PX_TARIF, CCL_PX_REMISE
//                     FROM XN_CMDE_CLI_LIGNE@msfss WHERE CCL_CCT_NO = :op AND CCL_ART_CODE = :ccl_art ";
//                     $stmtOp = oci_parse($c, $queryOp);
//                     $op = substr($pctno, 0, -4);
//                     ocibindbyname($stmtOp, ":op", $op);
//                     ocibindbyname($stmtOp, ":ccl_art", $query_sems[0]['SEM_ART_CODE']);
//                     ociexecute($stmtOp, OCI_DEFAULT);
//                     $nrows = ocifetchstatement($stmtOp, $query_ops,"0","-1",OCI_FETCHSTATEMENT_BY_ROW);
//                     $rev;
//                     $vte;
//                     $liv;
//                     $tarif;
//                     $rem;
//                     if ($nrows == 0 ) {
//                         $rev = 1;
//                         $vte = 0;
//                         $liv = 0;
//                         $tarif = 0;
//                         $rem = 0;
//                     }
//                     else{
//                         $rev = $query_ops[0]['CCL_PX_REVIENT'];
//                         $vte = $query_ops[0]['CCL_PX_VTE_NET'];
//                         $liv = $query_ops[0]['CCL_QTE_LIV'];
//                         $tarif = $query_ops[0]['CCL_PX_TARIF'];
//                         $rem = $query_ops[0]['CCL_PX_REMISE'];
//                     }
//                     $zero = 0;
//                     $one = 1;
//                     $pk = 'PK';
//                     $n = 'N';
//                     $four = 4;
//                     $x = 'X';
//                     $queryCon = " INSERT INTO MS_PACK_CLI_LIGNE@msfss (PCL_DEP_SOC_CODE,	PCL_DEP_CODE,	
//                     PCL_PCT_NO,	PCL_NO_LIGNE,	PCL_NO_ORDRE,	PCL_ART_CODE,	PCL_TX_COM2,	
//                     PCL_MAJ_STK,	PCL_DECOMPOSE,	PCL_TYD_CODE,	PCL_FLA_MT,	PCL_MT_HT_LIGNE,	
//                     PCL_MT_EHF,	PCL_TVA_CODE,	PCL_LONG,	PCL_PX_ACH_BASE,	PCL_PX_NET_ON,	PCL_PX_REVIENT,
//                     PCL_PX_VTE,	PCL_QTE_LIV,	PCL_QTE_A_LIV,	PCL_LARG,	PCL_INDEX,	PCL_ETAT_PART,	
//                     PCL_DES1,	PCL_CODE_ED_COM,	PCL_TX_REM4,	PCL_TX_COM,	PCL_TX_REM3,	PCL_TX_REM2,
//                     PCL_TX_REM1,	PCL_TX_DEV_ACH,	PCL_SURF,	PCL_PX_TARIF,	PCL_PX_REMISE,	PCL_PX_ACH_NEGO,
//                     PCL_PROMO,	PCL_PRET,	PCL_NO_POSTE,	PCL_FLA_QTE,	PCL_SERIE_LOT,	PCL_COND_VTE) 
//                     VALUES(:PCL_DEP_SOC_CODE,	:PCL_DEP_CODE,	:PCL_PCT_NO,	:PCL_NO_LIGNE,	:PCL_NO_ORDRE,
//                     :PCL_ART_CODE,	:PCL_TX_COM2,	:PCL_MAJ_STK,	:PCL_DECOMPOSE,	:PCL_TYD_CODE,	:PCL_FLA_MT,
//                     :PCL_MT_HT_LIGNE,	:PCL_MT_EHF,	:PCL_TVA_CODE,	:PCL_LONG,	:PCL_PX_ACH_BASE,
//                     :PCL_PX_NET_ON,	:PCL_PX_REVIENT,	:PCL_PX_VTE,	:PCL_QTE_LIV,	:PCL_QTE_A_LIV,	
//                     :PCL_LARG,	:PCL_INDEX,	:PCL_ETAT_PART,	:PCL_DES1,	:PCL_CODE_ED_COM,	:PCL_TX_REM4,	
//                     :PCL_TX_COM,	:PCL_TX_REM3,	:PCL_TX_REM2,	:PCL_TX_REM1,	:PCL_TX_DEV_ACH,
//                     :PCL_SURF,	:PCL_PX_TARIF,	:PCL_PX_REMISE,	:PCL_PX_ACH_NEGO,	:PCL_PROMO,	:PCL_PRET,	
//                     :PCL_NO_POSTE,	:PCL_FLA_QTE,	:PCL_SERIE_LOT,	:PCL_COND_VTE) ";
//                     $stmtCon = oci_parse($c, $queryCon);
//                     ocibindbyname($stmtCon, ":PCL_DEP_SOC_CODE", $query_sems[0]['SEM_BFT_DEP_SOC_CODE']);
//                     ocibindbyname($stmtCon, ":PCL_DEP_CODE", $query_sems[0]['SEM_BFT_DEP_CODE']);
//                     ocibindbyname($stmtCon, ":PCL_PCT_NO", $pctno);
//                     ocibindbyname($stmtCon, ":PCL_NO_LIGNE", $query_rcs[0]['BFL_NO_LIGNE']);
//                     ocibindbyname($stmtCon, ":PCL_NO_ORDRE", $query_rcs[0]['BFL_NO_ORDRE']);
//                     ocibindbyname($stmtCon, ":PCL_ART_CODE",  $query_sems[0]['SEM_ART_CODE']);
//                     ocibindbyname($stmtCon, ":PCL_TX_COM2", $zero);
//                     ocibindbyname($stmtCon, ":PCL_MAJ_STK", $query_rcs[0]['BFL_MAJ_STK']);
//                     ocibindbyname($stmtCon, ":PCL_DECOMPOSE", $query_rcs[0]['BFL_DECOMPOSE']);
//                     ocibindbyname($stmtCon, ":PCL_TYD_CODE", $pk);
//                     ocibindbyname($stmtCon, ":PCL_FLA_MT", $zero);
//                     ocibindbyname($stmtCon, ":PCL_MT_HT_LIGNE", $query_rcs[0]['BFL_MT_HT_LIGNE']);
//                     ocibindbyname($stmtCon, ":PCL_MT_EHF", $query_rcs[0]['BFL_MT_HT']);
//                     ocibindbyname($stmtCon, ":PCL_TVA_CODE", $query_rcs[0]['BFL_TVA_CODE']);
//                     ocibindbyname($stmtCon, ":PCL_LONG", $query_rcs[0]['BFL_LONG']);
//                     ocibindbyname($stmtCon, ":PCL_PX_ACH_BASE",  $zero);
//                     ocibindbyname($stmtCon, ":PCL_PX_NET_ON", $query_rcs[0]['BFL_PX_NET_ON']);
//                     ocibindbyname($stmtCon, ":PCL_PX_REVIENT", $rev);
//                     ocibindbyname($stmtCon, ":PCL_PX_VTE", $vte);
//                     ocibindbyname($stmtCon, ":PCL_QTE_LIV", $liv);
//                     ocibindbyname($stmtCon, ":PCL_QTE_A_LIV", $liv);
//                     ocibindbyname($stmtCon, ":PCL_LARG", $query_rcs[0]['BFL_LARG']);
//                     ocibindbyname($stmtCon, ":PCL_INDEX", $four);
//                     ocibindbyname($stmtCon, ":PCL_ETAT_PART", $query_rcs[0]['BFL_ETAT_PART']);
//                     ocibindbyname($stmtCon, ":PCL_DES1", $query_rcs[0]['BFL_DES1']);
//                     ocibindbyname($stmtCon, ":PCL_CODE_ED_COM",  $x);
//                     ocibindbyname($stmtCon, ":PCL_TX_REM4", $query_rcs[0]['BFL_TX_REM_LIG4']);
//                     ocibindbyname($stmtCon, ":PCL_TX_COM", $zero);
//                     ocibindbyname($stmtCon, ":PCL_TX_REM3", $query_rcs[0]['BFL_TX_REM_LIG3']);
//                     ocibindbyname($stmtCon, ":PCL_TX_REM2", $query_rcs[0]['BFL_TX_REM_LIG2']);
//                     ocibindbyname($stmtCon, ":PCL_TX_REM1", $query_rcs[0]['BFL_TX_REM_LIG1']);
//                     ocibindbyname($stmtCon, ":PCL_TX_DEV_ACH", $one);
//                     ocibindbyname($stmtCon, ":PCL_SURF", $query_rcs[0]['BFL_SURF']);
//                     ocibindbyname($stmtCon, ":PCL_PX_TARIF", $tarif);
//                     ocibindbyname($stmtCon, ":PCL_PX_REMISE", $rem);
//                     ocibindbyname($stmtCon, ":PCL_PX_ACH_NEGO",  $zero);
//                     ocibindbyname($stmtCon, ":PCL_PROMO", $zero);
//                     ocibindbyname($stmtCon, ":PCL_PRET", $n);
//                     ocibindbyname($stmtCon, ":PCL_NO_POSTE", $one);
//                     ocibindbyname($stmtCon, ":PCL_FLA_QTE", $zero);
//                     ocibindbyname($stmtCon, ":PCL_SERIE_LOT", $query_rcs[0]['BFL_SERIE_LOT']);
//                     ocibindbyname($stmtCon, ":PCL_COND_VTE", $query_rcs[0]['BFL_COND_ACHAT']);
//                     $paras = [$query_sems[0]['SEM_BFT_DEP_SOC_CODE'],
// $query_sems[0]['SEM_BFT_DEP_CODE'],
// $pctno,
// $query_rcs[0]['BFL_NO_LIGNE'],
// $query_rcs[0]['BFL_NO_ORDRE'],
// $query_sems[0]['SEM_ART_CODE'],
// $zero,
// $query_rcs[0]['BFL_MAJ_STK'],
// $query_rcs[0]['BFL_DECOMPOSE'],
// $pk,
// $zero,
// $query_rcs[0]['BFL_MT_HT_LIGNE'],
// $query_rcs[0]['BFL_MT_HT'],
// $query_rcs[0]['BFL_TVA_CODE'],
// $query_rcs[0]['BFL_LONG'],
// $zero,
// $query_rcs[0]['BFL_PX_NET_ON'],
// $rev,
// $vte,
// $liv,
// $liv,
// $query_rcs[0]['BFL_LARG'],
// $four,
// $query_rcs[0]['BFL_ETAT_PART'],
// $query_rcs[0]['BFL_DES1'],
// $x,
// $query_rcs[0]['BFL_TX_REM_LIG4'],
// $zero,
// $query_rcs[0]['BFL_TX_REM_LIG3'],
// $query_rcs[0]['BFL_TX_REM_LIG2'],
// $query_rcs[0]['BFL_TX_REM_LIG1'],
// $one,
// $query_rcs[0]['BFL_SURF'],
// $tarif,
// $rem,
// $zero,
// $zero,
// $n,
// $one,
// $zero,
// $query_rcs[0]['BFL_SERIE_LOT'],
// $query_rcs[0]['BFL_COND_ACHAT']];
// dd("PCL_PX_REVIENT: " . var_export($rev, true));
//                     oci_execute($stmtCon, OCI_DEFAULT);
//                     //oci_commit($c);
//                 }

            }
            $i++;
        }
        $pctno = $request->pctno;
        $queryCons = " UPDATE EXT_AUTO_PACK@msfss SET EAP_INT = 'YES' WHERE EAP_PKNO = :pkno ";
		$stmtCons = oci_parse($c, $queryCons);
		ocibindbyname($stmtCons, ":pkno", $pctno);
		oci_execute($stmtCons, OCI_DEFAULT);
		oci_commit($c);

        return back()->with('success', 'File integrated successfully');
    }
}
