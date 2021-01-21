<?php

require __DIR__ . '/../core/Router.php';

(new Router($_SERVER['REQUEST_URI']))
    ->process();