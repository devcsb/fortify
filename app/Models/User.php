<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    // 모든 속성들이 대량 할당이 가능하게 하고자 하려면 $guarded 프로퍼티를 빈 배열로 정의
    protected $guarded = [];

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'gender',
    //     'phone',
    //     'social_id',
    //     'social_type',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function testDatebase()
    // {
    //     $user = User::factory()->make();
    // }

    //일대다 관계 설정
    public function boards()
    {
        return $this->hasMany(Board::class, 'email');
    }
}
