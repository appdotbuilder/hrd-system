<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\HrdWorkSchedule
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property int $break_duration
 * @property array $work_days
 * @property bool $is_flexible
 * @property int|null $flex_start_range
 * @property int|null $flex_end_range
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrdEmployeeSchedule> $employeeSchedules
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereBreakDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereFlexEndRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereFlexStartRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereIsFlexible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule whereWorkDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdWorkSchedule active()

 * 
 * @mixin \Eloquent
 */
class HrdWorkSchedule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_work_schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'break_duration',
        'work_days',
        'is_flexible',
        'flex_start_range',
        'flex_end_range',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'break_duration' => 'integer',
        'work_days' => 'array',
        'is_flexible' => 'boolean',
        'flex_start_range' => 'integer',
        'flex_end_range' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the employee schedules using this work schedule.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeSchedules(): HasMany
    {
        return $this->hasMany(HrdEmployeeSchedule::class, 'schedule_id');
    }

    /**
     * Scope a query to only include active schedules.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}