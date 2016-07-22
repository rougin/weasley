<?php

namespace {{ application.name }}\{{ namespaces.controllers }};

/**
 * Welcome Controller
 * 
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class WelcomeController extends BaseController
{
    /**
     * Returns the view page.
     * 
     * @return view
     */
    public function index()
    {
        return view('welcome/index');
    }

    /**
     * Returns the name from the URL.
     * 
     * @param  string $name
     * @return view
     */
    public function hello($name)
    {
        return view('welcome/hello', compact('name'));
    }
}
