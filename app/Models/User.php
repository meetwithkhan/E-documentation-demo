<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;



    protected $fillable = [
    'employee_id',
    'signature_path',
    'name',
    'email',
    'password',
    'department_id',
    'function_id',
    'designation_id',
];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function function()
    {
        return $this->belongsTo(DepartmentFunction::class, 'function_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new CustomVerifyEmail);
    }

    public static function generateEmployeeId(): string
    {
        $prefix = strtoupper(substr(config('brand.name'), 0, 3));
        $last   = static::whereNotNull('employee_id')
                        ->orderByDesc('id')
                        ->value('employee_id');

        if ($last) {
            $num = (int) substr($last, strlen($prefix)) + 1;
        } else {
            $num = 1;
        }

        return $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
    public function hasSignature(): bool
    {
        return !empty($this->signature_path) &&
            \Storage::disk('public')->exists($this->signature_path);
    }

    public function signatureUrl(): ?string
    {
        if (!$this->hasSignature()) return null;
        return \Storage::url($this->signature_path);
    }

    public function unreadNotificationCount(): int
    {
        return $this->unreadNotifications()->count();
    }
}