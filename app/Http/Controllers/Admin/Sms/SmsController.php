<?php

namespace App\Http\Controllers\Admin\Sms;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'sms';
    protected $viewName =  'admin.pages.sms';

    protected function getModel()
    {
        return new Sms();
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
                'label' => 'Header Text',
                'data' => 'header_text',
                'searchable' => false,
            ],
            [
                'label' => 'Body Text',
                'data' => 'body_text',
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
        $page_title = "Sms";
        $page_heading = "Sms List";
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
            true,
            [
                [
                    'method_name' => 'edit',
                    'class' => 'btn-success',
                    'fontawesome' => 'fa fa-edit',
                    'text' => '',
                    'title' => 'View',
                ],
                [
                    'method_name' => 'send.message',
                    'class' => 'btn-success',
                    'fontawesome' => 'fa fa-comments',
                    'text' => '',
                    'title' => 'View',
                ],
            ]

        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Sms Create";
        $page_heading = "Sms Create";
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
            'header_text' => ['required'],
            'body_text' => ['nullable'],
            'type' => ['required']
        ]);

        try {
            DB::beginTransaction();
            Sms::create($valideted);
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
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Sms $sms)
    {

        $modal_title = 'Sms Details';
        $modal_data = $sms;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Sms $sms)
    {
        $page_title = "Sms Edit";
        $page_heading = "Sms Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $sms->id);
        $editinfo = $sms;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sms $sms)
    {
        $valideted = $this->validate($request, [
            'header_text' => ['required'],
            'body_text' => ['nullable'],
            'type' => ['required']
        ]);

        try {
            DB::beginTransaction();
            $sms->update($valideted);
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
    public function destroy(Sms $sms)
    {
        $sms->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
    public function sendMessage(Sms $sms)
    {
        $editinfo = $sms;
        return view('admin.pages.sms.send-message', get_defined_vars());
    }
}
