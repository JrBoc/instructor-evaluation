<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SectionAssignment
 *
 * @property int $section_id
 * @property int $subject_id
 * @property int $instructor_id
 * @property int $semester
 * @property-read \App\Models\Instructor|null $instructor
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\Subject|null $subject
 * @method static \Illuminate\Database\Eloquent\Builder|SectionAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SectionAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SectionAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder|SectionAssignment whereInstructorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SectionAssignment whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SectionAssignment whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SectionAssignment whereSubjectId($value)
 * @mixin \Eloquent
 */
class SectionAssignment extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = null;
    protected $table = 'eval_section_assignments';
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class, 'id', 'section_id');
    }

    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class, 'id', 'instructor_id');
    }
}
