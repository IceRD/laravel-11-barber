<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "login",
        "name",
        "password",
        "role",
        "is_disabled",
        "last_activity",
        "partner_id"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        "password",
        "remember_token",
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    /**
     * Список ролей
     *
     * @var array<string, string>
     */
    protected $roles = [
        'user' => 'user',
        'admin' => 'admin',
        'sysadmin' => 'sysadmin',
    ];


    /**
     * Если авторизированный пользователь имеет роль пользователь
     *
     * @return boolean
     */
    public function isUser(): bool {
        return $this->role == $this->roles['user'];
    }

    /**
     * Если авторизированный пользователь имеет роль администратор
     *
     * @return boolean
     */
    public function isAdmin(): bool {
        return $this->role == $this->roles['admin'];
    }

    /**
     * Если авторизированный пользователь имеет роль системный администратор
     *
     * @return boolean
     */
    public function isSysAdmin(): bool {
        return $this->role == $this->roles['sysadmin'];
    }

}
