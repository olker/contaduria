<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

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
        'membership_status',     // <-- ¡Asegúrate de que esté aquí!
        'membership_expires_at', // <-- y este también si lo usas
        'is_admin',              // <-- y este para los administradores
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'membership_expires_at' => 'date',
    ];

    /**
     * La membresía vence al finalizar el día indicado.
     * Una fecha nula significa que no se configuró vencimiento.
     */
    public function hasActiveMembership(): bool
    {
        if ($this->is_admin) {
            return true;
        }

        if ($this->membership_status !== 'active') {
            return false;
        }

        if (!$this->membership_expires_at) {
            return true;
        }

        return Carbon::today()->lessThanOrEqualTo(
            Carbon::parse($this->membership_expires_at)->startOfDay()
        );
    }

    public function membershipIsExpired(): bool
    {
        if ($this->membership_status === 'expired') {
            return true;
        }

        return $this->membership_status === 'active'
            && !empty($this->membership_expires_at)
            && Carbon::today()->greaterThan(
                Carbon::parse($this->membership_expires_at)->startOfDay()
            );
    }

    // Relación con la Empresa
   public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id');
    }
}