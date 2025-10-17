<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $status
 */
class Task extends Model
{
    use HasFactory;
    public const STATUS_NEW = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_DONE = 2;

    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'status'
    ];


    public static function getAcceptStatuses(): array
    {
        return [self::STATUS_NEW, self::STATUS_IN_PROGRESS, self::STATUS_DONE];
    }

    public function getStatusText(): string
    {
        return match ($this->status) {
            self::STATUS_IN_PROGRESS => 'В процессе',
            self::STATUS_DONE => 'Выполнена',
            default => self::STATUS_NEW
        };
    }
}
