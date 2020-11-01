<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionCategory
 *
 * @property int $id
 * @property string $category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $question
 * @property-read int|null $question_count
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionCategory whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionCategory extends Model
{
    use HasFactory;

    protected $table = 'eval_question_categories';

    protected $guarded = [];

    public function question()
    {
        return $this->hasMany(Question::class, 'category_id', 'id');
    }
}
