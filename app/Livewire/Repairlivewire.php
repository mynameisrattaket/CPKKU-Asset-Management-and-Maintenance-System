<?php

namespace App\Livewire;

use App\Models\Repair;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Repairlivewire extends Component
{
    public function render()
    {
        $request = DB::table('request_detail')->get();
        return view('livewire.repairlivewire',compact('request'));
    }
}
