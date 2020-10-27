<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Schedule
 *
 * @property int $id
 * @property int $section_id
 * @property mixed $school_year
 * @property int $semester
 * @property \Illuminate\Support\Carbon $date
 * @property int $whole_day
 * @property mixed|null $start
 * @property mixed|null $end
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $html_status
 * @property-read mixed $readable_school_year
 * @property-read \App\Models\Section $section
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSchoolYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereWholeDay($value)
 * @mixin \Eloquent
 * @property-read mixed $readable_semester
 */
class Schedule extends Model
{
    use HasFactory;

    protected $table = 'eval_schedules';

    protected $guarded = [];

    protected $appends = [
        'html_status',
        'readable_school_year',
        'readable_semester',
    ];

    protected $casts = [
        'start' => 'datetime:h:i A',
        'end' => 'datetime:h:i A',
        'date' => 'date:M j, Y',
    ];

    public function getHtmlStatusAttribute()
    {
        return [
            0 => '<label class="badge badge-secondary mb-0">Inactive</label>',
            1 => '<label class="badge badge-success mb-0">Active</label>'
        ][$this->status] ?? '<label class="badge badge-danger mb-0">Unknown Status: ' . $this->status . '</label>';
    }

    public function getReadableSemesterAttribute()
    {
        return [
            1 => '1st Semester',
            2 => '2nd Semester',
        ][$this->semester] ?? 'Unknown Semester: ' . $this->semester;
    }

    public function getReadableSchoolYearAttribute()
    {
        return $this->school_year . ' - ' . Carbon::createFromFormat('Y', $this->school_year)->addYear()->format('Y');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
