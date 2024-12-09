<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo', 
        'cliente_id', 
        'idade', 
        'descricao', 
        'data', 
        'horario', 
        'status'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function profissional()
    {
        return $this->belongsTo(User::class);
    }

}


// <!-- OS MODELS ESTABELECEM A COMUNICAÇÃO DO BANCO COM A NOSSA APLICAÇÃO POR MEIO DA ORM ELOQUENT! -->