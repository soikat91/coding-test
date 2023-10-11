<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name','account_type','email','password','otp','remember_token','balance'];
    protected $attributes = [
        'otp' => '0',
        'balance' => '0',
        'remember_token'=>'0'
    ];  
}
