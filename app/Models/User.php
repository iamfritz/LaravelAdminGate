<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id');
    }    

    public function hasRole($roleName)
    {
        return $this->roles->pluck('name')->contains($roleName);
    }
    public function hasAdminAuthor()
    {    
        return $this->roles->pluck('name')->whereIn('name',['admin', 'author'])->count() > 0;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'author_id', 'id');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to', 'id');
    }    

}
