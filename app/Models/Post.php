<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug, HasFactory, InteractsWithMedia;

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

    protected $attributes = [
        'slug' => '', // Đặt giá trị mặc định là một chuỗi trống
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title') // Đổi 'name' thành 'title'
            ->saveSlugsTo('slug');
    }

    public function createSlug(SlugOptions $options): string
    {
        return $this->slug ?? $this->generateSlug($options);
    }

    public function getThumbnailAttribute()
    {
        if ($this->hasMedia('thumbnails')) {
            return $this->getFirstMediaUrl('thumbnails');
        }

        return '/public/thumbnail/default.png';
    }

    public function scopeByStatus($query, $status = 0)
    {
        return $query->where('status', $status);
    }
}
