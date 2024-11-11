<?php

namespace MiniRest\Models;

use Illuminate\Database\Eloquent\Model;

class FacialRecognition extends Model
{
    // Defina a tabela, caso o nome da tabela não siga o padrão plural
    protected $table = 'facial_recognitions';

    // Defina os campos que são permitidos para inserção em massa
    protected $fillable = ['imagem_base64', 'posicoes','users_id'];

    // Caso você queira manipular o campo 'posicoes' como array
    protected $casts = [
        'posicoes' => 'array',  // As posições dos rostos podem ser armazenadas como JSON
    ];
}