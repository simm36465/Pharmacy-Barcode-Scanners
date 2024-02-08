<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ordanance extends Model
{
    use HasFactory;


    protected $casts = [
        // 'code' => 'json',
    ];

    protected $fillable = ['code','num_eng','total','total_r','user_id'];

    public function user() :BelongsTo {
        return $this->belongsTo(User::class) ;
    }
    public function gmr()   {
        
        return $this->belongsTo(Gmr::class,"code","CODE_EAN13");
    }

}
