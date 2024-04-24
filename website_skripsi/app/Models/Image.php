<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'data',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Image::class)->using(ImageUser::class);
    }
}
