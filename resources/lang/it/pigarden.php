<?php
return array(
    'start' => 'Start',
    'pause' => 'Pause',
    'end' => 'Fine',
    'last_rain_sensor' => 'Ultima pioggia (sensore)',
    'last_rain_online' => 'Ultima pioggia (online)',
    'unknown' => 'sconosciuto',
    'Solenoid not open for rain' => 'Irrigazione non aperta per pioggia recente',
    'Solenoid open' => 'Irrigazione aperta',
    'Solenoid close' => 'Irrigazione chiusa',
    'Scheduled start successfully performed' => 'Avvio programmato eseguito con successo',
    'Scheduled start successfully deleted' => 'Avvio programmato eliminato con successo',
    'weather_conditions' => 'Condizioni meteo',

    'East' => 'Est',
    'ENE' => 'Est-NordEst',
    'ESE' => 'Est-SudEst',
    'NE' => 'NordEast',
    'NNE' => 'Nord-NordEst',
    'NNW' => 'Nord-NordOvest',
    'North' => 'Nord',
    'NW' => 'NordOvest',
    'SE' => 'SudEst',
    'South' => 'Sud',
    'SSE' => 'Sud-SudEst',
    'SSW' => 'Sud-SudOvest',
    'SW' => 'SudOvest',
    'Variable' => 'Variable',
    'West' => 'Ovest',
    'WNW' => 'Ovest-NordOvest',
    'WSW' => 'Ovest-SudOvest',

    '' => '',
    'Drizzle' => 'Pioggerella',
    'Rain' => 'Pioggia',
    'Snow' => 'Neve',
    'Snow Grains' => 'Grani di neve',
    'Ice Crystals' => 'Cristalli di ghiaccio',
    'Ice Pellets' => 'Granuli di ghiaccio',
    'Hail' => 'Grandine',
    'Mist' => 'Nebbia',
    'Fog' => 'Nebbia',
    'Fog Patches' => 'Banchi di nebbia',
    'Smoke' => 'Fumo',
    'Volcanic Ash' => 'Cenere vulcanica',
    'Widespread Dust' => 'Polvere diffusa',
    'Sand' => 'Sabbia',
    'Haze' => 'Foschia',
    'Spray' => 'Spray',
    'Dust Whirls' => 'Vortici di polvere',
    'Sandstorm' => 'Tempesta di sabbia',
    'Low Drifting Snow' => 'Neve a bassa deriva',
    'Low Drifting Widespread Dust' => 'Polvere diffusa',
    'Low Drifting Sand' => 'Sabbia',
    'Blowing Snow' => 'Bufera di neve',
    'Blowing Widespread Dust' => 'Polvere diffusa',
    'Blowing Sand' => 'Blowing Sand',
    'Rain Mist' => 'Pioggia',
    'Rain Showers' => 'Pioggia',
    'Snow Showers' => 'Rovesci di neve',
    'Snow Blowing Snow Mist' => 'Neve',
    'Ice Pellet Showers' => 'Ice Pellet Showers',
    'Hail Showers' => 'Hail Showers',
    'Small Hail Showers' => 'Small Hail Showers',
    'Thunderstorm' => 'Temporale',
    'Thunderstorms and Rain' => 'Temporale e pioggia',
    'Thunderstorms and Snow' => 'Temporale e neve',
    'Thunderstorms and Ice Pellets' => 'Thunderstorms and Ice Pellets',
    'Thunderstorms with Hail' => 'Thunderstorms with Hail',
    'Thunderstorms with Small Hail' => 'Thunderstorms with Small Hail',
    'Freezing Drizzle' => 'Freezing Drizzle',
    'Freezing Rain' => 'Grandine',
    'Freezing Fog' => 'Nebbia',
    'Patches of Fog' => 'Banchi di nebbia',
    'Shallow Fog' => 'Nebbia',
    'Partial Fog' => 'Nebbia parziale',
    'Overcast' => 'Nuvoloso',
    'Clear' => 'Pulito',
    'Partly Cloudy' => 'Parzialmente nuvoloso',
    'Mostly Cloudy' => 'Prevalentemente nuvoloso',
    'Scattered Clouds' => 'Nubi sparse',
    'Small Hail' => 'Grandine',
    'Squalls' => 'Burrasche',
    'Funnel Cloud' => 'Funnel Cloud',
    'Unknown Precipitation' => 'Precipitazioni sconosciute',
    'Unknown' => 'Sconosciuto',

    'temp_c' => 'Temperatura',
    'feelslike_c' => 'Percepita come',
    'wind_dir' => 'Direzione del vento',
    'wind_gust_kph' => 'Raffiche',
    'pressure_mb' => 'Pressione',
    'relative_humidity' => 'Umidità',
    'dewpoint_c' => 'Punto di rugiada',

    'dashboard' => 'Dashboard',
    'zones' => 'Zone',
    'zone' => 'Zona',
    'zones_empty' => 'Nessuna zona trovata',
    'force_open_with_rain' => "In caso di pioggia forza l'apertura",

    'cron' => [
        'open_title' => 'Schedulazione apertura',
        'close_title' => 'Schedulazione chiusura',
        'success' => 'Schedulazioni confermate',
    ],

    'setup' => 'Setup',
    'initial_setup' => [
        'title' => 'Setup iniziale',
        'description' => "Esegui il setup inziale per impostare i cron per la gestione della centralina:",
        'description_elements' => [
            'Inizializzazione piGarden al boot del sistema',
            'Avvio del socket server per la comunicazione tra piGarden e piGardenWeb',
            'Gestione del controllo pioggia da sensore e servizio online'
        ],
        'success' => 'Setup iniziale seguito con successo',
        'confirm' => 'Esegui il setup',
    ],

    'setup_icons' => [
        'title' => 'Personalizza icone',


    ],

    'add' => 'Aggiungi',
    'cancel' => 'Annulla',
    'confirm' => 'Conferma',

    'users' => 'Utenti',

    'cron_in' => [
        'start' => [
            '0'   => 'Avvia subito',
            '5'   => 'fra 5 minuti',
            '15'  => 'fra 15 minuti',
            '30'  => 'fra 30 minuti',
            '60'  => 'fra 1 ora',
            '120' => 'fra 2 ore',
            '180' => 'fra 3 ore',
            '240' => 'fra 4 ore',
            '300' => 'fra 5 ore',
            '600' => 'fra 10 ore',
        ],
        'length' => [
            '1'   => 'per 1 minuto',
            '3'   => 'per 3 minuti',
            '5'   => 'per 5 minuti',
            '7'   => 'per 7 minuti',
            '10'  => 'per 10 minuti',
            '15'  => 'per 15 minuti',
            '20'  => 'per 20 minuti',
            '30'  => 'per 30 minuti',
            '60'  => 'per 1 ora',
            '120' => 'per 2 ore',
            '180' => 'per 3 ore',
            '240' => 'per 4 ore',
            '300' => 'per 5 ore',
        ],

    ],

    'schedule' => [
        'irrigation_title' => 'Schedulazioni irrigazione',
        'sequence_title' => 'Sequenza irrigazione',
        'in_sequence_msg' => 'Questa zona è presente in una sequenza. Non è possibile definire una schedulazione.',
        'manage_the_sequence' => "Gestisci la sequenza",
    ],


    'irrigation_stop_all' => "Interrompi l'irrigazione di tutte le zone",
    'irrigation_stop_all_and_disable_scheduled' => "Interrompi l'irrigazione e disabilita tutte le schedulazioni",

    'system_reboot' => "Riavvia il sistema",
    'system_shutdown' => "Spengi il sistema",

    'All solenoid closed' => 'Tutte le zone sono state chiuse',

    'System reboot is started' => 'Riavvio del sistema in corso',
    'System shutdown is started' => 'Arresto del sistema in corso',

    'enabled' => 'Abilitato',

    'icon' => [
        'open' => 'Icona aperto',
        'close' => 'Icona chiuso',
    ]


);
