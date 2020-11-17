<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionGroup
 *
 * @property int $id
 * @property int $order_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Question[] $questions
 * @property-read int|null $questions_count
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionGroup whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuestionGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionGroup extends Model
{
    use HasFactory;

    protected $table = 'eval_question_groups';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_id = $model->getNewOrderId();
        });
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'group_id', 'id')->orderBy('order_id', 'asc');
    }

    public function getNewOrderId()
    {
        return optional($this->query()->latest()->first())->order_id + 1 ?? 1;
    }
}
