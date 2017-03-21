<?php

namespace Rougin\Weasley\Http\Controllers;

/**
 * Base Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BaseController
{
    /**
     * Returns the specified data to JSON.
     *
     * @param  mixed   $data
     * @param  integer $code
     * @return string
     */
    protected function toJson($data, $code = 200)
    {
        $data = (is_string($data)) ? $data : json_encode($data);

        $response = $this->response->withStatus($code);

        $response->getBody()->write($data);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
