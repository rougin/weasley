<?php

/**
 * Returns a listing of configurations for Doctrine.
 *
 * @var array
 */
return [
    /**
     * If true, caching is done in memory with the ArrayCache.
     * Proxy objects are recreated on every request.
     *
     * If false, then proxy classes have to be explicitly created
     * through the command line.
     *
     * @var boolean
     */
    'developer_mode' => config('app.environment') == 'development',

    /**
     * Location of the Doctrine-based models.
     *
     * @var string
     */
    'model_paths' => [ base('{{ folders.models }}') ],

    /**
     * Location of the generated proxies for the models.
     *
     * @var string
     */
    'proxy_path' => base('{{ folders.proxies }}'),
];
