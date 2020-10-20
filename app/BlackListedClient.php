<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackListedClient extends Model
{
    protected $fillable = ['accountName', 'clientType', 'institution', 'accountManager'];
}
