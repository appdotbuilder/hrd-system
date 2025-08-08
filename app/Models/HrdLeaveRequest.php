<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\HrdLeaveRequest
 *
 * @property int $id
 * @property int $employee_id
 * @property int $leave_type_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property int $total_days
 * @property string $reason
 * @property string $status
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property string|null $approval_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HrdEmployee $employee
 * @property-read \App\Models\HrdLeaveType $leaveType
 * @property-read \App\Models\User|null $approver
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereApprovalNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereLeaveTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereTotalDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdLeaveRequest pending()

 * 
 * @mixin \Eloquent
 */
class HrdLeaveRequest extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_leave_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'approved_by',
        'approved_at',
        'approval_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_days' => 'integer',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the employee who requested this leave.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(HrdEmployee::class, 'employee_id');
    }

    /**
     * Get the leave type for this request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(HrdLeaveType::class, 'leave_type_id');
    }

    /**
     * Get the user who approved this request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scope a query to only include pending requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}