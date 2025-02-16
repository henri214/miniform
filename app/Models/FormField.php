<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = ['form_id', 'label', 'type', 'options', 'required', 'order'];

    protected $casts = [
        'required' => 'boolean',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
