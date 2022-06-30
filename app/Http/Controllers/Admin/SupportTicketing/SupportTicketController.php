<?php

namespace App\Http\Controllers\Admin\SupportTicketing;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SupportCategory;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportTicketController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'supportticket';
    protected $viewName =  'admin.pages.supportTicket.supportticket';

    protected function getModel()
    {
        return new SupportTicket();
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
                'label' => 'User Name/IP',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Customer Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'customer',
            ],
            [
                'label' => 'Mobile ',
                'data' => 'phone',
                'searchable' => false,
                'relation' => 'customer',
            ],
            [
                'label' => 'Complain No.',
                'data' => 'complain_number',
                'searchable' => false,
            ],
            [
                'label' => 'Problem',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'problem',
            ],
            [
                'label' => 'Priority',
                'data' => 'priority',
                'searchable' => false,
            ],
            [
                'label' => 'Complain Time',
                'data' => 'complain_time',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
                'data' => 'status',
                'searchable' => false,
            ],
            [
                'label' => 'Assign To',
                'data' => 'name',
                'searchable' => false,
                'relation' => "assignUser",
            ],
            [
                'label' => 'Solved Time',
                'data' => 'name',
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
        $page_title = "Support Ticket";
        $page_heading = "Support Ticket List";
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Support Ticket Create";
        $page_heading = "Support Ticket Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = Customer::get();
        $supportCategorys = SupportCategory::get();
        $users = User::get();
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
            'client_id' => ['required'],
            'priority' => ['required'],
            'assign_to' => ['required'],
            'problem_category' => ['nullable'],
            'complain_number' => ['nullable'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['status'] = 'Processing';
            $valideted['complain_time'] = now();
            $valideted['created_by'] = auth()->id();
            SupportTicket::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'Line' . $e->getLine() . 'File' . $e->getFile());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(SupportTicket $supportticket)
    {
        $page_title = "Support Ticket Edit";
        $page_heading = "Support Ticket Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $supportticket->id);
        $editinfo = $supportticket;
        $customers = Customer::get();
        $supportCategorys = SupportCategory::get();
        $users = User::get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupportTicket $supportticket)
    {
        $valideted = $this->validate($request, [
            'client_id' => ['required'],
            'priority' => ['required'],
            'assign_to' => ['required'],
            'problem_category' => ['nullable'],
            'complain_number' => ['nullable'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['complain_time'] = now();
            $valideted['updated_by'] = auth()->id();
            $supportticket->update($valideted);

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
    public function destroy(SupportTicket $supportticket)
    {
        $supportticket->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function userDetails(Request $request)
    {
        $userDetail = Customer::find($request->userid);
        return response()->json($userDetail);
    }

    public function status(SupportTicket $supportticket)
    {
        $page_title = "Support Ticket Status";
        $page_heading = "Support Ticket Status";
        $back_url = route($this->routeName . '.index');
        $statusupdate = $supportticket;
        return view($this->viewName . '.status', get_defined_vars());
    }

    public function statusupdate(SupportTicket $supportticket)
    {

        try {
            DB::beginTransaction();
            $valideted['status'] = 'Solved';
            $supportticket->update($valideted);

            DB::commit();
            back()->with('success', 'Status Update successfully.');
            return redirect()->route('supportticket.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }
}
