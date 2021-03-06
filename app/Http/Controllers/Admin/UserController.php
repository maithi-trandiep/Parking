<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.userList');
    }

    /**
     * Get the data for listing in yajra.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUsers(Request $request, User $user)
    {
        $data = $user->getData();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditArticleData" data-id="'.$data->id.'">Edit</button>
                    <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm btnDelete" id="btnDelete-'.$data->id.'">Delete</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $user->storeData($request->all());

        return response()->json(['success'=>'User added successfully']);
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
        $user = new User;
        $data = $user->find($id);

        $html = '<div class="form-group">
                    <label for="Name">Prénom:</label>
                    <input type="text" class="form-control" name="name" id="name" value="'.$data->name.'" required/>
                </div>
                <div class="form-group">
                    <label for="LName">Nom</label>
                    <input type="text" class="form-control" name="lname" id="lname" value="'.$data->lname.'" required/>
                </div>
                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="text" class="form-control" name="email" id="email" value="'.$data->email.'" required/>
                </div>
                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="text" class="form-control" name="password" id="password" value="'.$data->password.'" required/>
                </div>';

        return response()->json(['html'=>$html]);
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // $request->validate([
        //     'name' => 'required',
        //     'name' => 'required',
        //     'email' => 'required',
        //     'password' => 'required'
        //     ]);

        // $user = new User;
        // $user->name = $request->name;
        // $user->lname = $request->lname;
        // $user->email = $request->email;
        // $user->password = $request->password;

        // $user->save();

        $user = new User;
        $user->updateData($id, $request->all());

        

        return response()->json(['success'=>'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = new User;
        $user->deleteData($id);

        return response()->json(['success'=>'User deleted successfully']);
    }
}
