<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function categories(){
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
