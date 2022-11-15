<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class navigation extends Model
{
    use HasFactory;
    protected $fillable = [
        'navLogoImage',
        'navPhoneNumber',
        'navAddress',
        'nav_status'
    ];
}