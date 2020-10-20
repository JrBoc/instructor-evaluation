<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
