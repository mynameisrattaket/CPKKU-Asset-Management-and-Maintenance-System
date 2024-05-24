<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Karupan;
use App\Models\Repair;

class Assetdetail extends Component
{
    public function render()
    {
        $r = Repair::all();

        return view('livewire.assetdetail',compact('r'));
    }
}
