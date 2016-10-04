<?php

return [
    [ 'GET', '/', [ '{{ application.name }}\{{ namespaces.controllers }}\WelcomeController', 'index' ], config('middlewares') ],
    [ 'GET', '/hello/:name', [ '{{ application.name }}\{{ namespaces.controllers }}\WelcomeController', 'hello' ], config('middlewares') ],
];
