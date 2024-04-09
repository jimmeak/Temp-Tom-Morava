<?php

namespace Mordor\Web\Controller;

use Mordor\Storage\Http\Response;
use Mordor\Storage\Routing\Route;

class HomepageController
{
    #[Route('/', name: 'homepage')]
    public function homepage(): Response
    {
        return new Response('<h1>Hello from HomepageController</h1>');
    }
}