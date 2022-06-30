<?php

namespace App\Http\Controllers\Admin\MPPPProfile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MikrotikServer;
use App\Models\MPool;
use App\Models\MPPPProfile;
use Illuminate\Support\Facades\DB;
use \RouterOS\Query;

class MPPPProfileController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'm_p_p_p_profiles';
    protected $viewName =  'admin.pages.m_p_p_p_profiles';

    protected function getModel()
    {
        return new MPPPProfile();
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
                'label' => 'SL/NO',
                'data' => 'id',
                'searchable' => false,
            ],
            // [
            //     'label' => 'ID',
            //     'data' => 'mid',
            //     'searchable' => false,
            // ],
            [
                'label' => 'Name',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Local Address',
                'data' => 'local_address',
                'class' => 'text-nowrap',
                'searchable' => false,
            ],
            [
                'label' => 'Remote Address',
                'data' => 'name',
                'class' => 'text-nowrap',
                'searchable' => false,
                'relation' => 'mpoolRemoteAddressList',
            ],
            [
                'label' => 'Bridge',
                'data' => 'bridge_learning',
                'class' => 'text-nowrap',
                'searchable' => false,
            ],
            [
                'label' => 'Rate Limit',
                'data' => 'm_rate_limite',
                'class' => 'text-nowrap',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'label' => 'Only One',
                'data' => 'only_one',
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

        $page_title = "Profile";
        $page_heading = "Profile List";
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
        $page_title = "Profile Create";
        $page_heading = "Profile Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $mpools = MPool::orderBy('name', 'asc')->get();
        $mikrotik_servers = MikrotikServer::get();
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
            'name' => ['required', 'unique:m_p_p_p_profiles,name'],
            'local_address' => ['required'],
            'remote_address' => ['required'],
            'bridge_learning' => ['nullable'],
            'amount' => ['nullable'],
            'speed' => ['nullable'],
            'change_tcp_mss' => ['nullable'],
            'use_upnp' => ['nullable'],
            'dns_server' => ['nullable'],
            'server_id' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $client = $this->client($request->server_id);
            $ippool = MPool::find($request->remote_address);
            $query = new Query('/ppp/profile/add');
            $query->equal("name", $request->name);
            $query->equal("bridge-learning", $request->bridge_learning); //*
            $query->equal("remote-address", $ippool->name);
            $query->equal("local-address", $request->local_address);
            $query->equal("change-tcp-mss", $request->change_tcp_mss);
            $query->equal("use-upnp", $request->use_upnp);
            $response = $client->query($query)->read();
            if (isset($response['after']['ret']) && $response['after']['ret']) {
                $valideted['mid'] = $response['after']['ret'];
                $valideted['created_by'] = auth()->id();
                MPPPProfile::create($valideted);
            } else {
                return back()->with('failed', 'OOps.., something was wrong');
            }

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MPPPProfile  $m_p_p_p_profile
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MPPPProfile $m_p_p_p_profile)
    {

        $modal_title = 'Profile Details';
        $modal_data = $m_p_p_p_profile;

        $html = view($this->viewName . 'show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MPPPProfile  $m_p_p_p_profile
     * @return \Illuminate\Http\Response
     */
    public function edit(MPPPProfile $m_p_p_p_profile)
    {
        $page_title = "Profile Edit";
        $page_heading = "Profile Edit";
        $mikrotik_servers = MikrotikServer::get();
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $m_p_p_p_profile->id);
        $mpools = MPool::orderBy('name', 'asc')->get();
        $editinfo = $m_p_p_p_profile;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MPPPProfile  $m_p_p_p_profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MPPPProfile $m_p_p_p_profile)
    {
        $valideted = $this->validate($request, [
            'name' => ['required', 'unique:m_p_p_p_profiles,name,' . $m_p_p_p_profile->id],
            'local_address' => ['required'],
            'remote_address' => ['required'],
            'bridge_learning' => ['nullable'],
            'amount' => ['nullable'],
            'speed' => ['nullable'],
            'change_tcp_mss' => ['nullable'],
            'use_upnp' => ['nullable'],
            'dns_server' => ['nullable'],
            'server_id' => ['required'],
        ]);


        try {
            DB::beginTransaction();

            $client = $this->client($request->server_id);
            $ippool = MPool::find($request->remote_address);
            $query = new Query('/ppp/profile/set');
            $query->equal('.id', $m_p_p_p_profile->mid);
            $query->equal("name", $request->name);
            $query->equal("bridge-learning", $request->bridge_learning); //*
            $query->equal("remote-address", $ippool->name);
            $query->equal("local-address", $request->local_address);
            $query->equal("change-tcp-mss", $request->change_tcp_mss);
            $query->equal("use-upnp", $request->use_upnp);
            $response = $client->query($query)->read();

            if (empty($response)) {
                $valideted['created_by'] = auth()->id();
                $m_p_p_p_profile->update($valideted);
            } else {
                return $response;
                return back()->with('failed', 'OOps.., something was wrong');
            }
            // dd($response);
            // $response = $client->q('/ppp/profile/print')->r();
            // Profile Add End
            // [find name=default] remote-address=pool1 local-address=192.168.79.1

            // dd($data, $response);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->getError($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MPPPProfile  $m_p_p_p_profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(MPPPProfile $m_p_p_p_profile)
    {
        $m_p_p_p_profile->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
