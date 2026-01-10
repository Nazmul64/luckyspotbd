<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
   protected $fillable = ['question', 'answer', 'title', 'description'];

 protected $casts = [
    'title' => 'array',
    'description' => 'array',
    'question' => 'array',
    'answer' => 'array',
];


    // helper for frontend/admin
    public function getQuestion($lang = 'en')
    {
        return $this->question[$lang] ?? '';
    }

    public function getAnswer($lang = 'en')
    {
        return $this->answer[$lang] ?? '';
    }
}
