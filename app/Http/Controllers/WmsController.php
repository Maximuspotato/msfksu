<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
        //dd($request->filepath);
        $file_path = $request->filepath;
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        $rowCount = $request->rowCount;
        if ($request->pg == 'next') {
            $rowCount += 1;
        } else if($request->pg == 'back') {
            $rowCount -= 1;
        } else if($request->pg == 'confirm'){
            $allfiles = Storage::disk('public')->allFiles('uploads');
            $filenameOnly = array();
            foreach ($allfiles as $onefile) {
                array_push($filenameOnly,substr($onefile,8));
            }
            //dd($filenameOnly);
            return view('wms')->with(['active' => 'wms', 'filenames' => $filenameOnly]);
        }
        return view('picking')->with(['active' => 'wms', 'rows' => $rows, 'rowCount' => $rowCount, 'header' => 0, 'filepath' => $file_path]);
    }
}
