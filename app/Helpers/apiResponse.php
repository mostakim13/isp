<?php

namespace App\Helpers;

trait apiResponse
{
    public $success = false;
    public $action_type = "";
    public $message = "Request processing failed";
    protected $data  = [];
    protected $status = false;
    protected $api_token = "";
    /* Environment is local then
     * Return Error Message With filename and Line Number
     * else return a Simple Error Message
     */
    protected function getError($e = null)
    {
        if (strtolower(env('APP_ENV')) == 'local' && !empty($e)) {
            return $e->getMessage() . ' On File ' . $e->getFile() . ' On Line ' . $e->getLine();
        }
        return 'Something went wrong!';
    }


    /**
     * Get Validation Error
     */
    public function getValidationError($validator)
    {
        if (strtolower(env('APP_ENV')) == 'local') {
            return $validator->errors()->first();
        }
        return 'Data Validation Error';
    }

    /**
     * Return API Output
     * return data structure as json format
     */
    protected function apiOutput($status_code = 200, $message = "", $data = [])
    {
        if (!is_int($status_code)) {
            $message = $status_code;
            $status_code = 200;
        }
        $output =  [
            'status' => $this->status,
            'message' => !empty($message) ? $message : $this->message,
            'api_token' => $this->api_token,
            'data' => $this->data,
        ];
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $val) {
                $output[$key] = $val;
            }
        }
        if (empty($output['api_token'])) {
            unset($output['api_token']);
        }

        return response($output, (int)$status_code);
    }

    /**
     * Set Api output status as success
     */
    protected function apiSuccess($message = null, $data = "")
    {
        $this->status = true;
        $this->message = empty($message) ? 'Success' : $message;
        if (!empty($data)) {
            $this->data = $data;
        }
    }
}
