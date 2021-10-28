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
//        self::query() // 모델 관계 정의할 때 사용
//        self::query()->join() // 조인을 할 때 쓰는 방법.
//        쿼리빌더, 엘로퀀트, self::query()함수 세 가지 방법이 있다.
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(BoardFile::class, 'board_id', 'id')->where('board_files.type', 'board')->orderBy('seq');
    }
}
