<?php

namespace Blood72\Riot\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

abstract class Model extends BaseModel
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /** @var array */
    protected array $aliasAttributes = [];

    /**
     * @param string|null $key
     * @return string
     */
    public function getClassFromConfig($key = null): string
    {
        if (is_null($key)) {
            $key = Str::snake(class_basename($this));
        }

        return config("riot-eloquent.tables.classes.$key");
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function convertAliasedAttributes(array $attributes): array
    {
        $aliases = $this->getAliasAttributeMapper();

        if (count($aliases)) {
            foreach ($attributes as $key => $value) {
                if (array_key_exists($key, $aliases)) {
                    $attributes[$aliases[$key]] = $value;

                    unset($attributes[$key]);
                }
            }
        }

        return $attributes;
    }

    /**
     * @return array
     */
    protected function getAliasAttributeMapper(): array
    {
        return $this->aliasAttributes;
    }

    /**
     * @param \DateTimeInterface|int|string|null $value
     */
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = $this->parseTimestamp($value);
    }

    /**
     * @param \DateTimeInterface|int|string|null $value
     */
    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = $this->parseTimestamp($value);
    }

    /**
     * @param  mixed  $value
     * @return \Illuminate\Support\Carbon
     */
    protected function parseTimestamp($value)
    {
        if (is_int($value)) {
            $time = strlen($value) < 13
                ? Carbon::createFromTimestamp($value)
                : Carbon::createFromTimestampMs($value);
        }

        return $this->asDateTime($time ?? $value);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes)
    {
        return parent::fill($this->convertAliasedAttributes($attributes));
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (is_array($value)) {
                $parameters[$key] = $this->convertAliasedAttributes($value);
            }
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (! $this->table) {
            $this->setTable(config('riot-eloquent.tables.prefix') . $this->getTable());
        }
    }
}
