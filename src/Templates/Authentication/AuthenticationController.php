<?php

namespace {{ application.name }}\{{ namespaces.controllers }};

use Rougin\LoreamAuthsum\Checker\DoctrineChecker;

/**
 * Authentication Controller
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class AuthenticationController extends \Rougin\LoreamAuthsum\Authentication
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Authenticates the {{ singular }} to the application.
     * 
     * @return redirect
     */
    public function signin()
    {
        $parameters = request()->getParsedBody();

        $credentials = [
            '{{ username }}' => $parameters['{{ username }}'],
            '{{ password }}' => md5($parameters['{{ password }}']),
        ];

        $checker    = new DoctrineChecker($this->entityManager, '{{ application.name }}\{{ namespaces.models }}\{{ singular | capitalize }}');
        $validation = $this->authenticate($checker, $credentials);

        if (! empty($this->getErrors())) {
            return redirect('auth/sign-in', $this->getErrors());
        }

        return redirect($this->redirectTo);
    }

    /**
     * Displays a form for creating a new {{ singular }}.
     * 
     * @return view
     */
    public function create()
    {
        return view('auth/register');
    }

    /**
     * Unsets the session variables.
     * 
     * @return redirect
     */
    public function destroy()
    {
        session_destroy();

        return redirect('auth/sign-in');
    }

    /**
     * Displays the sign in page.
     * 
     * @return string
     */
    public function index()
    {
        return view('auth/sign-in');
    }

    /**
     * Registers the specified {{ singular }}.
     * 
     * @return redirect
     */
    public function register()
    {
        $parameters = request()->getParsedBody();

        validate('{{ application.name }}\{{ namespaces.validators }}\{{ singular | capitalize }}Validator', $parameters);

        repository('{{ application.name }}\{{ namespaces.repositories }}\{{ singular | capitalize }}Repository')->create($parameters);

        return $this->signin();
    }

    /**
     * Checks if the authentication has an occured error.
     *
     * @param  array  $credentials
     * @param  string $type
     * @return mixed
     */
    protected function error(array $credentials, $type)
    {
        if ($type == Authentication::NOT_FOUND) {
            ${{ password }} = [ 'Invalid {{ username | lower | replace({ '_': ' ' }) }} or {{ password | lower | replace({ '_': ' ' }) }}!' ];

            $this->errors = [ 'validation' => compact('{{ password }}'), 'old' => $credentials ];
        }

        return false;
    }

    /**
     * Returns a listing of error, if any.
     *
     * @return array
     */
    protected function getErrors()
    {
        return $this->errors;
    }

    /**
     * Checks if the authentication is successful.
     *
     * @param  mixed $match
     * @return mixed
     */
    protected function success($match)
    {
        return true;
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

        $validator->rule('required', [ '{{ username }}', '{{ password }}' ]);

        if (! $validated = $validator->validate()) {
            $this->errors = [ 'validation' => $validator->errors(), 'old' => $credentials ];
        }

        return $validated;
    }
}
