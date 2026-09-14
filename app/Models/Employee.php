<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * Allowed gender values.
     */
    public const GENDERS = [
        'Laki-laki',
        'Perempuan',
    ];

    /**
     * Allowed education values.
     */
    public const EDUCATIONS = [
        'SMA/SMK',
        'D3',
        'S1',
        'S2',
        'S3',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'gender',
        'education',
        'age',
        'work_duration',
        'phone',
        'email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'work_duration' => 'integer',
        ];
    }
}

