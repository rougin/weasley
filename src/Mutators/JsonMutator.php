<?php

namespace Rougin\Weasley\Mutators;

use Psr\Http\Message\ResponseInterface;
use Rougin\Weasley\Contract\Mutator;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class JsonMutator implements Mutator
{
    /**
     * @var array<integer, string>
     */
    protected $errors = array(

        // JSON_ERROR_NONE -----
        'No error has occurred',
        // ---------------------

        // JSON_ERROR_DEPTH ------------------------
        'The maximum stack depth has been exceeded',
        // -----------------------------------------

        // JSON_ERROR_STATE_MISMATCH ---
        'Invalid or malformed JSON',
        // -----------------------------

        // JSON_ERROR_CTRL_CHAR --------------------------------
        'Control character error, possibly incorrectly encoded',
        // -----------------------------------------------------

        // JSON_ERROR_SYNTAX ---
        'Syntax error',
        // ---------------------

        // JSON_ERROR_UTF8 ----------------------------------------
        'Malformed UTF-8 characters, possibly incorrectly encoded',
        // --------------------------------------------------------

        // JSON_ERROR_RECURSION --------------------------------------
        'One or more recursive references in the value to be encoded',
        // -----------------------------------------------------------

        // JSON_ERROR_INF_OR_NAN ----------------------------------
        'One or more NAN or INF values in the value to be encoded',
        // --------------------------------------------------------

        // JSON_ERROR_UNSUPPORTED_TYPE ----------------------
        'A value of a type that cannot be encoded was given',
        // --------------------------------------------------

        // JSON_ERROR_INVALID_PROPERTY_NAME ---------------
        'A property name that cannot be encoded was given',
        // ------------------------------------------------

        // JSON_ERROR_UTF16 ----------------------------------------
        'Malformed UTF-16 characters, possibly incorrectly encoded',
        // ---------------------------------------------------------

        // JSON_ERROR_NON_BACKED_ENUM --------------------------------
        'Value contains a non-backed enum which cannot be serialized',
        // -----------------------------------------------------------

    );

    /**
     * @var integer
     */
    protected $flags = 0;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $http;

    /**
     * @param \Psr\Http\Message\ResponseInterface $http
     * @param integer                             $flags
     */
    public function __construct(ResponseInterface $http, $flags = 0)
    {
        $this->flags = $flags;

        $this->http = $http;
    }

    /**
     * @deprecated since ~0.7, use "mutate" instead.
     * @codeCoverageIgnore
     *
     * Transforms the contents of the result.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function transform($data)
    {
        return $this->mutate($data);
    }

    /**
     * Mutates the contents of the result.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function mutate($data)
    {
        $http = $this->http;

        $stream = @json_encode($data, $this->flags);

        $error = json_last_error();

        if ($error !== JSON_ERROR_NONE)
        {
            $stream = $this->errors[$error];

            $http = $http->withStatus(400);
        }

        if ($stream !== false)
        {
            $http->getBody()->write($stream);
        }

        $type = 'Content-Type';

        $value = 'application/json';

        return $http->withHeader($type, $value);
    }
}
