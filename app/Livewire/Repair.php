<?php

namespace App\Livewire;

use App\Models\Repair;
use Livewire\Component;

class Repairl extends Component
{
    public function render()
    {
        $request = DB::table('request_detail')->get();
        return view('livewire.repair',compact('request'));
    }
}
