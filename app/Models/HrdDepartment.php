<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\HrdDepartment
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property int|null $manager_id
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $manager
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrdEmployee> $employees
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrdPosition> $positions
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdDepartment active()

 * 
 * @mixin \Eloquent
 */
class HrdDepartment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'manager_id',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the department manager.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the employees in this department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(HrdEmployee::class, 'department_id');
    }

    /**
     * Get the positions in this department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions(): HasMany
    {
        return $this->hasMany(HrdPosition::class, 'department_id');
    }

    /**
     * Scope a query to only include active departments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}