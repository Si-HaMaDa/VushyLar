<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'bio',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $rules = [
        'name' => 'required|regex:/^[a-zA-Z.\s]*$/',
        'email' => 'required|email:rfc,dns|unique:users',
        'password' => 'required|min:6|max:20',
        'type' => 'required|in:admin,user,author',
        'bio' => 'required|regex:/^[a-zA-Z\s]*$/',
        'image' => 'nullable|file|image|between:1,6000',
    ];

    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => ucfirst($value),
            set: fn ($value) => \Hash::needsRehash($value) ? \Hash::make($value) : $value,
        );
    }
}
