<?php

namespace App\Http\Controllers\Admin\BandwidthSale;

use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BandwidthCustomerController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'bandwidthCustomers';
    protected $viewName =  'admin.pages.bandwidthsale.bandwidthCustomers';

    protected function getModel()
    {
        return new BandwidthCustomer();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'Image',
                'data' => 'image',
                'searchable' => false,
            ],
            [
                'label' => 'name',
                'data' => 'name',
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
                'label' => 'Mobile',
                'data' => 'mobile',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
                'data' => 'status',
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
        $page_title = "Bandwidth Sale";
        $page_heading = "Bandwidth Sale List";
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
        $page_title = "Bandwidth Sale Create";
        $page_heading = "Bandwidth Sale Create";
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
            "name" => ["required",],
            "code" => ["nullable"],
            "contact_person" => ["required",],
            "email" => ["nullable"],
            "mobile" => ["required",],
            "phone" => ["nullable"],
            "status" => ["required",],
            "reference_by" => ["nullable"],
            "address" => ["nullable"],
            "remarks" => ["nullable"],
            "facebook" => ["nullable"],
            "skypeid" => ["nullable"],
            "website" => ["nullable"],
            "nttn_info" => ["nullable"],
            "vlan_info" => ["nullable"],
            "vlan_id" => ["nullable"],
            "scr_or_link_id" => ["nullable"],
            "activition_date" => ["required",],
            "ipaddress" => ["nullable"],
            "pop_name" => ["nullable"],
            // "username" => ["required",],
            // "password" => ["required", 'confirmed'],
            "image" => ["nullable",],
        ]);

        try {
            DB::beginTransaction();
            $valideted['created_by'] = auth()->id();

            if ($request->hasFile('image')) {

                $path = $request->file('image')->store('bandwidth_client', 'public');

                $valideted['image'] = $path;
            }
            $this->getModel()->create($valideted);
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
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BandwidthCustomer $bandwidthCustomer)
    {

        $modal_title = 'Bandwidth Sale Details';
        $modal_data = $bandwidthCustomer;

        $html = view('admin.pages.ItemCategorys.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BandwidthCustomer $bandwidthCustomer)
    {
        $page_title = "Bandwidth Sale Edit";
        $page_heading = "Bandwidth Sale Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $bandwidthCustomer->id);
        $editinfo = $bandwidthCustomer;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BandwidthCustomer $bandwidthCustomer)
    {
        $valideted = $this->validate($request, [
            "name" => ["required",],
            "code" => ["nullable"],
            "contact_person" => ["required",],
            "email" => ["nullable"],
            "mobile" => ["required",],
            "phone" => ["nullable"],
            "status" => ["required",],
            "reference_by" => ["nullable"],
            "address" => ["nullable"],
            "remarks" => ["nullable"],
            "facebook" => ["nullable"],
            "skypeid" => ["nullable"],
            "website" => ["nullable"],
            "nttn_info" => ["nullable"],
            "vlan_info" => ["nullable"],
            "vlan_id" => ["nullable"],
            "scr_or_link_id" => ["nullable"],
            "activition_date" => ["required",],
            "ipaddress" => ["nullable"],
            "pop_name" => ["nullable"],
            "image" => ["nullable",],
        ]);

        try {
            DB::beginTransaction();
            if ($request->hasFile('image')) {

                if ($bandwidthCustomer->image) {
                    Storage::disk('public')->delete($bandwidthCustomer->image);
                }

                $path = $request->file('image')->store('bandwidth_client', 'public');

                $valideted['image'] = $path;
            }
            $valideted['updated_by'] = auth()->id();
            $bandwidthCustomer->update($valideted);
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
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BandwidthCustomer $bandwidthCustomer)
    {
        $bandwidthCustomer->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
