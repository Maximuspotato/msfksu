<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
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

            if (Storage::exists($filename.'_'.time().'.'.$extension)) {
                return back()->with('failed', 'File already exists');
            }else{
                // Store the file in the 'uploads' directory on the 'public' disk
                $filePath = $request->file('file')->storeAs('uploads',$pickername.'_'.$filename.'_'.time().'.'.$extension, 'public');
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
            $cellFrom = 'Q'.$rowCount;
            $cellTo = 'R'.$rowCount;
            $cellPlt = 'S'.$rowCount;
            $cellLyr = 'T'.$rowCount;
            $cellDims = 'U'.$rowCount;
            $cellRmk = 'V'.$rowCount;
            $worksheet->setCellValue($cellFrom,$request->from);
            $worksheet->setCellValue($cellTo,$request->to);
            $worksheet->setCellValue($cellPlt,$request->plt);
            $worksheet->setCellValue($cellLyr,$request->lyr);
            $worksheet->setCellValue($cellDims,$request->dims);
            $worksheet->setCellValue($cellRmk,$request->rmk);
            $writer = new Xlsx($spreadsheet);
            $writer->save($file_path);
        } else if($request->pg == 'back') {
            $rowCount -= 1;
        } else if($request->pg == 'confirm'){
            include_once(app_path() . '/outils/functions.php');
            $c = db_connect();
            $rowCount += 1;
            $cellFrom = 'Q'.$rowCount;
            $cellTo = 'R'.$rowCount;
            $cellPlt = 'S'.$rowCount;
            $cellLyr = 'T'.$rowCount;
            $cellDims = 'U'.$rowCount;
            $cellRmk = 'V'.$rowCount;
            $worksheet->setCellValue($cellFrom,$request->from);
            $worksheet->setCellValue($cellTo,$request->to);
            $worksheet->setCellValue($cellPlt,$request->plt);
            $worksheet->setCellValue($cellLyr,$request->lyr);
            $worksheet->setCellValue($cellDims,$request->dims);
            $worksheet->setCellValue($cellRmk,$request->rmk);
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
        } else {
            $rowCount--;
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
