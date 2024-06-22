<?php

namespace App\Http\Controllers;

use DB;
use App\Models\resources_materials;
use App\Models\User;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;



class ResourcesController extends Controller
{

     /** index page pyq list */
     public function pyq()
     {
        $pyqList = resources_materials::where('res_type', 'PYQ')->paginate(7);
         return view('resources.pyq_admin',compact('pyqList'));

     }

 /** index page pyq list for tutor */
 public function pyqTutor()
 {
    $pyqTList = resources_materials::where('res_type', 'PYQ')->paginate(7);
     return view('resources.pyq_tutor',compact('pyqTList'));

 }

  /** index page pyq list for student*/
  public function pyqStud()
  {
     
     $pyqSList = resources_materials::where('res_type', 'PYQ')->paginate(7);
      return view('resources.pyq_stud',compact('pyqSList'));
 
  }

public function textbook()
{
    $tbList = resources_materials::where('res_type', 'TEXTBOOK')->paginate(5);
    return view('resources.textbook_admin', compact('tbList'));
}


public function textbookTutor()
{
    $tbTList = resources_materials::where('res_type', 'TEXTBOOK')->paginate(5);
    return view('resources.textbook_tutor', compact('tbTList'));
}

//index page textbook for student
public function textbookStud()
{
    $tbSList = resources_materials::where('res_type', 'TEXTBOOK')->paginate(5);
    return view('resources.textbook_stud', compact('tbSList'));
}


/** index page module list FOR admin*/
 public function module()
{
   $moduleList = resources_materials::where('res_type', 'MODULE')->paginate(7);
    return view('resources.module_admin', compact('moduleList'));
}

/** index page module list for teacher */
public function moduleTutor()
{
    $moduleTList = resources_materials::where('res_type', 'MODULE')->paginate(7);
    return view('resources.module_tutor', compact('moduleTList'));
}

/** index page module list for student */
public function moduleStud()
{
    $moduleSList = resources_materials::where('res_type', 'MODULE')->paginate(7);
    return view('resources.module_stud', compact('moduleSList'));
}


    // Method to show resource upload pyq admin 
    public function showUploadForm()
    {
        //lps upload, resources akan msuk dlm resources_materials table database
        $uploadRes = resources_materials::all();
        //display upload_form page to upload file
        return view('resources.upload_form',compact('uploadRes'));
    }
     // Method to show resource upload pyq tutor
     public function showUploadPyqTutor()
     {
         //lps upload, resources akan msuk dlm resources_materials table database
         $uploadTRes = resources_materials::all();
         //display upload_form page to upload file
         return view('resources.upload_pyq_tutor',compact('uploadTRes'));
     }
      // Method to show resource upload module admin
      public function showUploadModule()
      {
          //lps upload, resources akan msuk dlm resources_materials table database
          $uploadMod = resources_materials::all();
          //display upload_form page to upload file
          return view('resources.upload_module',compact('uploadMod'));
      }

         // Method to show resource upload moduletutor
         public function showUploadModuleTutor()
         {
             //lps upload, resources akan msuk dlm resources_materials table database
             $uploadTMod = resources_materials::all();
             //display upload_form page to upload file
             return view('resources.upload_module_tutor',compact('uploadTMod'));
         }
     
  
  // Method to show resource upload TB admin
  public function showUploadTb()
  {
      //lps upload, resources akan msuk dlm resources_materials table database
      $uploadTb = resources_materials::all();
      //display upload_form page to upload file
      return view('resources.upload_Tb',compact('uploadTb'));
  }


    // Method to handle resource upload/save
    //cari cara cm mana nk save ikut res_type(pyq,module,textbook)
    public function uploadPyq(Request $request)
    {
        if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {

            // Validate the incoming request
            $validatedData = $request->validate([
                'file' => 'required|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
                'res_name' => 'required|string',
                'form' => 'required|string',
                'type' => 'required|string',
            ]);
    
            try {
                DB::beginTransaction(); // Start the transaction
    
                // Handle file upload
                $file = $request->file('file'); // Get the uploaded file
                $filename = time() . '_' . $file->getClientOriginalName(); // Generate a unique filename
                $filePath = $file->storeAs('uploads', $filename, 'public'); // Store the file in the 'public/uploads' directory
    
                // Create a new resource material within the transaction
                $resource = new resources_materials;
                $resource->res_name = $request->res_name;
                $resource->form = $request->form;
                $resource->file_name = $filePath; // Store the file path in the database
                $resource->res_type = $request->type; // Set the type
                $resource->uploaded_by = auth()->user()->id;
    
                $resource->save(); // Save the resource
    
                DB::commit(); // Commit the transaction
    
                // Redirect to the pyq_admin page after successful upload
                Toastr::success('Resource has been added successfully :)', 'Success');
                return redirect()->route('resources_a/pyq/page');
    
            } catch (\Exception $e) {
                DB::rollback(); // Rollback the transaction in case of an exception
    
                // Redirect back with error message
                return redirect()->back()->with('error', 'Failed to upload resource. Please try again.');
            }
        } else {
            // Unauthorized access response
            abort(403, 'Unauthorized action.');
        }
    }

