<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $table = 'keywords';

    protected $fillable = [
        'user_id',
        'keyword',
        'replace',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
