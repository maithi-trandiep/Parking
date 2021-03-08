<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Place;

class MakeReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reservations.userReservation');
    }

    /**
     * Get the data for listing in yajra.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getReservations(Request $request, Reservation $reservation)
    {
        $data = $reservation->getData();
        return DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm btnDelete" id="btnDelete-'.$data->id.'">Annuler</button>';
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Reservation $reservation)
    {
        $user_id = Auth::user()->id;
        $user_att = Reservation::select('user_id')->where('user_id', $user_id)->first();
        if( is_null($user_att) ) {
            $place_att = Place::select('id')->where('statutP', 0)->inRandomOrder()->first();
        if( is_null($place_att) ) {
        DB::table('reservation')->insert([
            'user_id' => $user_id,
            'statutR' => 0,
        ]);
        }else {
        DB::table('reservation')->insert([
            'user_id' => $user_id,
            'place_id' => $place_att->id,
            'statutR' => 1,
            'dateDebut' => \Carbon\Carbon::now(),
            'dateFin' => \Carbon\Carbon::now()->addDays(7)
        ]);

        DB::table('place')->where('id', $place_att->id)->update(['statutP' => 1]);
        }
        
        return redirect()->back()->with('message', 'Réservation a été faite avec succès.');
            
        }
        else {
            return redirect()->back()->with('message', 'Vous avez déjà occupé une place, veuillez annuller si vous souhaitez refaire la réservation !');
    }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $temp = Reservation::select('id', 'place_id')->where('id', $id)->first();
        $reservation = new Reservation;
        $reservation->deleteData($id);

        DB::table('place')->where('id', $temp->place_id)->update(['statutP' => 0]);

        return response()->json(['success'=>'Place deleted successfully']);
    }
}
