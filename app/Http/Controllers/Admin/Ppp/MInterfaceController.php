<?php

namespace App\Http\Controllers\Admin\Ppp;

use App\Http\Controllers\Controller;
use App\Models\MInterface;
use Illuminate\Http\Request;

class MInterfaceController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'minterface';
    protected $viewName =  'admin.pages.minterface';


    protected function getModel()
    {
        return new MInterface();
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
            // [
            //     'label' => 'Default name',
            //     'data' => 'default_name',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Type',
            //     'data' => 'type',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Mtu',
            //     'data' => 'mtu',
            //     'searchable' => false,
            // ],
            [
                'label' => 'Actual Mtu',
                'data' => 'actual_mtu',
                'searchable' => false,
            ],
            // [
            //     'label' => 'l2mtu',
            //     'data' => 'l2mtu',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Max l2mtu',
            //     'data' => 'max_l2mtu',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Mac address',
            //     'data' => 'mac_address',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Last link down time',
            //     'data' => 'last_link_down_time',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Last link up time',
            //     'data' => 'last_link_up_time',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Link downs',
            //     'data' => 'link_downs',
            //     'searchable' => false,
            // ],
            [
                'label' => 'Rx',
                'data' => 'rx_byte',
                'searchable' => false,
            ],
            [
                'label' => 'Tx',
                'data' => 'tx_byte',
                'searchable' => false,
            ],
            [
                'label' => 'Rx packet',
                'data' => 'rx_packet',
                'searchable' => false,
            ],
            [
                'label' => 'Tx packet',
                'data' => 'tx_packet',
                'searchable' => false,
            ],
            // [
            //     'label' => 'Rx drop',
            //     'data' => 'rx_drop',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Tx drop',
            //     'data' => 'tx_drop',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Tx queue drop',
            //     'data' => 'tx_queue_drop',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Rx error',
            //     'data' => 'rx_error',
            //     'searchable' => false,
            // ],
            // [
            //     'label' => 'Tx error',
            //     'data' => 'tx_error',
            //     'searchable' => false,
            // ],
            [
                'label' => 'Fp rx',
                'data' => 'fp_rx_byte',
                'searchable' => false,
            ],
            [
                'label' => 'Fp tx',
                'data' => 'fp_tx_byte',
                'searchable' => false,
            ],
            [
                'label' => 'Fp rx packet',
                'data' => 'fp_rx_packet',
                'searchable' => false,
            ],
            [
                'label' => 'Fp tx packet',
                'data' => 'fp_tx_packet',
                'searchable' => false,
            ],
            [
                'label' => 'Running',
                'data' => 'running',
                'searchable' => false,
            ],
            [
                'label' => 'Disabled',
                'data' => 'disabled',
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
        $page_title = "Interface";
        $page_heading = "Interface List";
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
     * @param  \App\Models\Interface  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, MInterface $minterface)
    {
        $modal_title = 'Interface Details';
        $modal_data = $minterface;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }
}
