<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;
    protected $fillable = ["label", "color"];

    public function projects()
    {
        // le tecnologie appartengono a molti progetti
        return $this->belongsToMany(Project::class);
    }
}
