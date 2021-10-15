<?php

namespace App\Models\Media;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Media\MediaTemp
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|MediaTemp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaTemp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaTemp query()
 * @method static \Illuminate\Database\Eloquent\Builder|MediaTemp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaTemp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MediaTemp whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MediaTemp extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
}
