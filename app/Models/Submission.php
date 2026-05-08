<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'user_id', 'register_type', 'form_data',
        'status', 'reviewed_by', 'review_data',
        'review_note', 'reviewed_at',
    ];

    protected $casts = [
        'form_data'   => 'array',
        'review_data' => 'array',
        'reviewed_at' => 'datetime',
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }

    public function isPending()  { return $this->status === 'pending'; }
    public function isApproved() { return $this->status === 'approved'; }
    public function isRejected() { return $this->status === 'rejected'; }

    // Get a specific field value from form_data
    public function field(string $key): mixed
{
    $value = $this->form_data[$key] ?? null;

    if ($value === null || $value === '') {
        return '—';
    }

    return $value;
}

    // Get review field value
    public function reviewField(string $key): mixed
    {
        return $this->review_data[$key] ?? '—';
    }

    // Get register config
    public function registerConfig(): array
    {
        return config("registers.{$this->register_type}", []);
    }

    // Get register display name
    public function registerName(): string
    {
        return $this->registerConfig()['name'] ?? ucfirst($this->register_type);
    }

    public static function nextSrNo(string $registerType): int
    {
        $last = static::where('register_type', $registerType)
            ->whereNotNull('form_data->sr_no')
            ->orderByRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(form_data, '$.sr_no')) AS UNSIGNED) DESC")
            ->first();

        if (!$last) return 1;

        $lastSrNo = (int) ($last->form_data['sr_no'] ?? 0);
        return $lastSrNo + 1;
    }
}