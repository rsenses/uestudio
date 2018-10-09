<?php

namespace Expomark\Controllers;

use Flight;

class NotFoundController
{
    public function indexAction()
    {
        return Flight::view()->render(
            '404.phtml',
            []
        );
    }
}
