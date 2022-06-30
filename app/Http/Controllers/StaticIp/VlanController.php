<?php

namespace App\Http\Controllers\StaticIp;

use App\Http\Controllers\Controller;
use App\Models\MikrotikServer;
use App\Models\Vlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \RouterOS\Query;

class VlanController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'vlan';
    protected $viewName =  'admin.pages.staticip.vlan';

    protected function getModel()
    {
        return new Vlan();
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
                'searchable' => true,
            ],
            [
                'label' => 'Mtu',
                'data' => 'mtu',
                'searchable' => true,
            ],
            [
                'label' => 'Arp',
                'data' => 'arp',
                'searchable' => false,
            ],
            [
                'label' => 'Vlan Ip',
                'data' => 'vlan_id',
                'searchable' => false,
            ],
            [
                'label' => 'Interface',
                'data' => 'interface',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
                'data' => 'disabled',
                'checked' => ['false'],
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
        $page_title = "Vlan";
        $page_heading = "Vlan List";
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
            true,
            [
                [
                    'method_name' => 'edit',
                    'class' => 'btn-success',
                    'fontawesome' => 'fa fa-edit',
                    'text' => '',
                    'title' => 'Edit',
                ],
            ]
        );
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Vlan Create";
        $page_heading = "Vlan Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $interfaces = Vlan::get();
        $servers = MikrotikServer::condition()->get();
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
            'mtu' => ['required'],
            'server_id' => ['required'],
            'arp' => ['required'],
            'vlan_id' => ['required'],
            'interface' => ['nullable'],
            'use_service_tag' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $client = $this->client($request->server_id);
            $query = new Query('/interface/vlan/add');
            $query->equal("name", $request->name);
            $query->equal("mtu", $request->mtu);
            $query->equal("arp", $request->arp);
            $query->equal("vlan-id", $request->vlan_id);
            $query->equal("interface", $request->interface);
            $query->equal("use-service-tag", $request->use_service_tag);
            $response = $client->query($query)->read();
            if (isset($response['after']['ret']) && $response['after']['ret']) {
                $valideted['mid'] = $response['after']['ret'];
                $valideted['disabled'] = 'false';
                $valideted['company_id'] = auth()->user()->company_id;
                $valideted['created_by'] = auth()->id();
                Vlan::create($valideted);
            } else {
                return  $response;
                // return back()->with('failed', 'OOps.., something was wrong');
            }
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Vlan $vlan)
    {
        $page_title = "Vlan Edit";
        $page_heading = "Vlan Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $vlan->id);
        $editinfo = $vlan;
        $servers = MikrotikServer::condition()->get();
        $interfaces = Vlan::get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vlan  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vlan $vlan)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'mtu' => ['required'],
            'arp' => ['required'],
            'server_id' => ['required'],
            'vlan_id' => ['required'],
            'interface' => ['nullable'],
            'use_service_tag' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $client = $this->client($request->server_id);
            $query = new Query('/interface/vlan/set');
            $query->equal('.id', $vlan->mid);
            $query->equal("name", $request->name);
            $query->equal("mtu", $request->mtu);
            $query->equal("arp", $request->arp);
            $query->equal("vlan-id", $request->vlan_id);
            $query->equal("interface", $request->interface);
            $query->equal("use-service-tag", $request->use_service_tag);
            $response = $client->query($query)->read();
            if (empty($response)) {
                $valideted['updated_by'] = auth()->id();
                $vlan->update($valideted);
            } else {
                return $response;
                // return back()->with('failed', 'OOps.., something was wrong');
            }

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
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function statusUpdate(Vlan $vlan)
    {
        $status = $vlan->status == 'Active' ? 'Inactive' : 'Active';
        $vlan->update(['status' => $status]);
        return true;
    }

    public function destroy(vlan $vlan)
    {
        $vlan->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function disabled(vlan $vlan)
    {
        $status = $vlan->disabled == 'true' ? 'false' : "true";
        $vlan->update(['disabled' => $status]);
        $this->vlanDisabledStatus($vlan);
        return back()->with('success', 'Status Update successfully.');
    }
}
