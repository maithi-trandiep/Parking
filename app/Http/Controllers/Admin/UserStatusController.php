<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = DB::table('users')->get();
        return view('userStatus', ['users' => $users]);
    }

    public function status(Request $request, $id){
        $data = User::find($id);
     
        if ($data->status == 0) {
            # code...
            $data->status=1;
        }else{
            $data->status=0;
        }
        $data->save();
     
        return redirect()->back()->with('message', $data->name.' : Statut a été modifié avec succès.');
    }
}
