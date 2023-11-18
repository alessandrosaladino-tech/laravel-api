<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function projects()
    {
        return response()->json([
            'status' => 'success',
            'projects' => Project::with(['type', 'technologies'])->orderByDesc('id')->paginate(5)
        ]);
    }

    public function types()
    {
        return response()->json([
            'status' => 'success',
            'projects' => Type::with('projects')->orderByDesc('id')->paginate(5)
        ]);
    }

    public function technologies()
    {
        return response()->json([
            'status' => 'success',
            'projects' => Technology::with('projects')->orderByDesc('id')->paginate(5)
        ]);
    }
}