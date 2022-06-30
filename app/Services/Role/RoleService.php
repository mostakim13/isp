<?php

namespace App\Services\Role;

use App\Repositories\Role\RoleRepositories;

class RoleService
{


    /**
     * @var UserRoleRepositories
     */
    private $systemRepositories;
    /**
     * AdminCourseService constructor.
     * @param UserRoleRepositories $branchRepositories
     */
    public function __construct(RoleRepositories $systemRepositories)
    {
        $this->systemRepositories = $systemRepositories;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getList($request)
    {
        return $this->systemRepositories->getList($request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllRole()
    {
        return $this->systemRepositories->getAllRole();
    }



    /**
     * @param $request
     * @return mixed
     */
    public function getNavigation()
    {
        return $this->systemRepositories->getNavigation();
    }
    /**
     * @param $request
     * @return mixed
     */
    public function statusUpdate($request, $id)
    {
        return $this->systemRepositories->statusUpdate($request, $id);
    }

    public function statusValidation($request)
    {
        return [
            'id'                   => 'required',
            'status'               => 'required',
        ];
    }
    /**
     * @param $request
     * @return array
     */
    public function storeValidation($request)
    {

        return [
            'role_name'                  => 'required|max:55|min:2',
            //'branch'                     => 'required|array|min:1',
            // 'branch.*'                   => 'required|string|distinct|min:1',
            'permission'                 => 'required|array|min:2',
            'permission.*'               => 'required|string|distinct|min:1',
        ];
    }

    /**
     * @param $id
     * @return array
     */
    public function updateValidation($request, $id)
    {
        // dd($request->all());
        return [
            'role_name'                  => 'required|max:55|min:2',
            //  'branch'                     => 'required|array|min:1',
            //  'branch.*'                   => 'required|string|distinct|min:1',
            'permission'                 => 'required|array|min:2',
            'permission.*'               => 'required|string|distinct|min:1',
        ];
    }

    /**
     * @param $request
     * @return \App\Models\Branch
     */
    public function store($request)
    {
        return $this->systemRepositories->store($request);
    }

    /**
     * @param $request
     * @return \App\Models\Branch
     */
    public function details($id)
    {

        return $this->systemRepositories->details($id);
    }


    /**
     * @param $request
     * @param $id
     */
    public function update($request, $id)
    {
        return $this->systemRepositories->update($request, $id);
    }




    /**
     * @param $request
     * @param $id
     */
    public function destroy($id)
    {
        return $this->systemRepositories->destroy($id);
    }
}
