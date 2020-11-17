<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\SortableTrait;

/**
 * App\Models\Question
 *
 * @property int $id
 * @property int $category_id
 * @property int $order_id
 * @property string $question
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\QuestionCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $group_id
 * @method static \Illuminate\Database\Eloquent\Builder|Question ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereGroupId($value)
 */
class Question extends Model
{
    use HasFactory, SortableTrait;

    protected $table = 'eval_questions';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_id = $model->getNewOrderId($model->group_id);
        });
    }

    public function getNewOrderId($group_id)
    {
        return optional($this->query()->where('group_id', $group_id)->latest()->first())->order_id + 1 ?? 1;
    }
}
