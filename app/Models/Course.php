<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
class Course extends Model
{
    use HasFactory, Authorizable;

    protected $fillable = ['title', 'description', 'user_id'];


    protected $appends = ['update'];

    protected static function booted()
    {
//        parent::booted(); // TODO: Change the autogenerated stub
        static::creating(function ($course) {
            $course->user_id = auth()->user()->id;
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUpdateAttribute() {
        return $this->can('update-course', $this);
    }
}
