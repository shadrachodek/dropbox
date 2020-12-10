<?php

namespace App\Models;

use App\Traits\RelatedToTeams;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Obj extends Model
{
    use HasFactory, RelatedToTeams, HasRecursiveRelationships;

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

}
