<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\SupportCategory;
use App\Models\SupportTicket;
use App\Models\Ticketing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TicketingController extends Controller
{
    protected $routeName =  'ticketing';
    protected $viewName =  'admin.pages.ticketing';

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
                'label' => 'Complain Number',
                'data' => 'complain_number',
                'searchable' => false,
            ],
            [
                'label' => 'Complain Category',
                'data' => 'problem_category',
                'searchable' => false,
                // 'relation' => 'customer',
            ],
            [
                'label' => 'Note',
                'data' => 'note',
                'searchable' => false,
            ],

            [
                'label' => 'Complain Time',
                'data' => 'created_at',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
                'data' => 'status',
                'searchable' => false,
            ],
            [
                'label' => 'Solved Time',
                'data' => 'name',
                'searchable' => false,
            ],

            // [
            //     'label' => 'Action',
            //     'data' => 'action',
            //     'class' => 'text-nowrap',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],

        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Ticketing";
        $page_heading = "Ticketing List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $total_ticket = SupportTicket::whereMonth('created_at', Carbon::now()->month)
            ->count();
        $pending_ticket = SupportTicket::where('client_id', Auth::id())->where('status', 'Pending')->count();
        $processing_ticket = SupportTicket::where('client_id', Auth::id())->where('status', 'Processing')->count();
        $solved_ticket = SupportTicket::where('client_id', Auth::id())->where('status', 'Solved')->count();
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view($this->viewName . '.index', get_defined_vars());
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
        $page_title = "Ticketing Create";
        $page_heading = "Ticketing Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $supportcategories = SupportCategory::get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'complain_number' => ['nullable'],
            'problem_category' => ['nullable'],
            'attachment' => ['nullable'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            if ($file = $request->file('attachment')) {
                $destinationPath = 'file/';
                $uploadfile = date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $uploadfile);
                $valideted['client_id'] = auth()->id();
                $valideted['attachments'] = $uploadfile;
                $valideted['complain_time'] = Carbon::now();
                $this->getModel()->create($valideted);
            } else {
                $valideted['client_id'] = auth()->id();
                $valideted['complain_time'] = Carbon::now();
                $this->getModel()->create($valideted);
            }

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }
}
