<?php

namespace App\Http\Controllers\Admin\Customer;

use \RouterOS\Query;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BillingStatus;
use App\Models\ClientType;
use App\Models\ConnectionType;
use App\Models\Customer;
use App\Models\Device;
use App\Models\InstallationFee;
use App\Models\MikrotikServer;
use App\Models\MPPPProfile;
use App\Models\Package2;
use App\Models\Protocol;
use App\Models\Subzone;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'customers';
    protected $viewName =  'admin.pages.customers';


    protected function getModel()
    {
        return new Customer();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'IP',
                'data' => 'id',
                'searchable' => false,
            ],

            [
                'label' => 'IP/ID',
                'data' => 'username',
                'searchable' => true,
            ],
            [
                'label' => 'Password',
                'data' => 'm_password',
                'searchable' => false,
            ],
            [
                'label' => 'C.Name',
                'data' => 'name',
                'searchable' => true,
            ],
            [
                'label' => 'Mobile Number',
                'data' => 'phone',
                'searchable' => false,
            ],
            [
                'label' => 'Zone',
                'data' => 'name',
                'customesearch' => 'zone_id',
                'searchable' => false,
                'relation' => 'getZone',
            ],
            [
                'label' => 'Conn.Type',
                'data' => 'name',
                'customesearch' => 'connection_type_id',
                'searchable' => false,
                'relation' => 'getConnectionType',
            ],

            [
                'label' => 'Cli.Type',
                'data' => 'name',
                'customesearch' => 'client_type_id',
                'searchable' => false,
                'relation' => 'getClientType',
            ],
            [
                'label' => 'Protocol Type',
                'data' => 'name',
                'customesearch' => 'protocol_type_id',
                'searchable' => false,
                'relation' => 'getProtocolType',
            ],
            [
                'label' => 'Expiry Date',
                'data' => 'exp_date',
                'searchable' => false,
            ],
            [
                'label' => 'Package',
                'data' => 'name',
                'customesearch' => 'package_id',
                'searchable' => false,
                'relation' => 'getProfile',
            ],
            [
                'label' => 'Billing',
                'data' => 'bill_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Bill.Status',
                'data' => 'name',
                'customesearch' => 'billing_status_id',
                'searchable' => false,
                'relation' => 'getBillingStatus',
            ],
            [
                'label' => 'Server',
                'data' => 'user_name',
                'customesearch' => 'server_id',
                'searchable' => false,
                'relation' => "getMikserver",
            ],
            [
                'label' => 'MIk.Status',
                'data' => 'disabled',
                'checked' => ['false'],
                'searchable' => false,
            ],
            [
                'label' => 'Sub Zone',
                'customesearch' => 'subzone_id',
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
        $page_title = "Customer";
        $page_heading = "Customer List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $servers = MikrotikServer::where('status', true)->get();
        $clienttyps = ClientType::where('status', true)->get();
        $zones = Zone::get();
        $subzones = Subzone::get();
        $connectiontypes = ConnectionType::where('status', 'active')->get();
        $protocoltypes = Protocol::where('status', 'active')->get();
        $package2s = Package2::where('status', true)->get();
        $billingStatus = BillingStatus::where('status', 'active')->get();

        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        // dd(get_defined_vars());
        return view($this->viewName . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing()
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('company_id', auth()->user()->company_id),
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
        $page_title = "Customer Create";
        $page_heading = "Customer Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        $packages = Package2::where('tariffconfig_id', User::getmacReseler() ? User::getmacReseler()->tariff_id : 0)->get();

        $profiles = MPPPProfile::all();
        $users = User::get(); //where('is_admin', 4);
        $zones = Zone::all();
        $servers = MikrotikServer::where('status', true)->get();
        $protocolTypes = Protocol::where('status', 'active')->get();
        $devices = Device::where('status', 'active')->get();
        $connectionType = ConnectionType::where('status', 'active')->get();
        $clientType = ClientType::where('status', true)->get();
        $billingStatus = BillingStatus::where('status', 'active')->get();
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
            'username' => ['required'],
            'father_name' => ['nullable'],
            'mother_name' => ['nullable'],
            'spouse_name' => ['nullable'],
            'nid' => ['nullable'],
            'passport' => ['nullable'],
            'dob' => ['nullable'],
            'email' => ['nullable', 'email'],
            'reference' => ['nullable'],
            'zone_id' => ['nullable'],
            'comment' => ['nullable'],
            'phone' => ['required'],
            'duration' => ['nullable'],
            'm_p_p_p_profile' => [Rule::requiredIf($request->protocol_type_id == 3)],
            'package_id' => ['required'],
            'billing_person' => ['required'],
            'doc_image' => ['nullable'],
            'mac_address' => ['nullable'],
            'ip_address' => ['nullable'],
            'address' => ['nullable'],
            'bill_amount' => ['required'],
            'connection_date' => ['nullable'],
            'billing_date' => ['nullable'],
            'bill_collection_date' => ['nullable'],
            'group_id' => ['nullable'],
            'limit' => ['nullable'],
            'speed' => ['nullable'],
            'disabled' => ['nullable'],
            'server_id' => ['required'],
            'billing_type' => ['required'],

            'queue_name' => [Rule::requiredIf($request->protocol_type_id == 1)],
            'queue_target' => [Rule::requiredIf($request->protocol_type_id == 1)],
            'queue_dst' => ['nullable'],
            'queue_max_upload' => ['nullable'],
            'queue_max_download' => ['nullable'],

            'protocol_type_id' => ['required'],
            'device_id' => ['nullable'],
            'connection_type_id' => ['nullable'],
            'client_type_id' => ['required'],
            'billing_status_id' => ['required'],

            'password' => ['required', 'confirmed'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['dob'] = Carbon::parse($request->dob);
            $valideted['m_password'] = $request->password;
            $valideted['password'] = Hash::make($request->password);
            $valideted['company_id'] = auth()->user()->company_id;

            if ($request->hasFile('doc_image')) {
                $path = $request->file('doc_image')->store('customer', 'public');
                $valideted['doc_image'] = $path;
            }

            // $valideted['connection_end'] = $request->billing_type == 'day_to_day' ? today()->addMonth() :  new Carbon('last day of this month');
            $startDate =  $valideted['start_date'] = $request->billing_type == 'month_to_month' ? new Carbon('first day of this month') : $request->start_date;
            $valideted['exp_date'] = Carbon::parse($startDate)->addMonths($request->duration)->addDay($request->bill_collection_date)->format('Y-m-d');

            $protocoleType = $request->protocol_type_id == 3 ? "pppoe" : "any";
            $Mpppprofile = MPPPProfile::find($request->m_p_p_p_profile);
            $client = $this->client($request->server_id);
            if ($request->protocol_type_id == 3) {
                $query = new Query('/ppp/secret/add');
                $query->equal('name', $request->queue_name);
                $query->equal('service', $protocoleType);
                $query->equal('caller-id', $request->mac_address);
                $query->equal('profile', $Mpppprofile->name);
                $query->equal('password', $request->password);
                $query->equal('disabled', $request->disabled);
                $query->equal('comment', $request->comment);
                $response = $client->q($query)->r();
                if (isset($response['after']['ret']) && $response['after']['ret']) {
                    $valideted['mid'] = $response['after']['ret'];
                    $valideted['created_by'] = auth()->id();
                    Customer::create($valideted);
                } else {
                    return  $response;
                    return back()->with('failed', 'OOps.., something was wrong Mikrotik');
                }
            } elseif ($request->protocol_type_id == 1) {
                $query = new Query('/queue/simple/add');
                $query->equal('name', $request->queue_name);
                $query->equal('target', $request->queue_target);
                $query->equal('dst', $request->queue_dst);
                $query->equal('max-limit', $request->queue_max_upload . '/' . $request->queue_max_download);
                $response = $client->q($query)->r();
                if (isset($response['after']['ret']) && $response['after']['ret']) {
                    $valideted['queue_mid'] = $response['after']['ret'];
                    $valideted['created_by'] = auth()->id();
                    $valideted['queue_disabled'] = 'true';
                    Customer::create($valideted);
                } else {
                    return  $response;
                    return back()->with('failed', 'OOps.., something was wrong Mikrotik');
                }
            }


            // InstallationFee::firstOrCreate(
            //     [
            //         "customer_id" => $customer->id,
            //     ],
            //     [
            //         "installation_fee" => $request->installation_fee,
            //         "created_on" => Carbon::now()->format('Y-m-d'),
            //         "received_amount" => 0,
            //         "due" => 0,

            //     ]
            // );

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $page_title = "Customer Edit";
        $page_heading = "Customer Edit";
        $packages = Package2::where('tariffconfig_id', User::getmacReseler() ? User::getmacReseler()->tariff_id : 0)->get();
        $profiles = MPPPProfile::all();
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $customer->id);
        $editinfo = $customer;
        $users = User::get(); //where('is_admin', 4);
        $zones = Zone::all();
        // configiration
        $servers = MikrotikServer::where('status', true)->get();
        $protocolTypes = Protocol::where('status', 'active')->get();
        $devices = Device::where('status', 'active')->get();
        $connectionType = ConnectionType::where('status', 'active')->get();
        $clientType = ClientType::where('status', true)->get();
        $billingStatus = BillingStatus::where('status', 'active')->get();
        return view($this->viewName . '.edit', get_defined_vars());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'username' => ['required'],
            'father_name' => ['nullable'],
            'mother_name' => ['nullable'],
            'spouse_name' => ['nullable'],
            'nid' => ['nullable'],
            'passport' => ['nullable'],
            'dob' => ['nullable'],
            'email' => ['nullable', 'email'],
            'reference' => ['nullable'],
            'zone_id' => ['nullable'],
            'comment' => ['nullable'],
            'phone' => ['nullable'],
            'duration' => ['nullable'],
            'm_p_p_p_profile' => [Rule::requiredIf($request->protocol_type_id == 3)],
            'package_id' => ['required'],
            'billing_person' => ['nullable'],
            'doc_image' => ['nullable'],
            'mac_address' => ['nullable'],
            'ip_address' => ['nullable'],
            'address' => ['nullable'],
            'bill_amount' => ['required'],
            'connection_date' => ['nullable'],
            'billing_date' => ['nullable'],
            'bill_collection_date' => ['nullable'],
            'group_id' => ['nullable'],
            'limit' => ['nullable'],
            'speed' => ['nullable'],
            'disabled' => ['nullable'],
            'server_id' => ['required'],
            'protocol_type_id' => ['required'],
            'device_id' => ['nullable'],
            'connection_type_id' => ['nullable'],
            'client_type_id' => ['required'],
            'billing_status_id' => ['required'],
            'billing_type' => ['required'],

            'queue_name' => [Rule::requiredIf($request->protocol_type_id == 1)],
            'queue_target' => [Rule::requiredIf($request->protocol_type_id == 1)],
            'queue_dst' => ['nullable'],
            'queue_max_upload' => ['nullable'],
            'queue_max_download' => ['nullable'],

            'password' => ['nullable', 'confirmed'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['dob'] = Carbon::parse($request->dob);

            if ($request->filled('password')) {
                $valideted['m_password'] = $request->password;
                $valideted['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('doc_image')) {
                $path = $request->file('doc_image')->store('customer', 'public');
                $valideted['doc_image'] = $path;
            }
            if (
                !($customer->duration == $request->duration) ||
                !($customer->bill_collection_date == $request->bill_collection_date) ||
                !($customer->billing_type == $request->billing_type) ||
                empty($customer->duration) ||
                empty($customer->bill_collection_date)
            ) {

                $startDate =  $valideted['start_date'] = $request->billing_type == 'month_to_month' ? new Carbon('first day of this month') : $request->start_date;
                $valideted['exp_date'] = Carbon::parse($startDate)->addMonths($request->duration)->addDay($request->bill_collection_date)->format('Y-m-d');
            }

            $protocoleType = $request->protocol_type_id == 3 ? "pppoe" : "any";
            $Mpppprofile = MPPPProfile::find($request->m_p_p_p_profile);
            $client = $this->client($request->server_id);
            if ($customer->protocol_type_id == 3) {
                $query =  new Query('/ppp/secret/set');
                $query->equal('.id', $customer->mid);
                $query->equal('name', $request->username);
                $query->equal('service', $protocoleType);
                $query->equal('caller-id', $request->mac_address);
                $query->equal('profile', $Mpppprofile->name);
                $query->equal('password', $request->password ?? $customer->m_password);
                $query->equal('disabled', $request->disabled);
                $query->equal('comment', $request->comment);
                $response = $client->query($query)->read();
                if (empty($response)) {
                    $valideted['updated_by'] = auth()->id();
                    $customer->update($valideted);
                } else {
                    return  $response;
                }
            } elseif ($customer->protocol_type_id == 1) {
                $query = new Query('/queue/simple/set');
                $query->equal('.id', $customer->queue_mid);
                $query->equal('name', $request->queue_name);
                $query->equal('target', $request->queue_target);
                $query->equal('dst', $request->queue_dst);
                $query->equal('max-limit', $request->queue_max_upload . '/' . $request->queue_max_download);
                $response = $client->q($query)->r();
                if (isset($response['after']['ret']) && $response['after']['ret']) {
                    $valideted['created_by'] = auth()->id();
                    $customer::update($valideted);
                } else {
                    return  $response;
                    return back()->with('failed', 'OOps.., something was wrong Mikrotik');
                }
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
     * @param  \App\Models\Customer  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getProfile(Request $request)
    {
        $profile = Package2::find($request->id);
        return response()->json([
            "amount" => $profile->price,
            "speed" => $profile->bandwidth_allocation,
        ]);
    }

    public function mikrotikStatus(Customer $customer)
    {
        $status = $customer->disabled == 'true' ? 'false' : 'true';
        $customer->update(['disabled' => $status]);
        if ($customer->protocol_type_id == 3) {
            $this->customer_active_inactive($customer);
        }
        return response()->json(200);
    }
}
