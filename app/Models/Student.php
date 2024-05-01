<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "major_id",
        "grade_id",
        "fullname",
        "phone",
        "status"
    ];

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function scopeSearch($query, $search = "")
    {
        $query->where('fullname', 'like', "%{$search}%");
    }
}
