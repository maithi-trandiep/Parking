<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Place;

class ManageReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reservations.adminReservation');
    }

    /**
     * Get the data for listing in yajra.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getReservations(Request $request, Reservation $reservation)
    {
        $data = $reservation->getDataAll();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm btnDelete" id="btnDelete-'.$data->id.'">Annuler</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    public function showWaitList()
    {
        return view('reservations.waitlist');
    }

    public function getWaitList(Request $request, Reservation $reservation)
    {
        $data = $reservation->getDataWaitList();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditRangData" data-id="'.$data->id.'">Modifier</button>';
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
    public function store(Request $request)
    {
        //
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
        // $count = count($data->rangAttente);
        $i = 0;
        $a = DB::table('users')->whereNotNull('rangAttente')->count();
        Log::info("Nb of rangs", ['count', $a]);

        $optionRanges = '';
        for($i=1; $i<=$a;$i++) {
            if ($i == intval($data->rangAttente)) {
                $optionRanges  = $optionRanges.'<option selected>'.$data->rangAttente.'</option>';
            } else {
                $optionRanges  = $optionRanges.'<option value="'.$i.'">'.$i.'</option>';
            }
        }

        $html = '<div class="form-group">
                    <label for="rangAttente">Rang attente</label>
                    <select class="form-control" id="rangAttente" name="rangAttente">'.
                    $optionRanges
                    .'</select>
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
        //
    }
}
