<?php

namespace App\Livewire;

use App\Models\Repair;
use Livewire\Component;
use Illuminate\Support\Facades\DB; // เพิ่มบรรทัดนี้เพื่อใช้ DB

class Repair extends Component
{
    public function render()
    {
        $request = DB::table('request_detail')->get();
        return view('livewire.repair', compact('request'));
    }
}

