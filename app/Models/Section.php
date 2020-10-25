<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Section
 *
 * @property int $id
 * @property int $grade
 * @property string $name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SectionAssignment[] $assignments
 * @property-read int|null $assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SectionAssignment[] $first_semester_assignments
 * @property-read int|null $first_semester_assignments_count
 * @property-read mixed $html_status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SectionAssignment[] $second_semester_assignments
 * @property-read int|null $second_semester_assignments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Section whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Section extends Model
{
    use HasFactory;

    protected $table = 'eval_sections';
    protected $guarded = [];
    protected $appends = [
        'html_status'
    ];

    public function first_semester_assignments()
    {
        return $this->hasMany(SectionAssignment::class, 'section_id', 'id')->where('semester', 1);
    }

    public function second_semester_assignments()
    {
        return $this->hasMany(SectionAssignment::class, 'section_id', 'id')->where('semester', 2);
    }

    public function assignments()
    {
        return $this->hasMany(SectionAssignment::class, 'section_id', 'id');
    }

    public function getHtmlStatusAttribute()
    {
        return [
            0 => '<label class="badge badge-secondary mb-0">Inactive</label>',
            1 => '<label class="badge badge-success mb-0">Active</label>'
        ][$this->status] ?? '<label class="badge badge-danger mb-0">Unknown Status: ' . $this->status . '</label>';
    }
}