     //Tutor upload pyq
     public function uploadPyqTutor(Request $request)
{
    // Check if the authenticated user is authorized to upload resources
    if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {

        // Validate the incoming request
        $validatedData = $request->validate([
            'file' => 'required|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
            'res_name' => 'required|string',
            'form' => 'required|string',
            'type' => 'required|string',
        ]);

        try {
            DB::beginTransaction(); // Start the transaction

            // Handle file upload
            $file = $request->file('file'); // Get the uploaded file
            $filename = time() . '_' . $file->getClientOriginalName(); // Generate a unique filename
            $filePath = $file->storeAs('uploads', $filename, 'public'); // Store the file in the 'public/uploads' directory

            // Create a new resource material within the transaction
            $resource = new resources_materials;
            $resource->res_name = $request->res_name;
            $resource->form = $request->form;
            $resource->file_name = $filePath; // Store the file path in the database
            $resource->res_type = $request->type; // Set the type
            $resource->uploaded_by = auth()->user()->id;

            $resource->save(); // Save the resource

            DB::commit(); // Commit the transaction

            // Redirect to the pyq_admin page after successful upload
            Toastr::success('Resource has been added successfully :)', 'Success');
            return redirect()->route('resources_a/pyqTutor/page');

        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to upload resource. Please try again.');
        }
    } else {
        // Unauthorized access response
        abort(403, 'Unauthorized action.');
    }
}


    //FUNCTION UPLOAD/SAVE MODULE
    public function uploadModule(Request $request)
    {
        if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {

            // Validate the incoming request
            $validatedData = $request->validate([
                'file' => 'required|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
                'res_name' => 'required|string',
                'form' => 'required|string',
                'type' => 'required|string',
            ]);
    
            try {
                DB::beginTransaction(); // Start the transaction
    
                // Handle file upload
                $file = $request->file('file'); // Get the uploaded file
                $filename = time() . '_' . $file->getClientOriginalName(); // Generate a unique filename
                $filePath = $file->storeAs('uploads', $filename, 'public'); // Store the file in the 'public/uploads' directory
    
                // Create a new resource material within the transaction
                $resource = new resources_materials;
                $resource->res_name = $request->res_name;
                $resource->form = $request->form;
                $resource->file_name = $filePath; // Store the file path in the database
                $resource->res_type = $request->type; // Set the type
                $resource->uploaded_by = auth()->user()->id;
    
                $resource->save(); // Save the resource
    
                DB::commit(); // Commit the transaction
    
                // Redirect to the pyq_admin page after successful upload
                Toastr::success('Resource has been added successfully :)', 'Success');
                return redirect()->route('resources_a/module/page');
    
            } catch (\Exception $e) {
                DB::rollback(); // Rollback the transaction in case of an exception
    
                // Redirect back with error message
                return redirect()->back()->with('error', 'Failed to upload resource. Please try again.');
            }
        } else {
            // Unauthorized access response
            abort(403, 'Unauthorized action.');
        }
    }

 //Tutor upload module
 public function uploadModuleTutor(Request $request)
 {
    if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {

        // Validate the incoming request
        $validatedData = $request->validate([
            'file' => 'required|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
            'res_name' => 'required|string',
            'form' => 'required|string',
            'type' => 'required|string',
        ]);

        try {
            DB::beginTransaction(); // Start the transaction

            // Handle file upload
            $file = $request->file('file'); // Get the uploaded file
            $filename = time() . '_' . $file->getClientOriginalName(); // Generate a unique filename
            $filePath = $file->storeAs('uploads', $filename, 'public'); // Store the file in the 'public/uploads' directory

            // Create a new resource material within the transaction
            $resource = new resources_materials;
            $resource->res_name = $request->res_name;
            $resource->form = $request->form;
            $resource->file_name = $filePath; // Store the file path in the database
            $resource->res_type = $request->type; // Set the type
            $resource->uploaded_by = auth()->user()->id;

            $resource->save(); // Save the resource

            DB::commit(); // Commit the transaction

            // Redirect to the pyq_admin page after successful upload
            Toastr::success('Resource has been added successfully :)', 'Success');
            return redirect()->route('resources_a/moduleTutor/page');

        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to upload resource. Please try again.');
        }
    } else {
        // Unauthorized access response
        abort(403, 'Unauthorized action.');
    }
 }

