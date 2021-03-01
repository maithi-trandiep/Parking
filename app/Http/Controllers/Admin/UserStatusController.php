<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class UserStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index()
    // {
    //     $users = DB::table('users')->get();
    //     return view('userStatus', ['users' => $users]);
    // }

    public function show()
    {
        return view('userStatus');
    }
    
    public function index(Request $request, User $user)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addColumn('action', function($data){
                    if($data->status == 1){
                    $actionBtn = '<a href="'. route('status', $data->id) .'" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="status">Inactive</a>';
                    }else if($data->status == 0){
                    $actionBtn = '<a href="'. route('status', $data->id) .'" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="status">Active</a>';       
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
