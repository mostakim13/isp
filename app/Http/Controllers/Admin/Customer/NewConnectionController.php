<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\BillingStatus;
use App\Models\ClientType;
use App\Models\ConnectionType;
use App\Models\Customer;
use App\Models\District;
use App\Models\Employee;
use App\Models\InstallationFee;
use App\Models\NewConnection;
use App\Models\Package2;
use App\Models\Subzone;
use App\Models\Upozilla;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Database\Events\ConnectionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewConnectionController extends Controller
{
    protected $routeName =  'newconnection';
    protected $viewName =  'admin.pages.newconnection';

    protected function getModel()
    {
        return new NewConnection();
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
                'label' => 'C.Name',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Mobile',
                'data' => 'mobilenumber',
                'searchable' => false,
            ],
            [
                'label' => 'Address',
                'data' => 'presentaddress',
                'searchable' => false,
            ],
            [
                'label' => 'Zone',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'zonename'
            ],
            [
                'label' => 'Subzone',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'subzonename'

            ],
            [
                'label' => 'C.Type',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'clienttypes'
            ],
            [
                'label' => 'Con.Type',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'connectiontypes'
            ],
            [
                'label' => 'Package',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'packages'
            ],
            [
                'label' => 'M.Bill',
                'data' => 'monthlybill',
                'searchable' => false,
            ],
            [
                'label' => 'B.Date',
                'data' => 'dateofbirth',
                'searchable' => false,
            ],
            [
                'label' => 'OTC(Con.Charge)',
                'data' => 'otc',
                'searchable' => false,
            ],
            [
                'label' => 'Phy.Connectivity',
                'data' => 'category_name',
                'searchable' => false,
            ],
            [
                'label' => 'Created By',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'user'
            ],
            [
                'label' => 'Status',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'statuses'
            ],
            [
                'label' => 'SetUp By',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'employees'
            ],
            [
                'label' => 'Conn.Status',
                'data' => 'is_approve',
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
        $page_title = "New Connection";
        $page_heading = "New Connection";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $statuses = Customer::get();
        $employees = Employee::get();
        $clienttypes = ClientType::get();
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view($this->viewName . '.index', get_defined_vars());
    }

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
                    'class' => 'btn-info  btn-sm',
                    'fontawesome' => 'fa fa-edit',
                    'text' => '',
                    'title' => 'Edit',
                    'code' => "onclick ='return confirm(`Are you sure?`)'",
                ],
                [
                    'method_name' => 'destroy',
                    'class' => 'btn-danger  btn-sm',
                    'fontawesome' => 'fa fa-trash',
                    'text' => '',
                    'title' => 'Delete',
                    'code' => "onclick ='return confirm(`Are you sure?`)'",
                ],
                // [
                //     'method_name' => 'approved',
                //     'class' => 'btn-primary  btn-sm',
                //     'fontawesome' => '',
                //     'text' => 'Approve',
                //     'title' => 'Approve',
                //     'code' => "onclick ='return confirm(`Are you sure?`)'",
                // ],
            ],
        );
    }

    public function create()
    {
        $page_title = "New Connection Create";
        $page_heading = "New Connection Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $districts = District::get();
        $upazilas = Upozilla::get();
        $zones = Zone::get();
        $subzones = Subzone::get();
        $packages = Package2::get();
        $billingstatuses = BillingStatus::get();
        $employees = Employee::get();
        $clienttypes  = ClientType::get();
        $connectiontypes = ConnectionType::get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {

        $valideted = $this->validate($request, [
            'name' => ['required'],
            'gender' => ['nullable'],
            'occupation' => ['nullable'],
            'dateofbirth' => ['nullable'],
            'father_name' => ['nullable'],
            'mother_name' => ['nullable'],
            'nid' => ['nullable'],
            'registrationformno' => ['nullable'],
            'remarks' => ['nullable'],
            'profile_picture' => ['nullable'],
            'nid_picture' => ['nullable'],
            'registrationformpicture' => ['nullable'],
            'mobilenumber' => ['required'],
            'phonenumber' => ['nullable'],
            'emailaddress' => ['nullable', 'email'],
            'facebookprofilelink' => ['nullable'],
            'linkedinprofilelink' => ['nullable'],
            'district' => ['nullable'],
            'upazila' => ['nullable'],
            'roadnumber' => ['nullable'],
            'housenumber' => ['nullable'],
            'presentaddress' => ['nullable'],
            'permanentaddress' => ['nullable'],
            'zone' => ['required'],
            'subzone' => ['nullable'],
            'connectiontype' => ['required'],
            'clienttype' => ['required'],
            'package_id' => ['required'],
            'billingstatus' => ['required'],
            'monthlybill' => ['required'],
            'commitedbilldate' => ['required'],
            'referenceby' => ['nullable'],
            'setup_by' => ['nullable'],
            'connected_at' => ['nullable'],
            'otc' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $pimage = $request->file('profile_picture');
            $filename = null;
            if ($pimage) {
                $filename = time() . $pimage->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'profile_picture/',
                    $pimage,
                    $filename
                );
            }

            $nidimage = $request->file('nid_picture');
            $filename1 = null;
            if ($nidimage) {
                $filename1 = time() . $nidimage->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'nid_picture/',
                    $nidimage,
                    $filename1
                );
            }

            $registerimage = $request->file('registrationformpicture');
            $filename2 = null;
            if ($registerimage) {
                $filename2 = time() . $registerimage->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'registrationformpicture/',
                    $registerimage,
                    $filename2
                );
            }
            $valideted['profile_picture'] = $filename;
            $valideted['nid_picture'] = $filename1;
            $valideted['registrationformpicture'] = $filename2;
            $valideted['created_by'] = Auth::id();

            // if ($request->otc) {
            //     $installation['installation_fee'] = $request->otc;
            //     InstallationFee::create($installation);
            // }

            NewConnection::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }



    public function edit(NewConnection $newconnection)
    {
        $page_title = "New Connection Edit";
        $page_heading = "New Connection Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $newconnection->id);
        $editinfo = $newconnection;
        $districts = District::get();
        $upazilas = Upozilla::get();
        $zones = Zone::get();
        $subzones = Subzone::get();
        $packages = Package2::get();
        $billingstatuses = BillingStatus::get();
        $employees = Employee::get();
        $clienttypes  = ClientType::get();
        $connectiontypes = ConnectionType::get();

        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, NewConnection $newconnection)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'gender' => ['nullable'],
            'occupation' => ['nullable'],
            'dateofbirth' => ['nullable'],
            'father_name' => ['nullable'],
            'mother_name' => ['nullable'],
            'nid' => ['nullable'],
            'registrationformno' => ['nullable'],
            'remarks' => ['nullable'],
            'profile_picture' => ['nullable'],
            'nid_picture' => ['nullable'],
            'registrationformpicture' => ['nullable'],
            'mobilenumber' => ['required'],
            'phonenumber' => ['nullable'],
            'emailaddress' => ['nullable', 'email'],
            'facebookprofilelink' => ['nullable'],
            'linkedinprofilelink' => ['nullable'],
            'district' => ['nullable'],
            'upazila' => ['nullable'],
            'roadnumber' => ['nullable'],
            'housenumber' => ['nullable'],
            'presentaddress' => ['nullable'],
            'permanentaddress' => ['nullable'],
            'zone' => ['required'],
            'subzone' => ['nullable'],
            'connectiontype' => ['required'],
            'clienttype' => ['required'],
            'package_id' => ['required'],
            'billingstatus' => ['required'],
            'monthlybill' => ['required'],
            'commitedbilldate' => ['required'],
            'referenceby' => ['nullable'],
            'setup_by' => ['nullable'],
            'connected_at' => ['nullable'],
            'otc' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $pimage = $request->file('profile_picture');
            $filename = null;
            if ($pimage) {
                $filename = time() . $pimage->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'profile_picture/',
                    $pimage,
                    $filename
                );
            }

            $nidimage = $request->file('nid_picture');
            $filename1 = null;
            if ($nidimage) {
                $filename1 = time() . $nidimage->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'nid_picture/',
                    $nidimage,
                    $filename1
                );
            }

            $registerimage = $request->file('registrationformpicture');
            $filename2 = null;
            if ($registerimage) {
                $filename2 = time() . $registerimage->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'registrationformpicture/',
                    $registerimage,
                    $filename2
                );
            }
            $valideted['profile_picture'] = $filename;
            $valideted['nid_picture'] = $filename1;
            $valideted['registrationformpicture'] = $filename2;
            // $valideted['created_by'] = Auth::id();

            // if ($request->otc) {
            //     $installation['installation_fee'] = $request->otc;
            //     InstallationFee::create($installation);
            // }

            $newconnection = $newconnection->update($valideted);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    public function destroy(NewConnection $newconnection)
    {
        $newconnection->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
    public function approve(NewConnection $newconnection)
    {
        try {
            $customer['name'] = $newconnection->name;
            // $customer['name'] = $newconnection->gender;
            // $customer['name'] = $newconnection->occupation;
            $customer['dob'] = $newconnection->dateofbirth;
            $customer['father_name'] = $newconnection->father_name;
            $customer['mother_name'] = $newconnection->mother_name;
            $customer['nid'] = $newconnection->nid;
            // $customer['name'] = $newconnection->registrationformno;
            $customer['comment'] = $newconnection->remarks;
            // $customer['name'] = $newconnection->profile_picture;
            // $customer['name'] = $newconnection->nid_picture;
            // $customer['name'] = $newconnection->registrationformpicture;
            $customer['phone'] = $newconnection->mobilenumber;
            // $customer['name'] = $newconnection->phonenumber;
            $customer['email'] = $newconnection->emailaddress;
            // $customer['name'] = $newconnection->facebookprofilelink;
            // $customer['name'] = $newconnection->linkedinprofilelink;
            $customer['district'] = $newconnection->district;
            $customer['upazila'] = $newconnection->upazila;
            $customer['company_id'] = auth()->user()->company_id;
            // $customer['name'] = $newconnection->roadnumber;
            // $customer['name'] = $newconnection->housenumber;
            // $customer['name'] = $newconnection->presentaddress;
            // $customer['name'] = $newconnection->permanentaddress;
            $customer['zone_id'] = $newconnection->zone;
            $customer['subzone_id'] = $newconnection->subzone;
            $customer['connection_type_id'] = $newconnection->connectiontype;
            $customer['client_type_id'] = $newconnection->clienttype;
            $customer['package_id'] = $newconnection->package_id;
            $customer['billing_status_id'] = $newconnection->billingstatus;
            $customer['bill_amount'] = $newconnection->monthlybill;
            $customer['billing_date'] = $newconnection->commitedbilldate;
            $customer['reference'] = $newconnection->referenceby;
            // $customer['name'] = $newconnection->setup_by;
            $customer['connection_date'] = $newconnection->connected_at;
            // $customer['name'] = $newconnection->otc;
            $customer = Customer::create($customer);
            $newconnection->update(['customer_id' => $customer->id, 'is_approve' => '1']);

            if ($newconnection->otc) {
                $installation['installation_fee'] = $newconnection->otc;
                $installation['customer_id'] = $customer->id;
                $installation['created_on'] = Carbon::now();
                InstallationFee::create($installation);
            }
            DB::commit();
            return back()->with('success', 'Approved!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    public function monthlybill(Request $request)
    {
        $profile = Package2::find($request->id);
        return response()->json([
            "amount" => $profile->price,
        ]);
    }
}
