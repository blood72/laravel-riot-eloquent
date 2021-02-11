<?php

namespace Blood72\Riot\Models;

use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * @property string $summoner_id
 * @property int $match_id
 */
class MatchReference extends Model
{
    use AsPivot;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'match_id', 'platform', 'season', 'champion', 'duration', 'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /** @var array */
    protected array $aliasAttributes = [
        'gameId' => 'match_id',
        'platformId' => 'platform',
        'seasonId' => 'season',
        'queueId' => 'queue',
        'mapId' => 'map',
        'gameVersion' => 'version',
        'gameType' => 'game_type',
        'gameMode' => 'game_mode',
        'gameDuration' => 'duration',
        'gameCreation' => 'created_at',
        'timestamp' => 'created_at',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = null;

    /**
     * {@inheritDoc}
     */
    public function getTable()
    {
        return parent::getTable();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function info()
    {
        return $this->belongsTo($this->getClassFromConfig('match_info'), 'match_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function summoner()
    {
        return $this->belongsTo($this->getClassFromConfig('summoner'), 'summoner_id');
    }
}
