<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderModel extends Model
{
    use HasFactory;

    protected $table = "tb_folder";
    protected $primaryKey = "folder_id";
    protected $fillable = [
        'user_id',
        'folder_nama',
        'folder_status',
    ];
}
