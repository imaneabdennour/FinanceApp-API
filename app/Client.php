<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'nom_entreprise';
    public $incrementing  = false;
    protected  $keyType = 'string';
}
