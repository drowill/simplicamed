<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Certifique-se de adicionar os campos que podem ser atualizados no array fillable
    protected $fillable = [
        'name', 'email', 'password', 'cpf', 'data_nascimento', 'endereco', 'telefone', 'permission_level', 'profissional_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function consultas(){
        return $this->hasMany(Consulta::class);
    }

    public function profissionalConsultas(){
        return $this->hasMany(ProfissionalConsulta::class);
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

}
