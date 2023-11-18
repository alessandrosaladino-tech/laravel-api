<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    function index() {
        return view('admin.dashboard',  [
            'total_projects' => Project::all()->count(),
            'total_users' => User::all()->count(),
        ]);
    }
}
