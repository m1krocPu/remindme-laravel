<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'name',
        'tokenable_id',
        'tokenable_type',
        'token',
        'refresh_token',
        'expires_at',
        'created_at',
        'updated_at'
    ];

    /**
     * Scope a query to only include token with name access-token
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAccessToken($query)
    {
        return $query->where('name', 'access-token');
    }

    /**
     * @return MorphTo
     */
    public function tokenable()
    {
        return $this->morphTo();
    }
}
