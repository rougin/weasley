<?php

/**
 * Configurations for your application.
 *
 * @var array
 */
return [
    /**
     * The URL of your application root.
     *
     * @var string
     */
    'base_url' => $_ENV['BASE_URL'],

    /**
     * Environment used in the application.
     * It's either "development" or "production".
     *
     * @var string
     */
    'environment' => $_ENV['ENVIRONMENT'],

    /**
     * The default timezone for the application.
     *
     * @var string
     */
    'timezone' => $_ENV['TIMEZONE'],

    /**
     * The list of components to be integrated in Slytherin.
     *
     * @var array
     */
    'components' => [
        {{ application.name }}\{{ namespaces.components }}\DebuggerComponent::class,
        {{ application.name }}\{{ namespaces.components }}\DispatcherComponent::class,
        {{ application.name }}\{{ namespaces.components }}\DoctrineComponent::class,
        {{ application.name }}\{{ namespaces.components }}\HttpComponent::class,
        {{ application.name }}\{{ namespaces.components }}\MiddlewareComponent::class,
        {{ application.name }}\{{ namespaces.components }}\RepositoryComponent::class,
        {{ application.name }}\{{ namespaces.components }}\SerializerComponent::class,
    ]
];
