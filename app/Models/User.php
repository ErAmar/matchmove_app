<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str; #added

class User extends Authenticatable
{
    public function createApiToken()
    {
        $length = rand(8,24);
        $token = Str::random($length);
        $this->api_token = $token;
        $this->save();
        return $token;
    }
}
