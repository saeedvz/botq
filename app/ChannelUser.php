<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelUser extends Model
{
    protected $table = 'channel_users';

    protected $fillable = [
        'channel_id',
        'username',
    ];

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }
}
