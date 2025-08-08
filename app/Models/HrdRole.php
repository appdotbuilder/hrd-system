<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\HrdRole
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string|null $description
 * @property array|null $permissions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrdEmployee> $employees
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole wherePermissions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdRole whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class HrdRole extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'permissions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the employees that belong to this role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(HrdEmployee::class, 'role_id');
    }
}