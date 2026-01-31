<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_title',
        'banner_subtitle',
        'banner_description',
        'banner_type',
        'banner_image',
        'banner_video_url',
        'banner_button_text',
        'banner_button_link',
        'banner_position',
        'banner_order',
        'banner_status',
        'start_date',
        'end_date',
    ];
}
