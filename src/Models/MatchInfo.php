<?php

namespace Blood72\Riot\Models;

/**
 * @property int $id
 * @property string $platform
 * @property int $season
 * @property int $queue
 * @property int $map
 * @property string $game_type
 * @property string $game_mode
 * @property string $version
 * @property array|\Illuminate\Support\Collection $teams
 * @property array|\Illuminate\Support\Collection $participants
 * @property array|\Illuminate\Support\Collection $participant_identities
 * @property int $duration
 * @property \Illuminate\Support\Carbon $created_at
 */
class MatchInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id', 'platform', 'season', 'queue', 'map',
        'game_type', 'game_mode', 'version', 'duration', 'created_at',
        'teams', 'participants', 'participant_identities',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'teams' => 'json',
        'participants' => 'json',
        'participant_identities' => 'json',
        'created_at' => 'datetime',
    ];

    /** @var array */
    protected array $aliasAttributes = [
        'gameId' => 'id',
        'platformId' => 'platform',
        'seasonId' => 'season',
        'queueId' => 'queue',
        'mapId' => 'map',
        'participantIdentities' => 'participant_identities',
        'gameVersion' => 'version',
        'gameType' => 'game_type',
        'gameMode' => 'game_mode',
        'gameDuration' => 'duration',
        'gameCreation' => 'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function reference()
    {
        return $this->hasOne($this->getClassFromConfig('match_reference'), 'match_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function summoners()
    {
        return $this->belongsToMany($this->getClassFromConfig('summoner'))
            ->using($this->getClassFromConfig('match_reference'));
    }
}
