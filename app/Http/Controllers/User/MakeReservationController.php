<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
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
            
            //$rangAttente = Reservation::select('statutR')->selectRaw('count(statutR) as rangAttente')->where('statutR', 0)->groupBy('statutR');
            $rang = DB::table('reservation')->where('statutR', 0)->count();
            $myRang = 1;
            if ($rang > 0) $myRang = $rang+1;

            DB::table('reservation')->insert([
                'user_id' => $user_id,
                'statutR' => 0,
            ]);
            DB::table('users')->where('id', $user_id)->update(['rangAttente' => $myRang]);
            return redirect()->back()->with('warning', "Il n'y a plus de place, vous êtes dans la liste d'attente.");

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
            return redirect()->back()->with("warning", "Vous avez déjà occupé une place, veuillez l'annuler si vous souhaitez refaire la réservation !");
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
    public function destroy($id, User $user)
    {
        $temp = Reservation::select('id', 'user_id', 'place_id', 'statutR')->where('id', $id)->first();
        $reservation = new Reservation;
        $reservation->deleteData($id);
        //Log::info("test delete place for user:", ['user', $temp->user_id]);
        //Log::info("test delete place:", ['place', $temp->place_id]);

        if ($temp->statutR > 0) {
            // update reservation
            $rangAttente = DB::table('users')->min('rangAttente');
            $affected = DB::table('reservation as r')->leftJoin('users as u', 'u.id', '=', 'r.user_id')->where('r.statutR', '=', 0)->where('u.rangAttente', '=', $rangAttente)
            ->update([
                'r.statutR' => 1, 
                'r.place_id' => $temp->place_id,
                'r.dateDebut' => \Carbon\Carbon::now(),
                'r.dateFin' => \Carbon\Carbon::now()->addDays(7)
            ]);
            // Log::info("Nb of affected rows:", ['rows', $affected]);

            // no waiting list to update, just release place
            if ($affected < 1) {
                // Log::info("no waiting list, just release place.");
                DB::table('place')->where('id', $temp->place_id)->update(['statutP' => 0]);
            } else {
                // update rangAttente for user
                // move other user's rang
                $users = User::select('id', 'rangAttente')->whereNotNull('rangAttente')->get();
                foreach($users as $user) {
                    //Log::info("update rang for user:", ['user_id', $user->id]);
                    //Log::info("current user rang:", ['range', $user->rangAttente]);
                    $newRang = intval($user->rangAttente)-1;
                    if ($newRang == 0) $newRang = null;
                    // Log::info("update user rang:", ['range', $newRang]);
                    DB::table('users')->where('id', $user->id)->update(['rangAttente' => $newRang]);
                }
            }
        } else {
            // update place
            DB::table('users')->where('id', $temp->user_id)->update(['rangAttente' => null]);
        }

        return response()->json(['success'=>'Place deleted successfully: ']);
    }
}
