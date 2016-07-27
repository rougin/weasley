<?php

namespace {{ application.name }}\{{ namespaces.validators }};

use Valitron\Validator;

use {{ application.name }}\{{ namespaces.repositories }}\{{ plural | capitalize }}Repository;

/**
 * Sign In Validator
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class SignInValidator extends BaseValidator
{
    /**
     * @var \{{ application.name }}\{{ namespaces.repositories }}\{{ plural | capitalize }}Repository
     */
    protected ${{ singular }}Repository;

    /**
     * @param \{{ application.name }}\{{ namespaces.repositories }}\{{ plural | capitalize }}Repository ${{ singular }}Repository
     */
    public function __construct({{ plural | capitalize }}Repository ${{ singular }}Repository)
    {
        $this->{{ singular }}Repository = ${{ singular }}Repository;
    }

    /**
     * Sets the labels in the validator.
     * 
     * @param  \Valitron\Validator $validator
     * @return void
     */
    protected function setLabels(Validator &$validator) {}

    /**
     * Sets the rules in the validator.
     * 
     * @param  \Valitron\Validator $validator
     * @param  array
     * @return void
     */
    protected function setRules(Validator &$validator, $data = [])
    {
        $validator->rule('required', [ '{{ username }}', '{{ password }}' ]);
    }

    /**
     * Validates the data from the registration page.
     * 
     * @param  array  $data
     * @return boolean
     */
    public function validate(array $data)
    {
        $validation = parent::validate($data);

        if ( ! $validation) {
            return $validation;
        }

        extract($data);

        ${{ password }} = md5(${{ password }});
        $parameters = compact('{{ username }}', '{{ password }}');

        ${{ singular }} = $this->{{ singular }}Repository->findOneBy($parameters);

        if ( ! ${{ singular }}) {
            ${{ password }} = [ 'Invalid {{ username | lower | replace({'_': ' '}) }} or {{ password | lower | replace({'_': ' '}) }}!' ];

            $this->errors = compact('{{ password }}');

            return false;
        }

        // $_SESSION['user']['id'] = $user->getId();
        // $_SESSION['user']['first_name'] = $user->getFirstName();
        // $_SESSION['user']['last_name'] = $user->getLastName();
        // $_SESSION['user']['role'] = $user->getRole();

        return $validation;
    }
}
