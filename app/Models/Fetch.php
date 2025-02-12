<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Fetch extends Model
{
    protected static function booted()
    {
        static::creating(function (Model $model) {
            $model->slug = Str::slug($model->name) != '' ? Str::slug($model->name) : 'wtf';
            $model->password = Str::random(32);
        });
    }

    public function page(): string
    {
        return route('list.page', ['slug' => $this->slug, 'password' => $this->password]);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
