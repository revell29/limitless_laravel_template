<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\MsDokter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = MsDokter::orderBy('id','desc')->select('*');
            return DataTables::of($data)
                ->editColumn('nip', function($row) {
                    return "<a href='".route('dokter.edit', $row->id)."'>".$row->nip."</a>";
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('pages.dokter.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dokter.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MsDokter::create($request->except('_token'));
        return response()->json(['message' => 'Data dotker berhasil dibuat.'],200);
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
    public function edit($id)
    {
        $data = MsDokter::find($id);
        return view('pages.dokter.create_edit', compact('data'));
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
        MsDokter::find($id)->update($request->except('_expect'));
        return response()->json(['message' => 'Data dokter berhasil dihapus'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MsDokter::whereIn('id', explode(',', $id))->delete();
        return response()->json(['message' => 'Data dokter berhasil dihapus.'], 200);
    }
}
