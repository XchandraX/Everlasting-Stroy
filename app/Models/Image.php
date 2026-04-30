<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = [
        'title',
        'kategori_id',
        'deskription',
        'file_path',
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }
}
