<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $table = 'coaches'; // Specify the table name
    protected $fillable = ['class_name', 'coach_name']; // Define fillable fields
}