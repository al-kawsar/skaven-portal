<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Laravel\Scout\Searchable;

class Student extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'nisn' => $this->nisn,
            'nis' => $this->nis,
        ];
    }

}
