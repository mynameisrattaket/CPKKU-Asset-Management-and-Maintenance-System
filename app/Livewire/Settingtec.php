<?php

namespace App\Livewire;


use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Usermain;

class Settingtec extends Component
{
    public function render()
    {
        $show = DB::table('user')->get();
        return view('livewire.settingtec',compact('show'));
    }
}
