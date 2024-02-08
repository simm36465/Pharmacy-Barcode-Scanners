<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gmr extends Model
{
    use HasFactory;
    //public $timestamps = false;
    protected $table = 'gmr';
    
    protected $fillable = ['CODE_EAN13','Nom_Commercial','DCI','Dosage','Presentation','PPV','PBR','PH','PBRH','Classe','remb','is_anam'];


    public function ordanace()  {
        

        return $this->hasMany(Ordanance::class,"code","CODE_EAN13");

    }

}
