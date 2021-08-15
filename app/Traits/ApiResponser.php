<?php

namespace App\Traits;

trait ApiResponser
{
    /**
     * Form json response
     *
     * @param  [string] message
     * @param  [array] data
     * @param  [int] code
     * @param [boolean] status
     * @return [json] response
     */
    protected function success($key, $data = null, $code = 200)
    {
        $res = ['message'];
        if ($data) {
            array_push($res, 'data');
        }
        $message = $this->message($key);

        return response()->json(compact($res), $code);
    }

    /**
     * Login user and create token
     *
     * @param  [string] message
     * @param  [array] data
     * @param  [int] code
     * @param [boolean] status
     * @return [json] response
     */
    protected function failure($key, $errors = null, $code = 422)
    {
        $res = ['message'];
        if ($errors) {
            array_push($res, 'errors');
        }
        $message = $this->message($key);

        return response(compact($res), $code);
    }

    /**
     * Extract message from key.
     *
     * @param  [string] $key
     * @return [string] $message
     */
    private function message($key)
    {
        return __($key) ?? $key;
    }
}
