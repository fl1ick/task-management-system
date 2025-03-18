<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tbl_tasks'; // Sesuaikan dengan tabel di database

    protected $fillable = ['title', 'description', 'board_id', 'due_date', 'status'];

    public function board()
    {
        return $this->belongsTo(Boards::class, 'board_id');
    }
}
