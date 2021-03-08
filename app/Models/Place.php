<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $table='place';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libel',
        'statutP',
    ];

    public function getData()
    {
        return static::orderBy('created_at','desc')->get();
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
