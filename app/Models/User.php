<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Models\HasEntity;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\returnArgument;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasEntity;



    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    //Role checking function

    public function isStudent(): bool
    {
        return $this->entity() instanceof Student ;
    }

    public function isTeacher(): bool
    {
        return $this->entity() instanceof Teacher;
    }

    public function isAdmin(): bool
    {
        return $this->entity() instanceof Admin;
    }

    //Profile Identity function

    public function getUserProfileName()
    {

        return $this->entity()?->name ?? 'Unknown';

    }

    public function getUserIdentifier()
    {
       return $this->entity() ? $this->email : 'Unknown';
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
