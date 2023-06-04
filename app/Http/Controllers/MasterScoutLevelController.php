<?php

namespace App\Http\Controllers;

use App\Models\MstrScoutLevel;
use Illuminate\Http\Request;

class MasterScoutLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        try {
            $data = MstrScoutLevel::where('is_deleted',0)->get();
            
            return view('pages.admin.scout_level.scout_level', [
                'sb_open' => '',
                'sb_active' => 'master_scout_level',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function create()
    {
        return view('pages.admin.scout_level.create', [
            'sb_open' => '',
            'sb_active' => 'master_scout_level'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $mstrScoutLevel = MstrScoutLevel::orderBy('id','DESC')->first();
            $id = $mstrScoutLevel->id + 1;

            MstrScoutLevel::create([
                'id' => $id,
                'scout_level' => $request->scout_level,
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
            $data = MstrScoutLevel::where('id',$id)->first();

            return view('pages.admin.scout_level.edit', [
                'sb_open' => '',
                'sb_active' => 'master_scout_level',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            abort(500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            MstrScoutLevel::where('id',$id)
            ->update([
                'scout_level' => $request->scout_level,
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
            MstrScoutLevel::where('id',$id)
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
