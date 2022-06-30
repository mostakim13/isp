<?php

namespace App\Http\Controllers\Admin\Ppp;

use App\Http\Controllers\Controller;
use App\Models\M_Secret;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActiveConnectionController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'activeconnections';
    protected $viewName =  'admin.pages.activeconnections';


    protected function getModel()
    {
        return new M_Secret();
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
                'label' => 'Service',
                'data' => 'service',
                'searchable' => false,
            ],

            [
                'label' => 'Encoding',
                'data' => 'encoding',
                'searchable' => false,
            ],
            [
                'label' => 'Address',
                'data' => 'address',
                'searchable' => false,
            ],
            [
                'label' => 'Uptime',
                'data' => 'uptime',
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
        $page_title = "Active Connection";
        $page_heading = "Active Connection List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
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
    public function dataProcessing()
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
                    'method_name' => 'show',
                    'class' => 'btn-success ',
                    'fontawesome' => 'fa fa-hand-holding-usd',
                    'text' => '',
                    'title' => 'View',
                ],
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Active Connection  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, M_Secret $m_secret)
    {
        $modal_title = 'Active Connection Details';
        $modal_data = $m_secret;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }
}
