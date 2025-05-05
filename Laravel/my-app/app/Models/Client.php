<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements JWTSubject
{
     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * 
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * 
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * 
     *
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * 
     *
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->role === 'client';
    }
    protected $fillable = ["first_name","last_name", "email","password","roles", "phone", "registration_date"];
}
