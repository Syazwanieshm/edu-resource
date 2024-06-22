<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Models\resources_materials;
use App\Models\Bookmark; 
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Folder;

class FolderController extends Controller
{
    public function create()
    {
        return view('folder.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        try {
            Folder::create([
                'folder_name' => $request->folder_name,
            ]);
            Toastr::success('Folder created successfully');
        } catch (\Exception $e) {
            Toastr::error('Failed to create folder');
        }

        return redirect()->route('bookmark/view/page');
    }
}