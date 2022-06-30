<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'packages';
    protected $viewName =  'admin.pages.packages';

    protected function getModel()
    {
        return new Package();
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
                'label' => 'ID',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Name',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Download',
                'data' => 'm_download',
                'searchable' => false,
            ],
            [
                'label' => 'Upload',
                'data' => 'm_upload',
                'searchable' => false,
            ],
            [
                'label' => 'Transfer',
                'data' => 'm_transfer',
                'searchable' => false,
            ],
            [
                'label' => 'Uptime',
                'data' => 'm_uptime',
                'class' => 'text-nowrap',
                'searchable' => false,
            ],
            [
                'label' => 'Rate Limite',
                'data' => 'm_rate_limite',
                'class' => 'text-nowrap',
                'orderable' => false,
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
        $page_heading = "Package List";
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
            $this->routeName
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Package Create";
        $page_heading = "Package Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        return view($this->viewName . '.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'm_download' => ['required'],
            'm_upload' => ['required'],
            'm_transfer' => ['required'],
            'm_uptime' => ['nullable'],
            'm_rate_limite_rx' => ['required'],
            'm_rate_limite_tx' => ['required'],
            'm_burst_rate_rx' => ['required'],
            'm_burst_rate_tx' => ['required'],
            'm_burst_threshold_rx' => ['required'],
            'm_burst_threshold_tx' => ['required'],
            'm_burst_time_rx' => ['required'],
            'm_burst_time_tx' => ['required'],
            'm_min_rate_rx' => ['required'],
            'm_min_rate_tx' => ['required'],
            'm_priority' => ['required'],
            'm_group_name' => ['nullable'],
            'm_ip_pool' => ['required'],
            'm_ipv6_pool' => ['nullable'],
            'm_address_list' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['created_by'] = auth()->id();
            Package::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Package $package)
    {

        $modal_title = 'Package Details';
        $modal_data = $package;

        $html = view('admin.pages.packages.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $page_title = "Package Edit";
        $page_heading = "Package Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $package->id);
        $editinfo = $package;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'm_download' => ['required'],
            'm_upload' => ['required'],
            'm_transfer' => ['required'],
            'm_uptime' => ['nullable'],
            'm_rate_limite_rx' => ['required'],
            'm_rate_limite_tx' => ['required'],
            'm_burst_rate_rx' => ['required'],
            'm_burst_rate_tx' => ['required'],
            'm_burst_threshold_rx' => ['required'],
            'm_burst_threshold_tx' => ['required'],
            'm_burst_time_rx' => ['required'],
            'm_burst_time_tx' => ['required'],
            'm_min_rate_rx' => ['required'],
            'm_min_rate_tx' => ['required'],
            'm_priority' => ['required'],
            'm_group_name' => ['nullable'],
            'm_ip_pool' => ['required'],
            'm_ipv6_pool' => ['nullable'],
            'm_address_list' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['updated_by'] = auth()->id();
            $package = $package->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
