<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Models\ShortenedUrl;

class ShortenerController {
    private $shortenedUrl;

    public function __construct() {
        $this->ShortenedUrl = new ShortenedUrl();
    }

    public function index(Request $request, Response $response)
    {
        return $response::html(file_get_contents(__DIR__ . '/../../resources/views/index.html'));
    }

    public function create(Request $request, Response $response)
    {
        $errors = $request->validate(['url' => 'required|url']);
        if (!empty($errors)) {
            return $response->json($errors, 400);
        }

        $code = substr(md5(uniqid()), 0, 5);
        $url = $request->input('url');

        $this->ShortenedUrl->store($code, $url);

        return $response::json(['shortURL' => $this->getBaseUrl() . $code]);
    }

    public function redirect(Request $request, Response $response, array $id)
    {
        $originalURL = $this->ShortenedUrl->index($id[0]);

        $redirectUrl = !empty($originalURL['url']) ? $originalURL['url'] : $this->getBaseUrl();

        return $response::redirect($redirectUrl);
    }

    public function getBaseUrl() 
    {
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . '/';
    }
}
