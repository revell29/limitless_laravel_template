<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\MsObat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MsObat::orderBy('id', 'desc')->select('*');
            return DataTables::of($data)
            ->editColumn('nama_obat', function($item) {
                return '<a href="'.route('obat.edit',$item->id).'">'.$item->nama_obat.'</a>';
            })
            ->escapeColumns([])
            ->make(true);
        }

        return view('pages.obat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.obat.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MsObat::create($request->except('_token'));
        return response()->json(['message' => 'Obat berhasil ditambahkan.'],200);
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
        $data = MsObat::find($id);
        return view('pages.obat.create_edit',compact('data'));
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
        MsObat::where('id',$id)->update($request->except('_token'));
        return response()->json(['message' => 'Obat berhasil diupdate.'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MsObat::whereIn('id', explode(',', $id))->delete();
        return response()->json(['message' => 'Data obat dihapus.'], 200);
    }
}
