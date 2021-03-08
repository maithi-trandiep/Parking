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

    public function getData()
    {
        $user_id = Auth::user()->id;
        return static::orderBy('dateDemande','desc')->where('user_id', $user_id)->get();
    }

    public function getDataAll()
    {
        return static::orderBy('dateDemande','desc')->get();
    }

    public function getDataWaitList()
    {
        return static::orderBy('dateDemande','desc')->where('statutR', 0)->get();
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
