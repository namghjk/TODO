<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;


class Post extends Model implements HasMedia
{
    use  HasFactory, InteractsWithMedia, SoftDeletes;

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

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($post) {
            if ($post->isDirty('status') && $post->status == 1) {
                $post->publish_date = Carbon::now();
            }
        });
    }

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
        $media = $this->getFirstMedia('thumbnail');

        if ($media) {
            $path = 'thumbnails/' . $media->id . '/' . $media->file_name;
            return asset($path);
        }

        return asset('thumbnails/default.png');
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
