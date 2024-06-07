<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Models\Asset;

class DataController extends Controller
{
    public function saveData(Request $request)
    {
        try {
            if ($request->hasFile('excel_file')) {
                $excel = $request->file('excel_file');
                $reader = new Xlsx();
                $spreadsheet = $reader->load($excel->getPathname());
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                foreach ($sheetData as $key => $row) {
                    if ($key === 1) continue; // Skip header row
                    Asset::create([
                        'fiscal_year' => $row['A'],
                        'department' => $row['B'],
                        'department_name' => $row['C'],
                        'sub_department' => $row['D'],
                        'sub_department_name' => $row['E'],
                        'location' => $row['F'],
                        'asset_verification_result' => $row['G'],
                        'asset_number' => $row['H'],
                        'usage_verification' => $row['I'],
                        'asset_name' => $row['J'],
                        'brand_model_serial_number' => $row['K'],
                        'unit_price' => $row['L'],
                        'funding_source' => $row['M'],
                        'acquisition_method' => $row['N'],
                        'status' => $row['O'],
                    ]);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
