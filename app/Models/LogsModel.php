<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsModel extends Model
{
    protected $table= "logs";
    protected $fillable = [
       'id',
       'iduser',
       'nombre',
       'ruta',
       'metodo',
       'ip',
       'created_at',
       'updated_at',
   ];
}
