<?php

namespace Blood72\Riot\Models;

/**
 * @property string $id
 * @property string $puuid
 * @property string $account_id
 * @property \Illuminate\Foundation\Auth\User|null $user_id
 * @property string $name
 * @property int $icon
 * @property int $level
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Summoner extends Model
{
    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'puuid', 'account_id', 'name', 'icon', 'level', 'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime',
    ];

    /** @var array */
    protected array $aliasAttributes = [
        'accountId' => 'account_id',
        'profileIconId' => 'icon',
        'summonerLevel' => 'level',
        'revisionDate' => 'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        if (! config('riot-eloquent.tables.connect_with_user_model')) {
            return null;
        }

        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function matches()
    {
        $pivotClass = $this->getClassFromConfig('match_reference');

        return $this->belongsToMany($this->getClassFromConfig('match_info'), app($pivotClass)->getTable())
            ->using($pivotClass)
            ->withPivot('champion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function references()
    {
        return $this->hasMany($this->getClassFromConfig('match_reference'), 'summoner_id');
    }
}
