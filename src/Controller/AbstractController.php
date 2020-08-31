<?php

namespace Controller;

use Http\Response;
use InvalidArgumentException;
use View\View;

abstract class AbstractController
{
    /**
     * Create response
     *
     * @param View|string|array $data
     * @param int $code
     * @param array $headers
     * @return Response
     */
    protected function response($data, int $code = 200, array $headers = []): Response
    {
        if (!($data instanceof View) && !is_string($data) && !is_array($data)) {
            throw new InvalidArgumentException('Argument 1 only accepts View, string or array');
        }

        $responseText = $data;
        if (is_array($data)) {
            $responseText = json_encode($data);
        } elseif ($data instanceof View) {
            $responseText = $data->render();
        }

        return new Response($code, $responseText, $headers);
    }

    protected function responseAsView(string $template, $data, int $code = 200, array $headers = []): Response
    {
        $view = new View($template, $data, $this->resourcePath());

        return $this->response($view, $code, $headers);
    }

    protected function resourcePath(): string
    {
        return dirname(dirname(__DIR__)) . '/resource/views';
    }
}
