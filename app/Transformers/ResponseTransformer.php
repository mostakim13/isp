<?php

namespace App\Transformers;

class ResponseTransformer
{
    /**
     * all api success response will be changed if
     * this methods are changed
     * @param int $code
     * @param string $message
     * @param array
     * @return array
     */
    public static function successResponse($code = 200, $message = 'ok', $data)
    {
        return [
            'code'    => $code,
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];
    }


    /**
     * all api success response will be changed if
     * this methods are changed
     * @param int $code
     * @param string $message
     * @param array
     * @return array
     */
    public static function datatableResponse($data)
    {
        return $data;
    }

    /**
     * all api error response will be changed if
     * this method is changed
     * @param int $code
     * @param string $message
     * @param $errorObj
     * @return array
     * @internal param $array
     */
    public static function errorResponse($code = 200, $message = 'ok', $errorObj)
    {
        return [
            'code'    => $code,
            'success' => false,
            'message' => $message,
            'errors'  => $errorObj,
        ];
    }

    /**
     * @param $e
     * @return array
     */
    public static function validationError($e)
    {
        $errors = $e->response->original;
        $errMsg = '';
        foreach ($errors as $key => $value) {
            $errMsg .= $value[0] . ' ';
        }

        //$errMsg = 'Invalid Data'; //turn this on if u dont want to show validation error response

        return [
            'code'    => 406,
            'success' => false,
            'message' => 'Request Rejected',
            'errors'  => $errMsg,
        ];
    }
}