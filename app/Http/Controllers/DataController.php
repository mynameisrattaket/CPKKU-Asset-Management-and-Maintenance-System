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
                        'asset_number' => $row['A'],
                        'asset_name' => $row['B'],
                        'fiscal_year' => $row['C'],
                        'department' => $row['D'],
                        'department_name' => $row['E'],
                        'sub_department' => $row['F'],
                        'sub_department_name' => $row['G'],
                        'location' => $row['H'],
                        'asset_verification_result' => $row['I'],
                        'usage_verification' => $row['J'],
                        'brand_model_serial_number' => $row['K'],
                        'unit_price' => $row['L'],
                        'funding_source' => $row['M'],
                        'acquisition_method' => $row['N'],
                        'status' => $row['O'],
                    ]);
                }

                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'No file uploaded']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function showImportPage()
{
    return view('import');
}

}
