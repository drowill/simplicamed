<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfissionalConsulta extends Model
{
    use HasFactory;

    protected $table = 'profissional_consulta';

    protected $fillable = [
        'user_id',
        'profissional_id',
        'consulta_id',
        'status',
    ];

    // Relação com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relação com o modelo Profissional
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    // Relação com o modelo Consulta
    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
    
}
