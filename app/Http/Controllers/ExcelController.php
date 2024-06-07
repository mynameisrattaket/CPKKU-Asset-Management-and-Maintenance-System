<?php

// app/Http/Controllers/ExcelController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx' // ตรวจสอบไฟล์ Excel
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('excels', $fileName);

            $data = \Excel::load(storage_path('app/' . $filePath))->get();

            foreach ($data as $row) {
                User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone']
                ]);
            }

            return response()->json(['users' => User::all()]);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }
}

