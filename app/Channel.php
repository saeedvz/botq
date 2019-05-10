<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table = 'channels';

    protected $fillable = [
        'user_id',
        'name',
        'username',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function channel_users()
    {
        return $this->hasMany('App\ChannelUser');
    }
}
