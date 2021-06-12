<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MsPasien;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MsPasien::orderBy('id','DESC')->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('nama_pasien', function ($item) {
                    return '<a href="' . route('pasien.edit', $item->id) . '">' . $item->nama_pasien . '</a>';
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('pages.pasien.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = $this->listing();
        return view('pages.pasien.create_edit', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
        
            MsPasien::create($request->except('_token'));

            DB::commit();
            return response()->json(['message' => 'Pasien berhasil ditambahkan.'],200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MsPasien::where('id',$id)->first();
        $options = $this->listing();

        return view('pages.pasien.create_edit',compact('data','options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $data = DB::table('ms_pasien')->where('id',$id)->first();
            if($data) {
                DB::table('ms_pasien')->where('id',$id)->update($request->except('_token'));
            }

            DB::commit();
            return response()->json(['messages' => 'Data berhasil diupdate'],200);
        }catch(\Exception $e) {
            DB::rollback();
            return response()->json(['messages' => $e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MsPasien::whereIn('id', explode(',', $id))->delete();
        return response()->json(['message' => 'Data pasien dihapus.'], 200);
    }

    public function listing() {
        $gender = ['Wanita' => 'Wanita', 'Pria' => 'Pria'];

        $options['gender'] = $gender;
        return $options;
    }
}
