<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'legacy_id',
        'username',
        'fullname',
        'email',
        'phone',
        'status',
        'password',
        'password_algorithm',
        'level',
        'role',
        'about',
        'job',
        'country',
        'address',
        'profile_image',
        'image',
        'source',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'password_algorithm',
    ];

    protected $casts = [
        'legacy_id' => 'integer',
    ];

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName(): string
    {
        return '_id';
    }

    /**
     * Accessor for level/role compatibility
     */
    public function getLevelAttribute($value)
    {
        return $value ?? $this->attributes['role'] ?? 'consument';
    }

    /**
     * Accessor for role/level compatibility
     */
    public function getRoleAttribute($value)
    {
        return $value ?? $this->attributes['level'] ?? 'consument';
    }

    /**
     * Get avatar image URL with fallback to default asset
     */
    public function getAvatarUrlAttribute(): string
    {
        $image = $this->profile_image ?? $this->image;
        if ($image && file_exists(public_path('uploaded_img/' . $image))) {
            return asset('uploaded_img/' . $image);
        }
        return asset('Admin/assets/img/profile-img.jpg');
    }

    /**
     * Check if user has admin-level access
     */
    public function isAdmin(): bool
    {
        $role = strtolower($this->level);
        return in_array($role, ['admin', 'super admin']);
    }

    /**
     * Check if user has staff-level access (admin or staff)
     */
    public function isStaff(): bool
    {
        $role = strtolower($this->level);
        return in_array($role, ['admin', 'super admin', 'staff', 'marketing', 'customer service', 'executive']);
    }

    /**
     * Check if user is a customer
     */
    public function isCustomer(): bool
    {
        $role = strtolower($this->level);
        return in_array($role, ['customer', 'consument']);
    }

    /**
     * Get orders for this user
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Get cart items for this user
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }
}
