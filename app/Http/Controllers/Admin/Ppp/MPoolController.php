<?php

namespace App\Http\Controllers\Admin\Ppp;

use App\Http\Controllers\Controller;
use App\Models\MikrotikServer;
use App\Models\MPool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \RouterOS\Query;

class MPoolController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'mpool';
    protected $viewName =  'admin.pages.mpool';

    protected function getModel()
    {
        return new MPool();
    }

    protected function tableColumnNames()
    {
        return [
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
                'label' => 'Ranges',
                'data' => 'ranges',
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
        $page_title = "Poop";
        $page_heading = "Poop List";
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
        $page_title = "Poop Create";
        $page_heading = "Poop Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $servers = MikrotikServer::where('status', true)->get();
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
            'server_id' => ['required'],
            'ranges' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $client = $this->client($request->server_id);
            $query = new Query('/ip/pool/add');
            $query->equal("name", $request->name);
            $query->equal("ranges", $request->ranges);
            $response = $client->query($query)->read();
            if (isset($response['after']['ret']) && $response['after']['ret']) {
                $valideted['mid'] =  $response['after']['ret']; // uniqid();
                MPool::create($valideted);
            } else {
                return back()->with('failed', $response['after']['message']);
            }

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            // return back();
            return back()->with('failed', $this->getError($e));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MPool  $MPool
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MPool $mpool)
    {

        $modal_title = 'Poop Details';
        $modal_data = $mpool;

        $html = view('admin.pages.MPools.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MPool  $mpool
     * @return \Illuminate\Http\Response
     */
    public function edit(MPool $mpool)
    {
        $page_title = "Poop Edit";
        $page_heading = "Poop Edit";
        $servers = MikrotikServer::where('status', true)->get();
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $mpool->id);
        $editinfo = $mpool;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MPool  $mpool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MPool $mpool)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'server_id' => ['required'],
            'ranges' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $client = $this->client();
            $query = new Query('/ip/pool/set');
            $query->equal(".id", $mpool->mid);
            $query->equal("name", $request->name);
            $query->equal("ranges", $request->ranges);
            $response = $client->query($query)->read();
            if (empty($response)) {
                $mpool->update($valideted);
            } else {
                return back()->with('failed', $response['after']['message']);
            }

            $valideted['updated_by'] = auth()->id();
            $mpool = $mpool->update($valideted);
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
     * @param  \App\Models\MPool  $mpool
     * @return \Illuminate\Http\Response
     */
    public function destroy(MPool $mpool)
    {
        $mpool->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
