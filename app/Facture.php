<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $primaryKey = 'num_commande';
    public $incrementing  = false;
    protected  $keyType = 'string';
}
