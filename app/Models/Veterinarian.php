<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Veterinarian extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city',
        'zip_code',
        'practice_name',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('picture');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

}
