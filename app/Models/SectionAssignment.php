<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
