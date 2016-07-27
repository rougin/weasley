<?php

namespace {{ application.name }}\{{ namespaces.controllers }};

use {{ application.name }}\{{ namespaces.validators }}\SignInValidator;

/**
 * Authentication Controller
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class AuthenticationController extends BaseController
{
    /**
     * Authenticates the user to the application.
     * 
     * @return redirect
     */
    public function authenticate()
    {
        $parameters = request()->getParsedBody();

        validate(SignInValidator::class, $parameters);

        return redirect('/');
    }

    /**
     * Unsets the session variables.
     * 
     * @return redirect
     */
    public function destroy()
    {
        session_destroy();

        return redirect('sign-in');
    }

    /**
     * Displays the sign in page.
     * 
     * @return string
     */
    public function index()
    {
        return view('auth/signin');
    }
}
