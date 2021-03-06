<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Place;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('places.placeList');
    }

    /**
     * Get the data for listing in yajra.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPlaces(Request $request, Place $place)
    {
        $data = $place->getData();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditArticleData" data-id="'.$data->id.'">Modifier</button>
                    <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm btnDelete" id="btnDelete-'.$data->id.'">Supprimer</button>';
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
    public function store(Request $request, Place $place)
    {
        $validator = Validator::make($request->all(), [
            'libel' => ['required', 'string', 'max:255'],
            'statutP' => ['required'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $place->storeData($request->all());

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
        $place = new Place;
        $data = $place->find($id);

        $html = '<div class="form-group">
                    <label for="libel">Libelle:</label>
                    <input type="text" class="form-control" name="libel" id="libel" value="'.$data->libel.'" required/>
                </div>
                <div class="form-group">
                    <label for="statutP">Statut:</label>
                        <select class="form-control" id="statutP">
                        @if($data->statutP == 0){
                        <option value="0">Libre</option>
                        } else
                        <option value="1">Occupé</option>
                        </select>
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
            'libel' => ['required', 'string', 'max:255'],
            'statutP' => ['required'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $place = new Place;
        $place->updateData($id, $request->all());

        return response()->json(['success'=>'Place updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = new Place;
        $place->deleteData($id);

        return response()->json(['success'=>'Place deleted successfully']);
    }
}
