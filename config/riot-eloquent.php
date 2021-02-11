<?php

return [
    'tables' => [
        'connect_with_user_model' => false,

        'prefix' => 'riot_lol_',

        'classes' => [
            'summoner' => \Blood72\Riot\Models\Summoner::class,
            'match_info' => \Blood72\Riot\Models\MatchInfo::class,
            'match_reference' => \Blood72\Riot\Models\MatchReference::class,
        ],
    ],
];
