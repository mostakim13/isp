<?php

namespace App\Http\Controllers\Admin\UserPackage;

use App\Http\Controllers\Controller;
use App\Models\Package2;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPackageController extends Controller
{
    protected $routeName =  'userpackage';
    protected $viewName =  'admin.pages.userpackage';

    protected function getModel()
    {
        return new Package2();
    }

    protected function tableColumnNames()
    {
        return [
            // [
            //     'label' => 'Show in Table header',
            //     'data' => 'action',
            //     'class' => 'text-nowrap', class name
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
            [
                'label' => 'SN',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Package Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'macpackage'
            ],

            [
                'label' => 'Server Name',
                'data' => 'user_name',
                'searchable' => false,
                'relation' => 'mikrotikserver'
            ],
            [
                'label' => 'Buying Rate',
                'data' => 'rate',
                'searchable' => false,
            ],
            [
                'label' => 'Selling Rate',
                'data' => 'price',
                'searchable' => false,
            ],
            [
                'label' => 'Action',
                'data' => 'action',
                'class' => 'text-nowrap',
                'orderable' => false,
                'searchable' => false,
            ],

        ];
    }


    public function index()
    {
        $customers = Package2::get();
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
        // $incomecategories = IncomeCategory::get();
        // $users = User::where('company_id', Auth::user()->company_id)->where('is_admin', 4)->get();
        // $dailyincomes = DailyIncome::with('category')->get();
        // // $incomecategories
        // return view('$viewName.index', compact('dailyincomes', 'incomecategories', 'users'));
    }

    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('tariffconfig_id', User::getmacReseler()->tariff_id),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                'edit'
            ]
        );
    }

    public function edit(Package2 $userpackage)
    {
        $page_title = "Userpackage Edit";
        $page_heading = "Userpackage Edit";
        $userpackages = Package2::get();
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $userpackage->id);
        $editinfo = $userpackage;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, Package2 $userpackage)
    {
        $valideted = $this->validate($request, [
            'price' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $userpackage = $userpackage->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }
}