 //Admin upload Textbook
    public function uploadTb(Request $request)
    {
        if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {

            // Validate the incoming request
            $validatedData = $request->validate([
                'file' => 'required|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
                'res_name' => 'required|string',
                'form' => 'required|string',
                'type' => 'required|string',
            ]);
    
            try {
                DB::beginTransaction(); // Start the transaction
    
                // Handle file upload
                $file = $request->file('file'); // Get the uploaded file
                $filename = time() . '_' . $file->getClientOriginalName(); // Generate a unique filename
                $filePath = $file->storeAs('uploads', $filename, 'public'); // Store the file in the 'public/uploads' directory
    
                // Create a new resource material within the transaction
                $resource = new resources_materials;
                $resource->res_name = $request->res_name;
                $resource->form = $request->form;
                $resource->file_name = $filePath; // Store the file path in the database
                $resource->res_type = $request->type; // Set the type
                $resource->uploaded_by = auth()->user()->id;
    
                $resource->save(); // Save the resource
    
                DB::commit(); // Commit the transaction
    
                // Redirect to the pyq_admin page after successful upload
                Toastr::success('Resource has been added successfully :)', 'Success');
                return redirect()->route('resources_a/textbook/page');
    
            } catch (\Exception $e) {
                DB::rollback(); // Rollback the transaction in case of an exception
    
                // Redirect back with error message
                return redirect()->back()->with('error', 'Failed to upload resource. Please try again.');
            }
        } else {
            // Unauthorized access response
            abort(403, 'Unauthorized action.');
        }
    }
    

     // Method to show edit pyq admin
     public function edit($res_id)
     {
         $resource = resources_materials::findOrFail($res_id);
         return view('resources.edit_upload_form', compact('resource'));
     }

      // Method to show edit pyq tutor
      public function editPyqTutor($res_id)
      {
          $resource = resources_materials::findOrFail($res_id);
          return view('resources.edit_pyq_tutor', compact('resource'));
      }
 // Method to show edit resource module admin
 public function editModule($res_id)
 {
     $resource = resources_materials::findOrFail($res_id);
     return view('resources.edit_upload_module', compact('resource'));
 }

  // Method to show edit resource module tutor
  public function editModuleTutor($res_id)
  {
      $resource = resources_materials::findOrFail($res_id);
      return view('resources.edit_module_tutor', compact('resource'));
  }
// Method to show edit resource module admin
public function editTb($res_id)
{
    $resource = resources_materials::findOrFail($res_id);
    return view('resources.edit_upload_tb', compact('resource'));
}

