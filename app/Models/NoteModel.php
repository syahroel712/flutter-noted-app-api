<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteModel extends Model
{
    use HasFactory;

    protected $table = "tb_note";
    protected $primaryKey = "note_id";
    protected $fillable = [
        'user_id',
        'folder_id',
        'note_title',
        'note_desc',
        'note_status',
    ];
}
