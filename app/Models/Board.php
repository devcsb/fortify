<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Board
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $title
 * @property string $content
 * @property string|null $file_name
 * @property string|null $file_path
 * @property string|null $notice_flag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BoardFile[] $files
 * @property-read int|null $files_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BoardFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Board newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Board newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Board query()
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereNoticeFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Board whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
