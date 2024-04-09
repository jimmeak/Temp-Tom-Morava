<?php

namespace Mordor\Web\Controller;

use Mordor\Storage\Http\Response;
use Mordor\Storage\Routing\Route;

class MediaController
{
    #[Route('/audio', name: 'media_audio')]
    public function audio(): Response
    {
        return new Response('<h2>Hello from MediaController, <br>we are audio geeks!</h2>');
    }

    #[Route('/video', name: 'media_video')]
    public function video(): Response
    {
        return new Response('<h2>Hello from MediaController, we think  <br>that audio guys do not know how  <br>to create an image!</h2>');
    }
}