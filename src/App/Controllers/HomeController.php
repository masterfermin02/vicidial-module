<?php

namespace App\Controllers;

use App\Factory\ActionFactory;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator as v;

class HomeController
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $validsActions = [
            "flagged",
            "deleted",
            "archive",
            "added",
            "Dialer",
        ];
        $validator = $this->container->get('validator');
        $validation = $validator->validateArray($request->getQueryParams(),
            [
                'action'    => v::noWhitespace()->notEmpty()->length(2)->containsAny($validsActions),
                'phone' => v::noWhitespace()->notEmpty()->length(10),
            ]);
        if ($validation->failed()) {
            //There are errors, read them
            $errors = $validation->getErrors();
            $response->getBody()->write("There are errors: " . print_r($errors, true));
            return $response;
        }

        // Action is valid, should be logged
        \App\Models\Log::create([
            'action' => $request->getQueryParams()['action'],
            'phone' => $request->getQueryParams()['phone'],
            'flagged_service' => $request->getQueryParams()['flagged_service'] ?? 0,
            'description' => $request->getQueryParams()['description'] ?? '',
            'callgroup' => $request->getQueryParams()['callgroup'] ?? '',
        ]);

        $action = ActionFactory::create($request->getQueryParams()['action'], $this->container);
        $action->execute($request->getQueryParams());

        $response->getBody()->write(" Action: " . $request->getQueryParams()['action'] . " Phone: " . $request->getQueryParams()['phone']);

        return $response;
    }
}
