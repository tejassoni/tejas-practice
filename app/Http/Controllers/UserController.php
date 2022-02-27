<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile_view()
    {
        return view('profile');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request)
    {
        if ($request->hasFile('formFile')) {
            $request->validate([
                'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
                'mobile' => 'required|numeric|digits:10',
                'date_of_birth' => 'required',
                'role_id' => 'required',
                'hobbies' => 'required',
                'formFile' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'email' => "required|email|unique:users,email," . Auth::user()->id,
            ]);
            $update_result = User::find(Auth::user()->id);
            $filehandle = $this->_singleFileUploads($request, 'formFile', 'public/asset');
            if (isset($filehandle['status']) && $filehandle['status']) {
                if(!empty($update_result->profile_image) && file_exists(storage_path('app/public/asset/'.$update_result->profile_image))){
                    unlink(storage_path('app/public/asset/'.$update_result->profile_image));
                }                
                $update_result->profile_image = $filehandle['data']['filename'];
            }
        } else {
            $request->validate([
                'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
                'mobile' => 'required|numeric|digits:10',
                'date_of_birth' => 'required',
                'role_id' => 'required',
                'hobbies' => 'required',
                'email' => "required|email|unique:users,email," . Auth::user()->id,
            ]);
            $update_result = User::find(Auth::user()->id);
        }
        $update_result->name = $request->name;
        $update_result->mobile = $request->mobile;
        $update_result->gender = $request->gender;
        $update_result->hobbies = implode(',', $request->hobbies);
        $update_result->date_of_birth = $request->date_of_birth;
        $update_result->address = $request->address;
        $update_result->role_id = $request->role_id;
        $update_result->save();

        if ($update_result) { // success update
            return redirect()->back()->with('success', 'Record updated Succuessfully..!');
        } else { // fail update
            return redirect()->back()->withInput($request->all())->with('error', 'Record not Updated..!');
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
            if (empty($request) || empty($htmlformfilename) || empty($uploadfiletopath)) {
                throw new \Exception("Required Parameters are missing", 400);
            }
            $fileNameOnly = preg_replace("/[^a-z0-9\_\-]/i", '', basename($request->file($htmlformfilename)->getClientOriginalName(), '.' . $request->file($htmlformfilename)->getClientOriginalExtension()));
            $fileFullName = $fileNameOnly . "_" . date('dmY') . "_" . time() . "." . $request->file($htmlformfilename)->getClientOriginalExtension();
            $path = $request->file($htmlformfilename)->storeAs($uploadfiletopath, $fileFullName);
            // $request->file($htmlformfilename)->move(public_path($uploadfiletopath), $fileFullName);
            $resp['status'] = true;
            $resp['data'] = array('filename' => $fileFullName, 'url' => url('storage/' . $uploadfiletopath . '/' . $fileFullName), 'fullpath' => \storage_path($path));
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
