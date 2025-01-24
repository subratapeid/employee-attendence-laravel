<?php
namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UserImportController extends Controller
{
    public function index()
    {
        return view('admin-pages.user-import');
    }

    public function importUsers(Request $request)
    {
        // Validate the uploaded file type and size
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file format or file too large.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $import = new UsersImport();
            Excel::import($import, $request->file('file'));

            // If there were validation failures
            if ($import->hasErrors()) {
                $errorFilePath = $import->exportFailedRecords();

                return response()->json([
                    'success' => false,
                    'message' => 'Some records failed validation. Please download the error file.',
                    'error_file' => asset('storage/' . $errorFilePath),
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'User data imported successfully!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error importing data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



}
