<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'title',
        'content',
        'file_name',
        'file_path',
        'notice_flag',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class,'board_id','id')->where('files.type','board')->orderBy('seq');
    }
}
