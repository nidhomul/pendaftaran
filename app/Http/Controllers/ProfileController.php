<?php

namespace App\Http\Controllers;

use App\Models\TrParticipants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('pages.public.profile.profile', [
            'sb_open' => '',
            'sb_active' => ''
        ]);
    }

    public function update(Request $request)
    {
        try {
            if ($request->password) {
                // * update password
                User::where('id',auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                // * don't update password
                User::where('id',auth()->user()->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email
                ]);
            }

            // * update participants data
            if (auth()->user()->participant_id) {
                TrParticipants::where('id',auth()->user()->participant_id)
                ->update([
                    'full_name' => $request->name,
                    'email' => $request->email,
                    'updated_by' => auth()->user()->email
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diubah'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
