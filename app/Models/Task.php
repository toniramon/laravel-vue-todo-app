<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function categories(){
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