     //UPDATE ADMIN PYQ
     public function updatePyq(Request $request, $res_id)
     {
         // Check if the authenticated user is authorized to update resources
         if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {
             
             // Validate the incoming request
             $validatedData = $request->validate([
                 'file' => 'sometimes|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
                 'res_name' => 'required|string',
                 'form' => 'required|string',
                 'type' => 'required|string',
             ]);
     
             try {
                 DB::beginTransaction(); // Start the transaction
     
                 // Find the resource material by ID
                 $resource = resources_materials::findOrFail($res_id);
     
                 // Handle file upload if a new file is provided
                 if ($request->hasFile('file')) {
                     // Delete the old file if it exists
                     if (Storage::disk('public')->exists($resource->file_name)) {
                         Storage::disk('public')->delete($resource->file_name);
                     }
     
                     // Upload the new file
                     $file = $request->file('file');
                     $filename = time() . '_' . $file->getClientOriginalName();
                     $filePath = $file->storeAs('uploads', $filename, 'public');
                     $resource->file_name = $filePath; // Update the file path in the database
                 }
     
                 // Update the resource with the new data
                 $resource->res_name = $request->res_name;
                 $resource->form = $request->form;
                 $resource->res_type = $request->type;
     
                 // Save the updated resource
                 $resource->save();
     
                 DB::commit(); // Commit the transaction
     
                 // Redirect back with success message
                 Toastr::success('Resource updated successfully :)', 'Success');
                 return redirect()->route('resources_a/pyq/page');
             } catch (\Exception $e) {
                 DB::rollback(); // Rollback the transaction in case of an exception
     
                 \Log::error('Exception: ' . $e->getMessage());
                 \Log::error('Exception Trace: ' . $e->getTraceAsString());
     
                 return redirect()->back()->with('error', 'Failed to update resource. Please try again.');
             }
         } else {
             // Unauthorized access response
             abort(403, 'Unauthorized action.');
         }
     }
     

//UPDATE Tutor PYQ
public function updatePyqTutor(Request $request, $res_id)
{
     // Check if the authenticated user is authorized to update resources
     if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {
             
        // Validate the incoming request
        $validatedData = $request->validate([
            'file' => 'sometimes|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
            'res_name' => 'required|string',
            'form' => 'required|string',
            'type' => 'required|string',
        ]);

        try {
            DB::beginTransaction(); // Start the transaction

            // Find the resource material by ID
            $resource = resources_materials::findOrFail($res_id);

            // Handle file upload if a new file is provided
            if ($request->hasFile('file')) {
                // Delete the old file if it exists
                if (Storage::disk('public')->exists($resource->file_name)) {
                    Storage::disk('public')->delete($resource->file_name);
                }

                // Upload the new file
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $filename, 'public');
                $resource->file_name = $filePath; // Update the file path in the database
            }

            // Update the resource with the new data
            $resource->res_name = $request->res_name;
            $resource->form = $request->form;
            $resource->res_type = $request->type;

            // Save the updated resource
            $resource->save();

            DB::commit(); // Commit the transaction

            // Redirect back with success message
            Toastr::success('Resource updated successfully :)', 'Success');
            return redirect()->route('resources_a/pyqTutor/page');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception

            \Log::error('Exception: ' . $e->getMessage());
            \Log::error('Exception Trace: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Failed to update resource. Please try again.');
        }
    } else {
        // Unauthorized access response
        abort(403, 'Unauthorized action.');
    }
}


 //UPDATE ADMIN MODULE
     public function updateModule(Request $request, $res_id)
{
     // Check if the authenticated user is authorized to update resources
     if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {
             
        // Validate the incoming request
        $validatedData = $request->validate([
            'file' => 'sometimes|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
            'res_name' => 'required|string',
            'form' => 'required|string',
            'type' => 'required|string',
        ]);

        try {
            DB::beginTransaction(); // Start the transaction

            // Find the resource material by ID
            $resource = resources_materials::findOrFail($res_id);

            // Handle file upload if a new file is provided
            if ($request->hasFile('file')) {
                // Delete the old file if it exists
                if (Storage::disk('public')->exists($resource->file_name)) {
                    Storage::disk('public')->delete($resource->file_name);
                }

                // Upload the new file
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $filename, 'public');
                $resource->file_name = $filePath; // Update the file path in the database
            }

            // Update the resource with the new data
            $resource->res_name = $request->res_name;
            $resource->form = $request->form;
            $resource->res_type = $request->type;

            // Save the updated resource
            $resource->save();

            DB::commit(); // Commit the transaction

            // Redirect back with success message
            Toastr::success('Resource updated successfully :)', 'Success');
            return redirect()->route('resources_a/module/page');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception

            \Log::error('Exception: ' . $e->getMessage());
            \Log::error('Exception Trace: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Failed to update resource. Please try again.');
        }
    } else {
        // Unauthorized access response
        abort(403, 'Unauthorized action.');
    }
}

//UPDATE ADMIN MODULE
public function updateModuleTutor(Request $request, $res_id)
{
     // Check if the authenticated user is authorized to update resources
     if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {
             
        // Validate the incoming request
        $validatedData = $request->validate([
            'file' => 'sometimes|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
            'res_name' => 'required|string',
            'form' => 'required|string',
            'type' => 'required|string',
        ]);

        try {
            DB::beginTransaction(); // Start the transaction

            // Find the resource material by ID
            $resource = resources_materials::findOrFail($res_id);

            // Handle file upload if a new file is provided
            if ($request->hasFile('file')) {
                // Delete the old file if it exists
                if (Storage::disk('public')->exists($resource->file_name)) {
                    Storage::disk('public')->delete($resource->file_name);
                }

                // Upload the new file
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $filename, 'public');
                $resource->file_name = $filePath; // Update the file path in the database
            }

            // Update the resource with the new data
            $resource->res_name = $request->res_name;
            $resource->form = $request->form;
            $resource->res_type = $request->type;

            // Save the updated resource
            $resource->save();

            DB::commit(); // Commit the transaction

            // Redirect back with success message
            Toastr::success('Resource updated successfully :)', 'Success');
            return redirect()->route('resources_a/moduleTutor/page');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception

            \Log::error('Exception: ' . $e->getMessage());
            \Log::error('Exception Trace: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Failed to update resource. Please try again.');
        }
    } else {
        // Unauthorized access response
        abort(403, 'Unauthorized action.');
    }
}

