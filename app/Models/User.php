<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

protected $fillable = [
    'name',
    'email',
    'phone', 
    'password',
    'is_admin',
];

    // Связи
    public function plants()
    {
        return $this->hasMany(Plant::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tips()
    {
        return $this->hasMany(Tip::class);
    }

    public function calendarEvents()
    {
        return $this->hasMany(CalendarEvent::class);
    }
    protected $hidden = [
    'password',
    'remember_token',
];
}