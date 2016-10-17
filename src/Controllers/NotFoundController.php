<?php

namespace Expomark\Controllers;

use Flight;

class NotFoundController
{
    public function indexAction()
    {
        echo Flight::view()->render(
            '404.phtml',
            []
        );
    }
}
