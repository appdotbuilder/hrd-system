<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\HrdPosition
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property int $department_id
 * @property string|null $description
 * @property float|null $min_salary
 * @property float|null $max_salary
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HrdDepartment $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrdEmployee> $employees
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereMaxSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereMinSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdPosition active()

 * 
 * @mixin \Eloquent
 */
class HrdPosition extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'code',
        'department_id',
        'description',
        'min_salary',
        'max_salary',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'min_salary' => 'decimal:2',
        'max_salary' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the department this position belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(HrdDepartment::class, 'department_id');
    }

    /**
     * Get the employees in this position.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(HrdEmployee::class, 'position_id');
    }

    /**
     * Scope a query to only include active positions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}