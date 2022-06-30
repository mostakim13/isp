<?php

namespace App\Http\Controllers\StaticIp;

use App\Http\Controllers\Controller;
use App\Models\IpAddress;
use App\Models\MikrotikServer;
use App\Models\Vlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \RouterOS\Query;

class IpAddressController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'ip_address';
    protected $viewName =  'admin.pages.staticip.ip_address';

    protected function getModel()
    {
        return new IpAddress();
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
                'label' => 'Address',
                'data' => 'address',
                'searchable' => true,
            ],
            [
                'label' => 'Network',
                'data' => 'network',
                'searchable' => false,
            ],
            [
                'label' => 'interface',
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
                'label' => 'Mikrotik',
                'data' => 'server_ip',
                'searchable' => false,
                'relation' => 'server',
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
        $page_title = "Ip Address";
        $page_heading = "Ip Address List";
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
        $page_title = "Ip Address Create";
        $page_heading = "Ip Address Create";
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
            'address' => ['required'],
            'network' => ['nullable'],
            'server_id' => ['required'],
            'interface' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $client = $this->client($request->server_id);
            $query = new Query('/ip/address/add');
            $query->equal("address", $request->address);
            $query->equal("network", $request->network);
            $query->equal("interface", $request->interface);
            $response = $client->query($query)->read();
            if (isset($response['after']['ret']) && $response['after']['ret']) {
                $valideted['mid'] = $response['after']['ret'];
                $valideted['company_id'] = auth()->user()->company_id;
                $valideted['disabled'] = 'false';
                IpAddress::create($valideted);
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
    public function edit(IpAddress $ipaddress)
    {
        $page_title = "Ip Address Edit";
        $page_heading = "Ip Address Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $ipaddress->id);
        $editinfo = $ipaddress;
        $interfaces  = Vlan::get();
        $servers = MikrotikServer::condition()->get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vlan  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IpAddress $ipaddress)
    {
        $valideted = $this->validate($request, [
            'address' => ['required'],
            'network' => ['nullable'],
            'server_id' => ['required'],
            'interface' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $client = $this->client($request->server_id);
            $query = new Query('/ip/address/set');
            $query->equal('.id', $ipaddress->mid);
            $query->equal("address", $request->address);
            $query->equal("network", $request->network);
            $query->equal("interface", $request->interface);
            $response = $client->query($query)->read();
            if (empty($response)) {
                $valideted['updated_by'] = auth()->id();
                $ipaddress->update($valideted);
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
    public function statusUpdate(IpAddress $ipaddress)
    {
        $status = $ipaddress->status == 'Active' ? 'Inactive' : 'Active';
        $ipaddress->update(['status' => $status]);
        return true;
    }

    public function disabled(IpAddress $ipaddress)
    {
        $status = $ipaddress->disabled == 'true' ? 'false' : "true";
        $ipaddress->update(['disabled' => $status]);
        $this->ipaddressdisabled($ipaddress);
        return back()->with('success', 'Status Update successfully.');
    }
    public function destroy(IpAddress $ipaddress)
    {
        $ipaddress->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
