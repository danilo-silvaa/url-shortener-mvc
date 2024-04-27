<?php 

namespace App\Http;

class Response
{
    public static function json(array $data = [], int $status = 200)
    {
        http_response_code($status);

        header("Content-Type: application/json");

        echo json_encode($data);
    }

    public static function html(string $html, int $status = 200)
    {
        http_response_code($status);

        header("Content-Type: text/html");

        echo $html;
    }

    public static function text(string $text, int $status = 200)
    {
        http_response_code($status);

        header("Content-Type: text/plain");

        echo $text;
    }

    public static function redirect(string $url, int $status = 302)
    {
        http_response_code($status);

        header("Location: $url");

        exit();
    }
}