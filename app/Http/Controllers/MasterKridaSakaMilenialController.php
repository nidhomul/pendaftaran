<?php

namespace App\Http\Controllers;

use App\Models\MstrKridaSakaMilenial;
use Illuminate\Http\Request;

class MasterKridaSakaMilenialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        try {
            $data = MstrKridaSakaMilenial::where('is_deleted',0)->get();
            
            return view('pages.admin.krida_saka_milenial.krida_saka_milenial', [
                'sb_open' => '',
                'sb_active' => 'master_krida_saka_milenial',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function create()
    {
        return view('pages.admin.krida_saka_milenial.create', [
            'sb_open' => '',
            'sb_active' => 'master_krida_saka_milenial'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $mstrKridaSakaMilenial = MstrKridaSakaMilenial::orderBy('id','DESC')->first();
            $id = $mstrKridaSakaMilenial->id + 1;

            MstrKridaSakaMilenial::create([
                'id' => $id,
                'krida_saka_milenial' => $request->krida_saka_milenial,
                'created_by' => auth()->user()->email
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $data = MstrKridaSakaMilenial::where('id',$id)->first();

            return view('pages.admin.krida_saka_milenial.edit', [
                'sb_open' => '',
                'sb_active' => 'master_krida_saka_milenial',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            MstrKridaSakaMilenial::where('id',$id)
            ->update([
                'krida_saka_milenial' => $request->krida_saka_milenial,
                'updated_by' => auth()->user()->email
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            MstrKridaSakaMilenial::where('id',$id)
            ->update([
                'is_deleted' => 1,
                'updated_by' => auth()->user()->email
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
