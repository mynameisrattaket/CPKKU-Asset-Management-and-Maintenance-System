<?php

namespace App\Http\Controllers;

use App\Models\Karupan;
use Illuminate\Http\Request;

class KarupanController extends Controller
{
    protected $tablename;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
            $data['karupan'] = Karupan::orderBy('asset_id', 'asc')->paginate(10);
            return view('index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('karupan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'asset_name' => 'required',
            'asset_price' => 'required',
            'asset_regis_at' => 'required',
            'asset_created_at' => 'required',
            'asset_status_id' => 'required',
            'asset_comment' => 'required',
            'asset_number' => 'required'
        ]);

        $karu = new Karu;
        $karu->asset_name = $request->asset_name;
        $karu->asset_price = $request->asset_price;
        $karu->asset_regis_at = $request->asset_regis_at;
        $karu->asset_created_at = $request->asset_created_at;
        $karu->asset_status_id = $request->asset_status_id;
        $karu->asset_comment = $request->asset_comment;
        $karu->asset_number = $request->asset_number;
        $karu->save();
        return redirect('/')->route('index')->with('success', 'Karupan has Been Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Karu $karu)
    {
        //
        return view('karupan.edit', compact('karu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'asset_name' => 'required',
            'asset_price' => 'required',
            'asset_regis_at' => 'required',
            'asset_created_at' => 'required',
            'asset_status_id' => 'required',
            'asset_comment' => 'required',
            'asset_number' => 'required'
        ]);

        $karu = Karu::find($asset_id);
        $karu->asset_name = $request->asset_name;
        $karu->asset_price = $request->asset_price;
        $karu->asset_regis_at = $request->asset_regis_at;
        $karu->asset_created_at = $request->asset_created_at;
        $karu->asset_status_id = $request->asset_status_id;
        $karu->asset_comment = $request->asset_comment;
        $karu->asset_number = $request->asset_number;
        $karu->save();
        return redirect('/')->route('index')->with('success', 'Karupan has Been Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karu $karu)
    {
        //
        $karu->delete();
        return redirect('/')->route('index')->with('success', 'Karupan has been deleted successfully.');
    }
}
