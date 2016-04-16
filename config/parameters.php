<?php

return [
    'pgsql.user' => DI\env('PGSQL_USER'),
    'pgsql.password' => DI\env('PGSQL_PASSWORD'),
    'pgsql.db' => DI\env('PGSQL_DB'),
    'pgsql.host' => DI\env('PGSQL_HOST'),
    'pgsql.port' => DI\env('PGSQL_PORT'),
    'github.client_id' => DI\env('GITHUB_CLIENT_ID'),
    'github.client_secret' => DI\env('GITHUB_CLIENT_SECRET'),
    'app.url' => DI\env('APP_URL'),
];
