<?php

return [
    [ 'GET', '/', [ {{ application.name }}\{{ namespaces.controllers }}\WelcomeController::class, 'index' ], config('middlewares') ],
    [ 'GET', '/hello/:name', [ {{ application.name }}\{{ namespaces.controllers }}\WelcomeController::class, 'hello' ], config('middlewares') ],
];
