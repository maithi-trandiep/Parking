<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reservation extends Model
{
    use HasFactory;
    protected $table='reservation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'place_id',
        'statutR',
        'dateDemande',
        'dateMAJ',
        'dateDebut',
        'dateFin',
    ];

    public function user()
    {
        return $this->belongsTo('users');
    }

    public function getData()
    {
        $user_id = Auth::user()->id;
        $user_reservation = Reservation::where('user_id', $user_id)->leftJoin('users', 'users.id', '=', 'reservation.user_id')->orderBy('dateDemande', 'desc')->get();
        return $user_reservation;
        // return static::orderBy('dateDemande','desc')->where('user_id', $user_id)->get();
    }

    public function getDataAll()
    {
        return static::orderBy('dateDemande','desc')->get();
    }

    public function getDataWaitList()
    {
        $wait_list = Reservation::where('statutR', 0)->leftJoin('users', 'users.id', '=', 'reservation.user_id')->orderBy('dateDemande','desc')->get();
        return $wait_list;
        // return static::orderBy('dateDemande','desc')->where('statutR', 0)->get();
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function storeData($input)
    {
    	return static::create($input);
    }

    public function updateData($id, $input)
    {
        return static::find($id)->update($input);
    }

    public function deleteData($id)
    {
        return static::find($id)->delete();
    }
}
