<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\HrdEmployeeSchedule
 *
 * @property int $id
 * @property int $employee_id
 * @property int $schedule_id
 * @property \Illuminate\Support\Carbon $effective_from
 * @property \Illuminate\Support\Carbon|null $effective_to
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HrdEmployee $employee
 * @property-read \App\Models\HrdWorkSchedule $schedule
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule whereEffectiveFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule whereEffectiveTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule whereScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployeeSchedule active()

 * 
 * @mixin \Eloquent
 */
class HrdEmployeeSchedule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_employee_schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employee_id',
        'schedule_id',
        'effective_from',
        'effective_to',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'effective_from' => 'date',
        'effective_to' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the employee this schedule assignment belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(HrdEmployee::class, 'employee_id');
    }

    /**
     * Get the work schedule for this assignment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(HrdWorkSchedule::class, 'schedule_id');
    }

    /**
     * Scope a query to only include active schedule assignments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}