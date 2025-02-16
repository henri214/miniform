<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['user_id', 'title', 'content'];

    public $casts = ['content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }

    public function getContent()
    {
        $content = $this->content;
        if ($content == null) {
            return [];
        }
        $decodeContent = json_decode($content, true);
        if ($decodeContent == null) {
            return [];
        }
        if (! isset($decodeContent['contents'])) {
            return [];
        }

        return $decodeContent['contents'];
    }
}
