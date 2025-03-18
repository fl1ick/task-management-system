<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boards extends Model
{
    use HasFactory;

    protected $table = 'tbl_boards'; // Sesuaikan dengan tabel di database

    protected $fillable = ['name', 'description','user_id']; // Sesuaikan dengan kolom yang ada

    public function tasks()
    {
        return $this->hasMany(Task::class, 'board_id');
    }
}
