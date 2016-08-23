<?php

if ( ! function_exists('validate')) {
	/**
	 * Validates the data from a specified validator.
	 * 
	 * @param  string $validatorName
	 * @param  mixed  $data
	 * @return void|redirect
	 */
    function validate($validatorName, $data)
    {
        container()->add($validatorName);

        $validator = container()->get($validatorName);

        if ( ! $validator->validate($data)) {
            $flash = [];

            $flash['validation'] = $validator->getErrors();
            $flash['old'] = $data;

            // var_dump($flash);
            // exit;

            return redirect($_SERVER['HTTP_REFERER'], $flash);
        }
    }
}