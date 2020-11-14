<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'description', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function (self $user) {
            if(! $user->avatar) {
                $user->avatar = $user->getAvatarUrl();
            }
        });
    }

    public function getAvatarUrl(string $default = 'mp', int $size = 80)
    {
        return sprintf(
            'https://www.gravatar.com/avatar/%s?d=%s&s=%s',
            md5(strtolower(trim($this->email))), urldecode($default), $size
        );
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function setAvatarAttribute($avatar)
    {
        $this->attributes['avatar'] = $avatar instanceof UploadedFile
            ? Storage::url($avatar->store('avatars'))
            : $avatar;
    }

    public function posts()
    {
        $this->hasMany(Post::class, 'author_id');
    }
}
