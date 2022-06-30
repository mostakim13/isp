<?php

namespace App\Http\Controllers\Admin\MikrotikServer;

use App\Http\Controllers\Controller;
use App\Models\MikrotikServer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MikrotikServerController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'mikrotikserver';
    protected $viewName =  'admin.pages.mikrotikserver';

    protected function getModel()
    {
        return new MikrotikServer();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Mikrotik Server";
        $page_heading = "Mikrotik Server List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $dataList = $this->getModel()->get();
        return view($this->viewName . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sync(Request $request)
    {
        $client = $this->client($request->mikid);
        $users = $client->q('/ppp/secret/print')->r();
        try {
            foreach ($users as $key => $user) {
                if (str_contains($user['name'], $request->name ?? $user['name'])) {
                    $startDate = new Carbon('first day of this month');
                    $customer[] =   [
                        "mid" => isset($user['.id']) ? $user['.id'] : null,
                        "username" => isset($user['name']) ? $user['name'] : null,
                        "service" => isset($user['service']) ? $user['service'] : null,
                        "caller" => isset($user['caller-id']) ? $user['caller-id'] : null,
                        "m_p_p_p_profile" => isset($user['profile']) ? $user['profile'] : null,
                        "remote_address" => isset($user['remote-address']) ? $user['remote-address'] : null,
                        "routes" => isset($user['routes']) ? $user['routes'] : null,
                        // "ipv6_routes" => isset($user['ipv6-routes']) ? $user['ipv6-routes'] : null,
                        "m_password" => isset($user['password']) ? $user['password'] : null,
                        "password" => isset($user['password']) ? Hash::make($user['password']) : null,
                        "limit_bytes_in" => isset($user['limit-bytes-in']) ? $user['limit-bytes-in'] : null,
                        "limit_bytes_out" => isset($user['limit-bytes-out']) ? $user['limit-bytes-out'] : null,
                        "last_logged_out" => isset($user['last-logged-out']) ? $user['last-logged-out'] : null,
                        "disabled" => isset($user['disabled']) ? $user['disabled'] : null,
                        "comment" => isset($user['comment']) ? $user['comment'] : null,
                        'connection_date' => now(),
                        'start_date' => $startDate,
                        'bill_collection_date' => 1,
                        'billing_status_id' => 5,
                        'exp_date' =>  Carbon::parse($startDate)->addMonths(1)->addDay(0)->format('Y-m-d') //today()->addDay(2)->format('Y-m-d') ;
                    ];
                }
            }

            DB::table('customers')->upsert($customer, ['mid', 'username'], ['comment']);

            return "success";
        } catch (\Exception $e) {
            DB::rollBack();
            return "Message" . $e->getMessage() . 'File' . $e->getFile();
            return back()->with('failed', 'Something was wrong');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Mikrotik Server Create";
        $page_heading = "Mikrotik Server Create";
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
            "server_ip" => ['required'],
            "user_name" => ['required'],
            "password" => ['required'],
            "api_port" => ['required'],
            "version" => ['required'],
        ]);


        try {
            DB::beginTransaction();
            $valideted['created_by'] = auth()->id();

            $mikrotik_server = $this->getModel()->create($valideted);
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
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MikrotikServer $mikrotik_server)
    {

        $modal_title = 'Mikrotik Server Details';
        $modal_data = $mikrotik_server;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(MikrotikServer $mikrotik_server)
    {
        $page_title = "Mikrotik Server Edit";
        $page_heading = "Mikrotik Server Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $mikrotik_server->id);
        $editinfo = $mikrotik_server;

        // dd(get_defined_vars());
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MikrotikServer $mikrotik_server)
    {
        $valideted = $this->validate($request, [
            "server_ip" => ['required'],
            "user_name" => ['required'],
            "password" => ['required'],
            "api_port" => ['required'],
            "version" => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['updated_by'] = auth()->id();

            $mikrotik_server->update($valideted);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function destroy(MikrotikServer $mikrotik_server)
    {
        try {
            DB::beginTransaction();

            $mikrotik_server->delete();

            DB::commit();
            return back()->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }
}
