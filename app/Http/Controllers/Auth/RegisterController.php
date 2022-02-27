<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => 'required|numeric|digits:10',
            'date_of_birth' => 'required',
            'role_id' => 'required',
            'hobbies' => 'required',
            'formFile' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $file_name = "";
        if (request()->hasFile('formFile')) {
            $filehandle = $this->_singleFileUploads(request(), 'formFile', 'public/asset');
            if (isset($filehandle['status']) && $filehandle['status']) {   
                $file_name = $filehandle['data']['filename'];
            }
        }
        return User::create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'mobile' => $data['mobile'],
            'address' => $data['address'],
            'date_of_birth' => $data['date_of_birth'],
            'profile_image' => $file_name,
            'hobbies' => implode(',', $data['hobbies']),
            'role_id' => $data['role_id'],            
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
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

    
}
