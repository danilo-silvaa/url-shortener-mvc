<?php 

namespace App\Http;

class Request
{
    private $data;
    
    public function __construct()
    {
        $json = json_decode(file_get_contents('php://input'), true) ?? [];

        $this->data = match(self::method()) {
            'GET' => $_GET,
            'POST', 'PUT', 'DELETE' => $json,
        };
    }

    public function validate(array $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $rulesList = explode('|', $rule);
            foreach ($rulesList as $singleRule) {
                if ($singleRule === 'required' && empty($this->data[$field])) {
                    $errors[$field][] = 'O campo ' . $field . ' é obrigatório.';
                } elseif ($singleRule === 'url' && !self::validateUrl($this->data[$field])) {
                    $errors[$field][] = 'Por favor, coloque uma URL válida.';
                }
            }
        }

        return $errors;
    }

    public static function validateUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    public static function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function input($key)
    {
        return $this->data[$key] ?? null;
    }
}