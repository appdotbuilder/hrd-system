<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\HrdLeaveType
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property int|null $max_days_per_year
 * @property bool $requires_approval
 * @property bool $is_paid
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrdLeaveRequest> $leaveRequests
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereMaxDaysPerYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereRequiresApproval($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveType active()

 * 
 * @mixin \Eloquent
 */
class HrdLeaveType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_leave_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'max_days_per_year',
        'requires_approval',
        'is_paid',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'max_days_per_year' => 'integer',
        'requires_approval' => 'boolean',
        'is_paid' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the leave requests for this type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(HrdLeaveRequest::class, 'leave_type_id');
    }

    /**
     * Scope a query to only include active leave types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}