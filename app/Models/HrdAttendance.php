<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\HrdAttendance
 *
 * @property int $id
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon|null $check_in_time
 * @property \Illuminate\Support\Carbon|null $check_out_time
 * @property float|null $latitude_in
 * @property float|null $longitude_in
 * @property float|null $latitude_out
 * @property float|null $longitude_out
 * @property int|null $work_hours
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HrdEmployee $employee
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereCheckInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereCheckOutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereLatitudeIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereLatitudeOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereLongitudeIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereLongitudeOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdAttendance whereWorkHours($value)

 * 
 * @mixin \Eloquent
 */
class HrdAttendance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_attendance';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employee_id',
        'date',
        'check_in_time',
        'check_out_time',
        'latitude_in',
        'longitude_in',
        'latitude_out',
        'longitude_out',
        'work_hours',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'latitude_in' => 'decimal:8',
        'longitude_in' => 'decimal:8',
        'latitude_out' => 'decimal:8',
        'longitude_out' => 'decimal:8',
        'work_hours' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the employee this attendance record belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(HrdEmployee::class, 'employee_id');
    }
}