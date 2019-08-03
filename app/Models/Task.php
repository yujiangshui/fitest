<?php

namespace Fitest\Models;

use Illuminate\Database\Eloquent\Model;
use Fitest\Observers\TaskObserver;

class Task extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::observe(TaskObserver::class);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
