<?php

namespace App\Models;

use App\Presenters\contracts\Presentable;
use App\Presenters\Event\EventPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use Presentable, SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $presenter = EventPresenter::class;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'description',
        'title',
        'start_at',
        'end_at',
        'status'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'status' => 'boolean'
    ];

    /**
     * status of each event
     */
    const STATUS = [
        0, 1
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
