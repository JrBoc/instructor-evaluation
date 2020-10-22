<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
