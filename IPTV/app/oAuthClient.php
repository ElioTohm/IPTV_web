<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class oAuthClient extends Model
{
    protected $table = 'oauth_clients';
    protected $hidden = array('created_at', 'updated_at', 'user_id',
                            'name', 'password_client', 'personal_access_client', 'redirect');
    protected $fillable = ['assigned_to'];
}
