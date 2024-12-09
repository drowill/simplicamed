<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{

    use HasFactory;
    protected $fillable = [
        'id', 'name', 'cpf', 'telefone','endereco', 'tipo',
    ];

    public function consultas(){
        return $this->hasMany(ProfissionalConsulta::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'profissional_id');
    }

}
