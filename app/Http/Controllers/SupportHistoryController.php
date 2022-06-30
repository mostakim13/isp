<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportHistoryController extends Controller
{
    protected $routeName =  'supporthistory';
    protected $viewName =  'admin.pages.supporthistory';

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
                'label' => 'Date',
                'data' => 'complain_time',
                'searchable' => false,
            ],
            [
                'label' => 'Ticket No',
                'data' => 'complain_number',
                'searchable' => false,
                // 'relation' => 'customer',
            ],
            [
                'label' => 'Client Code',
                'data' => '',
                'searchable' => false,
            ],

            [
                'label' => 'Username',
                'data' => 'username',
                'searchable' => false,
                'relation' => 'customer',
            ],
            [
                'label' => 'Mobile No',
                'data' => 'phone',
                'searchable' => false,
                'relation' => 'customer',
            ],
            [
                'label' => 'Zone',
                'data' => 'zone_id',
                'searchable' => false,
                'relation' => 'customer',

            ],
            [
                'label' => 'Support Category',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'problem',

            ],
            [
                'label' => 'Solved Time',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Solved By',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Duration',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Ticket Info',
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
        $page_title = "Support History";
        $page_heading = "Support History";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $total_ticket = SupportTicket::whereMonth('created_at', Carbon::now()->month)
            ->count();
        $pending_ticket = SupportTicket::where('client_id', Auth::id())->where('status', 'Pending')->count();
        $processing_ticket = SupportTicket::where('client_id', Auth::id())->where('status', 'Processing')->count();
        $solved_ticket = SupportTicket::where('client_id', Auth::id())->where('status', 'Solved')->count();
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
}
