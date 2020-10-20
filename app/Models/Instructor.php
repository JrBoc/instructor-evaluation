<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $table = 'eval_instructors';

    protected $guarded = [];

    protected $appends = [
        'html_status',
        'formatted_full_name',
    ];

    public function getFormattedFullNameAttribute()
    {
        return $this->title . ' ' . strtoupper($this->last_name) . ', ' . strtoupper($this->first_name) . (($this->middle_name) ? ' ' . substr($this->middle_name, 0, 1) . '.' : '');
    }

    public function getHtmlStatusAttribute()
    {
        return [
            0 => '<label class="badge badge-secondary mb-0">Inactive</label>',
            1 => '<label class="badge badge-success mb-0">Active</label>'
        ][$this->status] ?? '<label class="badge badge-danger mb-0">Unknown Status: ' . $this->status . '</label>';
    }
}
