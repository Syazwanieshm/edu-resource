<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Models\resources_materials;
use App\Models\Bookmark; 
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;


class BookmarkController extends Controller
{
    public function main()
    {
        // Fetch the bookmarks for the authenticated user
        $bookmarks = Bookmark::where('stud_id', Auth::id())->with('resource')->get();
        return view('bookmark.stud_bookmark', compact('bookmarks'));
    }

    

    public function download($res_id)
{
    // Find the resource by ID
    $resource = resources_materials::findOrFail($res_id);

    // Assuming the file path is stored in a column called 'file_name'
    $filePath = $resource->file_name;

    // Check if the file exists
    if (!Storage::disk('public')->exists($filePath)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    // Create a response for downloading the file
    return Storage::disk('public')->download($filePath);
}

public function viewFile($res_id)
{
    // Find the resource by ID
    $resource = resources_materials::findOrFail($res_id);

    // Assuming the file path is stored in a column called 'file_name'
    $filePath = $resource->file_name;

    // Check if the file exists
    if (!Storage::disk('public')->exists($filePath)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    // Get the file's URL
    $fileUrl = Storage::disk('public')->url($filePath);

    // Return a view to display the file, or redirect to the file URL
    return response()->file(storage_path('app/public/' . $filePath));
}

public function destroy($res_id)
{
    try {
        $bookmark = Bookmark::findOrFail($res_id);
        $bookmark->delete();
        Toastr::success('Resource deleted from bookmark successfully');
    } catch (\Exception $e) {
        Toastr::error('Failed to delete resource from bookmark');
    }
    return redirect()->route('bookmark/view/page');
}

}