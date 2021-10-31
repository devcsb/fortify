<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Qnaboard
 *
 * @property int $id
 * @property string $author
 * @property string $password
 * @property string $title
 * @property string $content
 * @property int $hits
 * @property int $secret_flag 공개글:0, 비밀글:1(checkbox checked값)
 * @property int|null $group 부모글 번호로 그루핑
 * @property int|null $step 계층 정보
 * @property int|null $indent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard query()
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereHits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereIndent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereSecretFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Qnaboard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Qnaboard extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
