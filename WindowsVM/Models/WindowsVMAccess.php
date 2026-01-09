<?php

namespace App\Services\WindowsVM\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class WindowsVMAccess extends Model
{
    protected $table = 'windowsvm_access';

    protected $fillable = [
        'order_id',
        'status',
        'public_ip',
        'rdp_port',
        'username',
        'password_encrypted',
        'notes',
        'ready_at',
        'updated_by',
    ];

    protected $casts = [
        'ready_at' => 'datetime',
    ];

    public function setPasswordAttribute(?string $value): void
    {
        $this->attributes['password_encrypted'] = $value ? Crypt::encryptString($value) : null;
    }

    public function getPasswordAttribute(): ?string
    {
        if (!$this->password_encrypted) return null;
        try {
            return Crypt::decryptString($this->password_encrypted);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
