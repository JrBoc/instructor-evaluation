<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'eval_students';

    protected $guarded = [];

    protected $appends =[
        'html_status',
    ];

    public function section()
    {
        return $this->hasOneThrough(
            Section::class,
            StudentSection::class,
            'student_id',
            'id',
            'id',
            'section_id',
        );
    }

    public function student_section()
    {
        return $this->hasOne(StudentSection::class);
    }

    public function getHtmlStatusAttribute()
    {
        return [
            0 => '<label class="badge badge-secondary mb-0">Inactive</label>',
            1 => '<label class="badge badge-success mb-0">Active</label>'
        ][$this->status] ?? '<label class="badge badge-danger mb-0">Unknown Status: ' . $this->status . '</label>';
    }
}
