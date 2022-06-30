<?php

namespace App\Http\Controllers\Admin\BandwidthBuy;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'providers';
    protected $viewName =  'admin.pages.bandwidthbuy.provider';

    protected function getModel()
    {
        return new Provider();
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
                'label' => 'Company Name',
                'data' => 'company_name',
                'searchable' => false,
            ],
            [
                'label' => 'Contact Person',
                'data' => 'contact_person',
                'searchable' => false,
            ],
            [
                'label' => 'Email',
                'data' => 'email',
                'searchable' => false,
            ],
            [
                'label' => 'Phone',
                'data' => 'phone',
                'searchable' => false,
            ],
            [
                'label' => 'Mobile',
                'data' => 'mobile',
                'searchable' => false,
            ],
            [
                'label' => 'Facebook Url',
                'data' => 'facebook_url',
                'searchable' => false,
            ],
            [
                'label' => 'Skype Id',
                'data' => 'skype_id',
                'searchable' => false,
            ],

            [
                'label' => 'Website Url',
                'data' => 'website_url',
                'searchable' => false,
            ],

            [
                'label' => 'address',
                'data' => 'address',
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
        $page_title = "Provider";
        $page_heading = "Provider List";
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
        $page_title = "Provider Create";
        $page_heading = "Provider Create";
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
        // dd($request->all());
        $valideted = $this->validate($request, [
            'company_name' => ['required'],
            'contact_person' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'mobile' => ['nullable'],
            'facebook_url' => ['nullable'],
            'skype_id' => ['required'],
            'website_url' => ['nullable'],
            'image' => ['nullable'],
            'address' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            if ($request->image) :
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $filePath = $request->file('image')->storeAs('provider', $fileName, 'public');
                $valideted['image'] = '/storage/' . $filePath;
            else :
                $valideted['image'] = '';
            endif;

            $valideted['created_by'] = auth()->id();
            Provider::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . 'Message' . $e->getMessage() . 'File' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $Provider
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Provider $Provider)
    {

        $modal_title = 'Provider Details';
        $modal_data = $Provider;

        $html = view('admin.pages.Providers.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provider  $Provider
     * @return \Illuminate\Http\Response
     */
    public function edit(Provider $Provider)
    {
        $page_title = "Provider Edit";
        $page_heading = "Provider Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $Provider->id);
        $editinfo = $Provider;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provider  $Provider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provider $Provider)
    {
        $valideted = $this->validate($request, [
            'company_name' => ['required'],
            'contact_person' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
            'mobile' => ['nullable'],
            'facebook_url' => ['nullable'],
            'skype_id' => ['required'],
            'website_url' => ['nullable'],
            'image' => ['nullable'],
            'address' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            if ($request->image) :
                $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
                $filePath = $request->file('image')->storeAs('provider', $fileName, 'public');
                $valideted['image'] = '/storage/' . $filePath;
            endif;

            $valideted['updated_by'] = auth()->id();
            $Provider = $Provider->update($valideted);
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
     * @param  \App\Models\Provider  $Provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $Provider)
    {
        $Provider->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getBalance(Request $request)
    {
        $Provider = Provider::find($request->Provider_id);
        echo $Provider->amount;
    }
}
