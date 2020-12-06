<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Obj extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
    ];
    public $table = 'objects';

    public function objectable(){
        return $this->morphTo();
    }

    public static function booted()
    {
        parent::booted();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function children() {
        return $this->hasMany(Obj::class, 'parent_id', 'id');
    }
}
