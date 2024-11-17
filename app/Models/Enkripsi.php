<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Enkripsi extends Model
{
    use Notifiable;
    protected $guarded = ['id'];
}
