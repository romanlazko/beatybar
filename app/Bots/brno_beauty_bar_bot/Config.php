<?php

namespace App\Bots\brno_beauty_bar_bot;


class Config
{
    public static function getConfig()
    {
        return [
            'inline_data'       => [
                'client_id' => null,
                'master_id' => null,
                'week' => null,
                'day' => null,
                'term' => null,
                'schedule_id' => null,
                'appointment_id' => null,
            ],
            'admin_ids'         => [
            ],
            'lang' => 'ru',
        ];
    }
}