//UPDATE ADMIN TEXTBOOK
public function updateTb(Request $request, $res_id)
{
     // Check if the authenticated user is authorized to update resources
     if (auth()->user()->role_name === 'Admin' || auth()->user()->role_name === 'Teachers') {
             
        // Validate the incoming request
        $validatedData = $request->validate([
            'file' => 'sometimes|mimes:doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:9120',
            'res_name' => 'required|string',
            'form' => 'required|string',
            'type' => 'required|string',
        ]);

        try {
            DB::beginTransaction(); // Start the transaction

            // Find the resource material by ID
            $resource = resources_materials::findOrFail($res_id);

            // Handle file upload if a new file is provided
            if ($request->hasFile('file')) {
                // Delete the old file if it exists
                if (Storage::disk('public')->exists($resource->file_name)) {
                    Storage::disk('public')->delete($resource->file_name);
                }

                // Upload the new file
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $filename, 'public');
                $resource->file_name = $filePath; // Update the file path in the database
            }

            // Update the resource with the new data
            $resource->res_name = $request->res_name;
            $resource->form = $request->form;
            $resource->res_type = $request->type;

            // Save the updated resource
            $resource->save();

            DB::commit(); // Commit the transaction

            // Redirect back with success message
            Toastr::success('Resource updated successfully :)', 'Success');
            return redirect()->route('resources_a/textbook/page');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception

            \Log::error('Exception: ' . $e->getMessage());
            \Log::error('Exception Trace: ' . $e->getTraceAsString());

            return redirect()->back()->with('error', 'Failed to update resource. Please try again.');
        }
    } else {
        // Unauthorized access response
        abort(403, 'Unauthorized action.');
    }
}
     
//DELETE
public function resourceDelete(Request $request)
{
    $resId = $request->input('res_id');

    try {
        // Find the resource by ID
        $resource = resources_materials::find($resId);

        // Check if the resource exists
        if (!$resource) {
            throw new \Exception('Resource not found');
        }

        // Check if the authenticated user is authorized to delete the resource
        if ($resource->uploaded_by == auth()->id()) {
            // Log attempt to delete resource
            Log::info('Attempting to delete resource', ['res_id' => $resId]);

            // Delete the resource
            $resource->delete();

            // Log successful deletion
            Log::info('Resource deleted successfully', ['res_id' => $resId]);

            // Redirect with success message
            return redirect()->back()->with('success', 'Resource deleted successfully');
        } else {
            // Unauthorized action
            Log::warning('Unauthorized action attempted', ['user_id' => auth()->id(), 'res_id' => $resId]);
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    } catch (\Exception $e) {
        // Log deletion failure
        Log::error('Failed to delete resource', ['error' => $e->getMessage(), 'res_id' => $resId]);

        // Redirect with error message
        return redirect()->back()->with('error', 'Failed to delete resource :(');
    }
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

// Save file resource into bookmark database
public function store(Request $request)
    {
        Log::info('Bookmark store method called');
        Log::info('Resource ID: ' . $request->resource_id);
        Log::info('User ID: ' . Auth::id());

        DB::beginTransaction();

        try {
            $request->validate([
                'resource_id' => 'required|exists:resources_materials,res_id',
            ]);

            Log::info('Validation passed');

            $bookmarkExists = Bookmark::where('stud_id', Auth::id())
                ->where('resource_id', $request->resource_id)
                ->exists();

            if (!$bookmarkExists) {
                Log::info('Creating new bookmark');
                Bookmark::create([
                    'stud_id' => Auth::id(),
                    'resource_id' => $request->resource_id,
                ]);

                DB::commit();

                return response()->json(['message' => 'Resource has been added successfully :)', 'status' => 'success']);
            } else {
                Log::info('Resource already bookmarked');
                return response()->json(['message' => 'Resource already bookmarked!', 'status' => 'warning']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in database transaction: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to add bookmark. Please try again.', 'status' => 'error']);
        }
    }


}


    
     


