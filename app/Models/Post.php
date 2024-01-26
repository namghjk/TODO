<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Post extends Model implements HasMedia
{
    use  HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'content',
        'publish_date',
        'status',
    ];

    protected $dates = [
        'publish_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $attributes = [
        'slug' => '', // Đặt giá trị mặc định là một chuỗi trống
    ];

    public function getPublishDateFormattedAttribute()
    {
        return $this->publish_date->format('y/m/d');
    }


    public function getThumbnailAttribute()
    {
        if ($this->hasMedia('thumbnails')) {
            return $this->getFirstMediaUrl('thumbnails');
        }

        return asset('app/public/thumbnails/default.png');
    }

    public function scopeStatusNewPost($query, $status = 0)
    {
        return $query->where('status', $status);
    }

    public function scopeStatusUpdatePost($query, $status = 1)
    {
        return $query->where('status', $status);
    }
}
