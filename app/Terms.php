<?php

namespace App;

use Flight;
use Throwable;

class Terms extends Base
{
    public function view($viewName, $viewName2 = null)
    {
        try {
            if (substr($viewName, 0, 1) == "_") {
                throw new Error('denied');
            }
            Flight::set('flight.views.path', ROOT . '/view/terms');
            Flight::render(ucwords($viewName), array(), 'body');
            Flight::render('_layout');
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
