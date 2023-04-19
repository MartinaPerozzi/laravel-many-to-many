<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    // La funzione che era in web.php dove ho sostituito con l'AdminHomeController::class
    public function index(User $user)
    {
        return view('admin.dashboard', compact('user'));
    }
}
