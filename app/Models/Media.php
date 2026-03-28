<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'file_size'
    ];

    public function mediable() : MorphTo
    {
        return $this->morphTo();
    }
    protected $appends = [
        'file_url',
        'media_category',
        'human_file_size',
    ];

    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('storage/' . $this->attributes['file_path']),
        );
    }

    protected function mediaCategory(): Attribute
    {
        return Attribute::make(
            get: fn () => explode('/', $this->attributes['mime_type'])[0] ?? null,
        );
    }

    protected function humanFileSize(): Attribute
    {
        return Attribute::make(
            get: fn () => round($this->attributes['file_size'] / 1024 / 1024, 2) . ' MB',
        );
    }
}
