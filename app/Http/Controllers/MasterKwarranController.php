<?php

namespace App\Http\Controllers;

use App\Models\MstrKwarran;
use Illuminate\Http\Request;

class MasterKwarranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        try {
            $data = MstrKwarran::where('is_deleted',0)->get();
            
            return view('pages.admin.kwarran.kwarran', [
                'sb_open' => '',
                'sb_active' => 'master_kwarran',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function create()
    {
        return view('pages.admin.kwarran.create', [
            'sb_open' => '',
            'sb_active' => 'master_kwarran'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $mstrKwarran = MstrKwarran::orderBy('id','DESC')->first();
            $id = $mstrKwarran->id + 1;

            MstrKwarran::create([
                'id' => $id,
                'kwarran' => $request->kwarran,
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
            $data = MstrKwarran::where('id',$id)->first();

            return view('pages.admin.kwarran.edit', [
                'sb_open' => '',
                'sb_active' => 'master_kwarran',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            MstrKwarran::where('id',$id)
            ->update([
                'kwarran' => $request->kwarran,
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
            MstrKwarran::where('id',$id)
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
