<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Instructor
 *
 * @property int $id
 * @property string|null $title Dr/Mr/Mrs
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $profile_photo
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $formatted_full_name
 * @property-read mixed $html_status
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instructor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
