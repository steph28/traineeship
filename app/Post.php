<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Route;

class Post extends Model
{

    protected $casts = [
    'start_date' => 'datetime:d-m-Y',
    'end_date' => 'datetime:d-m-Y'
];
    protected $fillable = [
        'title',
        'description',
        'post_type',
        'start_date',
        'end_date',
        'price',
        'max_students',
        'status'
    ];



    // --------------------  Relations  --------------------
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function picture()
    {
        return $this->hasOne(Picture::class);
    }


    // -------------------- Getters --------------------

    public function getStatusAttribute($value)
    {
        if(Route::is('post.edit')) return $value;
        return __(ucfirst($value));
    }

    public function getPostTypeAttribute($value)
    {
        return ucfirst($value);
    }

/*    public function getStartDateAttribute($value)
    {
        return (new \DateTime($value))->format('d-m-Y');
    }

    public function getEndDateAttribute($value)
    {
        return (new \DateTime($value))->format('d-m-Y');
    }*/

    // --------------------  Scopes --------------------

    public function scopeClosest($query)
    {
        return $query->where('start_date', '>', (new \DateTime())->format('Y-m-d H:i:s'))->orderBy('start_date', 'ASC');
    }

    public function scopePublished($query)
    {
        return $query->where('status', '=', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', '=', 'draft');
    }

    public function scopeTrash($query)
    {
        return $query->where('status', '=', 'trash');
    }

    public function scopeNotTrash($query)
    {
        return $query->where('status', '!=', 'trash');
    }

    public function scopeStage($query)
    {
        return $query->where('post_type', '=', 'stage');
    }

    public function scopeFormation($query)
    {
        return $query->where('post_type', '=', 'formation');
    }
}
