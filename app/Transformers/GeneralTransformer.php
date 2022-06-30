<?php

namespace App\Transformers;


class GeneralTransformer
{
    /**
     * @param $e
     * @return array
     */
    public function validationError($e)
    {
        $errMsg = '';
        foreach ($e->errors() as $key => $value) {
            $errMsg .= $value[0] . ' ';
        }

        return ResponseTransformer::errorResponse(422, 'Validation Failed. ' . $errMsg, $e->errors());
    }

    /**
     * @return array
     */
    public function statusUpdate()
    {
        return ResponseTransformer::successResponse(204, 'Status Update', 'Updata Successfully');
    }

    /**
     * @param $organizations
     * @return array
     */
    public function getList($getList)
    {

        return ResponseTransformer::successResponse(200, 'List Data', $getList);
    }

    /**
     * @param $organizations
     * @return array
     */
    public function dataTable($getList)
    {

        return ResponseTransformer::datatableResponse($getList);
    }
    /**
     * @param $organizations
     * @return array
     */
    public function invalidId($id)
    {
        return ResponseTransformer::errorResponse(203, 'Invalid ID', $id);
    }

    /**
     * @return array
     */
    public function store()
    {
        return ResponseTransformer::successResponse(201, 'Store Successfully', 'Save Successfully');
    }

    /**
     * @return array
     */
    public function notFound()
    {
        return ResponseTransformer::errorResponse(404, 'Not Found', 'Data Not Found');
    }

    /**
     * @param $organization
     * @return array
     */
    public function details($details)
    {
        return ResponseTransformer::successResponse(200, 'Detail data', $details);
    }

    /**
     * @return array
     */
    public function update()
    {
        return ResponseTransformer::successResponse(204, 'Data Updated', 'Updata Successfully');
    }

    /**
     * @return array
     */
    public function delete()
    {
        return ResponseTransformer::successResponse(204, 'Data Deleted', 'Deleted Successfully');
    }
}
