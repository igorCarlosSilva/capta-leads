<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dadoslead extends Model
{
    protected $table = "dados_lead";

    protected $fillable = ['nome','email','sexo','telefone','cidade','estado','nomeempresa','cargo','origemcad'];
}
