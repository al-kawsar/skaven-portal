<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Subject extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'guru_id');
    }
    public function class()
    {
        return $this->belongsTo(Classes::class, 'kelas_id');
    }
}
