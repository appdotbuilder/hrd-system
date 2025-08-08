<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\HrdEmployee
 *
 * @property int $id
 * @property int $user_id
 * @property string $employee_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $emergency_contact_name
 * @property string|null $emergency_contact_phone
 * @property int|null $department_id
 * @property int|null $position_id
 * @property int $role_id
 * @property \Illuminate\Support\Carbon $hire_date
 * @property \Illuminate\Support\Carbon|null $termination_date
 * @property string $employment_status
 * @property float|null $salary
 * @property string|null $profile_photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\HrdDepartment|null $department
 * @property-read \App\Models\HrdPosition|null $position
 * @property-read \App\Models\HrdRole $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrdAttendance> $attendance
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HrdLeaveRequest> $leaveRequests
 * @property-read string $full_name
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereEmergencyContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereEmergencyContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereEmploymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereHireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereTerminationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HrdEmployee active()

 * 
 * @mixin \Eloquent
 */
class HrdEmployee extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hrd_employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'employee_id',
        'first_name',
        'last_name',
        'phone',
        'birth_date',
        'gender',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'department_id',
        'position_id',
        'role_id',
        'hire_date',
        'termination_date',
        'employment_status',
        'salary',
        'profile_photo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'termination_date' => 'date',
        'salary' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user associated with this employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department this employee belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(HrdDepartment::class, 'department_id');
    }

    /**
     * Get the position this employee holds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(HrdPosition::class, 'position_id');
    }

    /**
     * Get the role this employee has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(HrdRole::class, 'role_id');
    }

    /**
     * Get the attendance records for this employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendance(): HasMany
    {
        return $this->hasMany(HrdAttendance::class, 'employee_id');
    }

    /**
     * Get the leave requests for this employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(HrdLeaveRequest::class, 'employee_id');
    }

    /**
     * Get the employee's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Scope a query to only include active employees.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('employment_status', 'active');
    }
}