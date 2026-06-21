<?php

// Define retorno como JSON
header('Content-Type: application/json');

require_once($_SERVER['DOCUMENT_ROOT'] . "/app/AutoLoader.php");

try {

    // Captura método HTTP
    $httpMethod = $_SERVER['REQUEST_METHOD'];

    // Captura dados (POST, GET, etc)
    $input = [];

    switch ($httpMethod) {

        case 'POST':
            if (str_contains($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
                $input = json_decode(file_get_contents("php://input"), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("JSON inválido");
                }
            } else {
                // multipart/form-data
                $input = array_merge($_POST, $_FILES);
            }
            
            break;

        case 'GET':
            $input = $_GET;
            break;

        case 'PUT':
        case 'DELETE':
            parse_str(file_get_contents("php://input"), $input);
            break;

        default:
            throw new Exception("Método HTTP não suportado");
    }

    if (empty($input['co']) || empty($input['ac'])) {
        throw new Exception("Controller ou Action não informados");
    }

    $controllerName = base64_decode($input['co']);
    $action = base64_decode($input['ac']);

    // Segurança básica: evita execução arbitrária
    if (
        !preg_match('/^[a-zA-Z0-9_]+$/', $controllerName) ||
        !preg_match('/^[a-zA-Z0-9_]+$/', $action)
    ) {
        throw new Exception("Controller ou Action inválidos");
    }

    // Verifica se classe existe
    if (!class_exists($controllerName)) {
        throw new Exception("Controller {$controllerName} não encontrado");
    }

    // Remove controller/action do payload
    unset($input['co'], $input['ac']);

    $controller = new $controllerName($input);

    // Verifica se método existe
    if (!method_exists($controller, $action)) {
        throw new Exception("Método {$action} não existe no controller {$controllerName}");
    }

    // Executa método e passa dados
    $result = $controller->$action();

    // Retorno padrão
    echo json_encode([
        'success' => true,
        'data' => $result
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
