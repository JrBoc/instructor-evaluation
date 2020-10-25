<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StudentSection
 *
 * @property int $student_id
 * @property int $section_id
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSection query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSection whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentSection whereStudentId($value)
 * @mixin \Eloquent
 */
class StudentSection extends Model
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    protected $table = 'eval_student_sections';

    protected $primaryKey = null;

    public function student()
    {
        return $this->belongsTo(Student::class, 'id', 'student_id');
    }
}
