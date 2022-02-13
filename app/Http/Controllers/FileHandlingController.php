<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class FileHandlingController extends Controller
{
   
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function loadSingleFileView(){
        return view('filehandle.add_single_file');    
    }

    /**
    * Save Single Image File
    * @return \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
    public function submitSingleFileUpload(Request $request){           
            $request->validate([
                'formFile' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
           if ($request->hasFile('formFile')) {
               $filehandle = $this->_singleFileUploads($request, 'formFile', 'public/asset');
               if (isset($filehandle['status']) && $filehandle['status']) {                    
                    $image_insert = Images::create(['name' => $filehandle['data']['filename'], 'user_id' =>Auth::user()->id]);                 
                    if($image_insert){ // Image insert
                        return response()->json([
                            'status' => true,
                            'data' => ['id' => $image_insert->id],
                            'message' => 'Image Inserted Successfully..!'
                        ]);
                    }else{ // Image not insert
                        return response()->json([
                            'status' => false,
                            'data' => [],
                            'message' => 'Image not inserted..!'
                        ]);
                   }
               }
           }else{ // image file not availabel
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Image not inserted..!'
                ]);
           }  
    }

     /**
     * _singleFileUploads : Complete Fileupload Handling
     * @param  Request $request
     * @param  $htmlformfilename : input type file name
     * @param  $uploadfiletopath : Public folder paths 'foldername/subfoldername'
     * @return File save with array return
     */
    private function _singleFileUploads($request = "", $htmlformfilename = "", $uploadfiletopath = "")
    {
        try {
            // check if folder exist at public directory if not exist then create folder 0777 permission
            if (!file_exists($uploadfiletopath)) {
                $oldmask = umask(0);
                mkdir($uploadfiletopath, 0777, true);
                umask($oldmask);
            }
            // check parameter empty Validation
            if(empty($request) || empty($htmlformfilename) || empty($uploadfiletopath)){
                    throw new \Exception("Required Parameters are missing", 400);
            }
            $fileNameOnly = preg_replace("/[^a-z0-9\_\-]/i", '', basename($request->file($htmlformfilename)->getClientOriginalName(), '.' . $request->file($htmlformfilename)->getClientOriginalExtension()));
            $fileFullName = $fileNameOnly . "_" . date('dmY') . "_" . time() . "." . $request->file($htmlformfilename)->getClientOriginalExtension();
            $path = $request->file($htmlformfilename)->storeAs($uploadfiletopath, $fileFullName);
            // $request->file($htmlformfilename)->move(public_path($uploadfiletopath), $fileFullName);
            $resp['status'] = true;
            $resp['data'] = array('filename' => $fileFullName, 'url' => url('storage/'.$uploadfiletopath.'/'.$fileFullName), 'fullpath' => \storage_path($path));
            $resp['message'] = "File uploaded successfully..!";
            return $resp;
        } catch (\Exception $ex) {
            $resp['status'] = false;
            $resp['data'] = [];
            $resp['message'] = 'File not uploaded...!';
            $resp['ex_message'] = $ex->getMessage();
            $resp['ex_code'] = $ex->getCode();
            $resp['ex_file'] = $ex->getFile();
            $resp['ex_line'] = $ex->getLine();
            return $resp;
        }
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function loadMultipleFileView(){
        return view('filehandle.add_multiple_file');    
    }

     /**
    * Save Multiple Image File
    * @return \Illuminate\Http\Request
    * @return \Illuminate\Http\Response
    */
    public function submitMultipleFileUpload(Request $request){         
        $request->validate([
            'formFile.*' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
       if ($request->hasFile('formFile')) {
           $filehandle = $this->_multiFileUploads($request, 'formFile', 'public/asset');
           if (isset($filehandle['status']) && $filehandle['status']) {               
                $image_insert = Images::insert($filehandle['data']);
                if($image_insert){ // Image insert
                    return response()->json([
                        'status' => true,
                        'data' => [],
                        'message' => 'Image Inserted Successfully..!'
                    ]);
                }else{ // Image not insert
                    return response()->json([
                        'status' => false,
                        'data' => [],
                        'message' => 'Image not inserted..!'
                    ]);
               }
           }
       }else{ // image file not availabel
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Image not inserted..!'
            ]);
       }  
}

     /**
     * _multiFileUploads : Complete Fileupload Handling
     * @param  Request $request
     * @param  $htmlformfilename : input type file name
     * @param  $uploadfiletopath : Public folder paths 'foldername/subfoldername'
     * @return File save with array return
     */
    private function _multiFileUploads($request = "", $htmlformfilename = "", $uploadfiletopath = "")
    {
        try {
            // check if folder exist at public directory if not exist then create folder 0777 permission
            if (!file_exists($uploadfiletopath)) {
                $oldmask = umask(0);
                mkdir($uploadfiletopath, 0777, true);
                umask($oldmask);
            }
            // check parameter empty Validation
            if(empty($request->$htmlformfilename) && empty($request) || empty($htmlformfilename) || empty($uploadfiletopath)){
                    throw new \Exception("Required Parameters are missing", 400);
            }
            $multiple_file_arr = [];
            foreach($request->$htmlformfilename as $key_file => $val_file ) {                 
                $fileNameOnly = preg_replace("/[^a-z0-9\_\-]/i", '', basename($val_file->getClientOriginalName(), '.' . $val_file->getClientOriginalExtension()));
                $fileFullName = $fileNameOnly . "_" . date('dmY') . "_" . time() . "." . $val_file->getClientOriginalExtension();
                $path = $val_file->storeAs($uploadfiletopath, $fileFullName);
                // $val_file->move(public_path($uploadfiletopath), $fileFullName);
                $multiple_file_arr[] = array('name' => $fileFullName,
                //  'url' => url('storage/'.$uploadfiletopath.'/'.$fileFullName),
                //  'fullpath' => \storage_path($path),
                'created_at' => date('Y-m-d h:m:s'),
                'updated_at' => date('Y-m-d h:m:s'),
                 'user_id' => Auth::user()->id);
            } // Loops Ends
            $resp['status'] = true;
            $resp['data'] = $multiple_file_arr;
            $resp['message'] = "File uploaded successfully..!";
            return $resp;
        } catch (\Exception $ex) {
            $resp['status'] = false;
            $resp['data'] = [];
            $resp['message'] = 'File not uploaded...!';
            $resp['ex_message'] = $ex->getMessage();
            $resp['ex_code'] = $ex->getCode();
            $resp['ex_file'] = $ex->getFile();
            $resp['ex_line'] = $ex->getLine();
            return $resp;
        }
    }
  
}
