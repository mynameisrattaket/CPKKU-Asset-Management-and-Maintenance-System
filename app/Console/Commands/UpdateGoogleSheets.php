<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UpdateGoogleSheets extends Command
{
    // ตั้งชื่อ command นี้
    protected $signature = 'update:google-sheets';

    // อธิบาย command ว่าทำอะไร
    protected $description = 'Update Google Sheets Data into MySQL Database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $response = Http::get('https://spreadsheets.google.com/feeds/list/2PACX-1vRA4JiIvbzipooeNQEkqD3mVEM-t42tWWLN1Iwe-WQgYKUI1HE5_ceECrWR3ra7qrf1Jxt-S67pYw6G/od6/public/values?alt=json');
        $data = $response->json();

        foreach ($data['feed']['entry'] as $entry) {
            DB::table('request_detail')->updateOrInsert(
                ['request_detail_id' => $entry['gsx$requestdetailid']['$t']],
                [
                    'asset_image' => $entry['gsx$assetimage']['$t'],
                    'asset_number' => $entry['gsx$assetnumber']['$t'],
                    'asset_name' => $entry['gsx$assetname']['$t'],
                    'request_repair_id' => $entry['gsx$requestrepairid']['$t'],
                    'asset_symptom_detail' => $entry['gsx$assetsymptomdetail']['$t'],
                    'location' => $entry['gsx$location']['$t'],
                    'request_repair_note' => $entry['gsx$requestrepairnote']['$t'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        $this->info('Google Sheets data updated successfully');
    }
}
