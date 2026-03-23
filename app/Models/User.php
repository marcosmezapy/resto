<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\BelongsToTenant;
use App\Models\Sucursal;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;
   // use BelongsToTenant;
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

    public function cajaSesiones()
    {
        return $this->hasMany(CajaSesion::class,'usuario_id');
    }

    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }
    
    public function sucursales()
    {
        return $this->belongsToMany(Sucursal::class)
            ->withPivot(['tenant_id','es_principal','activo'])
            ->withTimestamps();
    }
}
