<?php

namespace App\Http\Controllers\PackageUpdateDownRate;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Package2;
use App\Models\PackageUpdateDownRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageUpdateDownRateController extends Controller
{
    protected $routeName =  'package_update_and_down_rate';
    protected $viewName =  'admin.pages.package_update_and_down_rate';

    protected function getModel()
    {
        return new PackageUpdateDownRate();
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
                'label' => 'Sl',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Customer Name',
                'data' => 'username',
                'searchable' => false,
                'relation' => 'customer'
            ],

            [
                'label' => 'Package Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'package'
            ],
            [
                'label' => 'Date',
                'data' => 'date',
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Package";
        $page_heading = "Package Update and Down Rate";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;

        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel(),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,

        );
    }

    public function create()
    {
        $page_title = "Package Update and Down Rate Create";
        $page_heading = "Package Update and Down Rate Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = Customer::get();
        $packages = Package2::get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'customer_id' => ['required'],
            'package_id' => ['required'],
            'date' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $this->getModel()->create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    public function edit(PackageUpdateDownRate $Packageupdatedownrate)
    {
        $page_title = "Package Update and Down Rate Edit";
        $page_heading = "Package Update and Down Rate Edit";
        $customers = Customer::get();
        $packages = Package2::get();
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $Packageupdatedownrate->id);
        $editinfo = $Packageupdatedownrate;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, PackageUpdateDownRate $Packageupdatedownrate)
    {
        $valideted = $this->validate($request, [
            'customer_id' => ['required'],
            'package_id' => ['required'],
            'date' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $Packageupdatedownrate = $Packageupdatedownrate->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(PackageUpdateDownRate $Packageupdatedownrate)
    {
        $Packageupdatedownrate->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
