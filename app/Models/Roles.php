<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'roles';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['name', 'slug','description','status'];

    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */
    protected $guarded = ['created_at', 'updated_at'];

    
}
