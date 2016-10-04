<?php

/**
 * Returns a listing of configurations for Doctrine.
 *
 * @var array
 */
return [
    'developer_mode' => config('environment') == 'development',
    'model_paths'    => [ base('src/Models') ],
    'proxy_path'     => base('src/Proxies'),
];
