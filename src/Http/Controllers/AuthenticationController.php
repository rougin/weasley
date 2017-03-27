<?php

namespace Rougin\Weasley\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Rougin\LoreamAuthsum\Checker\CheckerInterface;

/**
 * Authentication Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class AuthenticationController extends \Rougin\LoreamAuthsum\Authentication
{
    /**
     * @var \Rougin\Weasley\Http\Controllers\BaseController
     */
    protected $base;

    /**
     * @var \Rougin\LoreamAuthsum\Checker\CheckerInterface
     */
    protected $checker;

    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @param \Rougin\LoreamAuthsum\Checker\CheckerInterface $checker
     * @param \Psr\Http\Message\ServerRequestInterface       $request
     * @param \Psr\Http\Message\ResponseInterface            $response
     */
    public function __construct(CheckerInterface $checker, ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->base = new BaseController($request, $response);

        $this->checker = $checker;

        $this->request = $request;
    }

    /**
     * Authenticates the user to the application.
     * 
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login()
    {
        $parameters = $this->request->getParsedBody();

        $credentials = array();

        $credentials['username'] = $parameters['username'];
        $credentials['password'] = $parameters['password'];

        $validation = $this->authenticate($this->checker, $credentials);

        return $validation;
    }

    /**
     * Checks if the authentication has an occured error.
     *
     * @param  array  $credentials
     * @param  string $type
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function error(array $credentials, $type)
    {
        return $this->base->toJson($this->errors, 404);
    }

    /**
     * Checks if the authentication is successful.
     *
     * @param  mixed $match
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function success($match)
    {
        return $this->base->toJson($match);
    }

    /**
     * Validates the given credentials.
     *
     * @param  array  $credentials
     * @return boolean
     */
    protected function validate(array $credentials)
    {
        $validator = new \Valitron\Validator($credentials);

        $validator->rule('required', array('username', 'password'));

        if (! $validated = $validator->validate()) {
            $this->errors['validation'] = $validator->errors();

            $this->errors['old'] = $credentials;
        }

        return $validated;
    }
}
