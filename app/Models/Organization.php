<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'city',
        'postcode',
        'staff_count',
        'status',
        'activated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'activated_at' => 'datetime:Y-m-d',
    ];

    /* relationships */

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
