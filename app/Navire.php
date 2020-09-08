<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navire extends Model
{
    protected $primaryKey = 'nom_navire';
    public $incrementing  = false;
    protected  $keyType = 'string';
}
