<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'name', 'type', 'options'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
