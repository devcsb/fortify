<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BoardFile
 *
 * @property int $id
 * @property int $board_id
 * @property string $type
 * @property int $seq
 * @property string $file_name
 * @property string $file_path
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile whereBoardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BoardFile whereType($value)
 * @mixin \Eloquent
 */
class BoardFile extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
}
