<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    protected $fillable = [
        'nama_kategori',
        'cover_image', // tambahkan jika ada kolom cover
    ];

    public function Images()
    {
        return $this->hasMany(Image::class);
    }
}
