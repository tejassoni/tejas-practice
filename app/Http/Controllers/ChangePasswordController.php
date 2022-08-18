<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
  
    public function viewChangePassword()
    {
        return view('auth/passwords/change-password');
    }

}
