<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'reference_number',
        'amount',
        'type',
        'method',
        'description',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'  => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public static function generateReference(): string
    {
        return 'UM-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}