<?php

namespace App\Models;

use App\Helpers\EasyCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string|null $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property string $key
 * @property int $type
 * @property string|null $value_when_string
 * @property string|null $value_when_long_text
 * @property AsCollection|null $value_when_json
 * @property bool|null $value_when_boolean
 * @property string|null $value_when_number
 * @property bool $active
 * @property bool $can_be_deleted
 * @method static \Database\Factories\SettingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCanBeDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValueWhenBoolean($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValueWhenJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValueWhenLongText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValueWhenNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValueWhenString($value)
 * @property-read mixed $formated_value
 * @property-read mixed $formated_value_hide_long_values
 * @property-read string $value_as_text
 * @property-read mixed $value
 * @mixin \Eloquent
 */
class Setting extends Model
{
    use HasFactory;

    public const TYPE_STRING = 1;
    public const TYPE_BOOLEAN = 2;
    public const TYPE_NUMBER = 3;
    public const TYPE_JSON = 4;
    public const TYPE_COLLECTION = 5;
    public const TYPE_LONG_TEXT = 6;
    public const TYPE_RICH_TEXT = 7;

    public static int $maxLengthOfLongValues = 50;

    protected $fillable = [
        'site_id',
        'name',
        'key',
        'type',
        'value_when_string',
        'value_when_long_text',
        'value_when_rich_text',
        'value_when_json',
        'value_when_boolean',
        'value_when_number',
        'active',
        'can_be_deleted',
    ];

    protected $casts = [
        'value_when_json' => AsCollection::class,
        'value_when_boolean' => 'boolean',
        'active' => 'boolean',
        'can_be_deleted' => 'boolean',
    ];

    protected $appends = [
        'value',
    ];

    public function getValueAttribute()
    {
        return $this->getFormatedValueAttribute();
    }

    public function getValueAsTextAttribute(): string
    {
        try {
            return (string) $this->getFormatedValueAttribute();
        } catch (\Throwable $th) {
            \Log::error($th);

            return '';
        }
    }

    public function getFormatedValueHideLongValuesAttribute()
    {
        return $this->getFormatedValueAttribute(true);
    }

    public function getFormatedValueExceptCollection()
    {
        try {
            return (string) $this->getFormatedValueAttribute();
        } catch (\Throwable $th) {
            \Log::error($th);

            return '...';
        }
    }

    public function getFormatedValueAttribute(?bool $isHideLongValues = false)
    {
        $maxLengthOfLongValues = static::$maxLengthOfLongValues;

        $maxLengthOfLongValues = $maxLengthOfLongValues >= 0 ? $maxLengthOfLongValues : 50;

        return match ($this->type) {
            Setting::TYPE_STRING => $isHideLongValues
                ? str($this->value_when_string)->limit($maxLengthOfLongValues, '...')->toString()
                : $this->value_when_string,

            Setting::TYPE_BOOLEAN => $this->value_when_boolean ? 'true' : 'false',

            Setting::TYPE_NUMBER  => $isHideLongValues
                ? str(
                    \is_numeric($this->value_when_number) ? (string) $this->value_when_number : ''
                )->limit($maxLengthOfLongValues, '...')->toString()
                : $this->value_when_long_text,

            Setting::TYPE_COLLECTION, Setting::TYPE_JSON => $isHideLongValues
                ? '' : EasyCollection::make($this->value_when_json),

            Setting::TYPE_LONG_TEXT => $isHideLongValues
                ? str($this->value_when_long_text)->limit($maxLengthOfLongValues, '...')->toString()
                : $this->value_when_long_text,

            Setting::TYPE_RICH_TEXT => $isHideLongValues
                ? str($this->value_when_long_text)->limit($maxLengthOfLongValues, '...')->toString()
                : $this->value_when_long_text,

            default => '',
        };
    }
}
