<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;  // ← Décommente cette ligne
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail  // ← Ajoute MustVerifyEmail
{
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_FORMATEUR = 'formateur';
    const ROLE_PARTICIPANT = 'participant';

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'language',
        'is_active',
        'last_activity_at',
        'email_verified_at',  // ← Ajoute ce champ
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
        'password' => 'hashed',
        'last_activity_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // ========== ROLE METHODS ==========
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isSuperAdmin()
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isFormateur()
    {
        return $this->role === self::ROLE_FORMATEUR;
    }

    public function isParticipant()
    {
        return $this->role === self::ROLE_PARTICIPANT;
    }

    public function getRoleLabel()
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => 'Super Administrateur',
            self::ROLE_ADMIN => 'Administrateur',
            self::ROLE_FORMATEUR => 'Formateur',
            self::ROLE_PARTICIPANT => 'Participant',
            default => 'Inconnu',
        };
    }

    // ========== EMAIL VERIFICATION ==========
    // Cette méthode est automatiquement appelée par Laravel
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }
}