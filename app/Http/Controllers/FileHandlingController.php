<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class FileHandlingController extends Controller
{
   
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function loadSingleFileView(){
        return view('folder_name.create');    
    }
  
}
