<?php

namespace App\Http\Controllers\Admin\Destroyitem;

use App\Http\Controllers\Controller;
use App\Models\AssetList;
use App\Models\AssetsCategory;
use App\Models\Destroyitems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DestroyItemController extends Controller
{
    protected $routeName =  'destroyitems';
    protected $viewName =  'admin.pages.destroyitems';

    protected function getModel()
    {
        return new Destroyitems();
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
                'label' => 'Asset Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'assets',
            ],
            [
                'label' => 'Reason Name',
                'data' => 'reason_name',
                'searchable' => false,
                'relation' => 'reasons',
            ],
            [
                'label' => 'Quantity',
                'data' => 'qty',
                'searchable' => false,
            ],

            [
                'label' => 'Destroy Date',
                'data' => 'destroy_date',
                'searchable' => false,
            ],

            [
                'label' => 'Remarks',
                'data' => 'remarks',
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

    public function index()
    {
        $page_title = "Destroy Items";
        $page_heading = "Destroy Items";
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

    public function create()
    {
        $page_title = "Destroy Items";
        $page_heading = "Destroy Items";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $assets = AssetList::get();
        $reasons = AssetsCategory::where('type', 2)->where('status', 1)->get();
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
            'asset_id' => ['required'],
            'reason_id' => ['required'],
            'qty' => ['required'],
            'destroy_date' => ['required'],
            'remarks' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $asset = AssetList::find($request->asset_id);
            $asset->update(['qty' => $asset->qty - $request->qty]);

            $valideted['company_id'] = Auth::user()->company_id;
            $valideted['destroy_by'] = Auth::id();
            Destroyitems::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function edit(Destroyitems $destroyitems)
    {
        $page_title = "Destroyitems Edit";
        $page_heading = "Destroyitems Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $destroyitems->id);
        $editinfo = $destroyitems;
        $assets = AssetList::get();
        $reasons = AssetsCategory::where('type', 2)->where('status', 1)->get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, Destroyitems $destroyitems)
    {
        $valideted = $this->validate($request, [
            'asset_id' => ['required'],
            'reason_id' => ['required'],
            'qty' => ['required'],
            'destroy_date' => ['required'],
            'remarks' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $oldasset = AssetList::find($destroyitems->asset_id);
            $oldasset->update(['qty' => $oldasset->qty + $destroyitems->qty]);

            $asset = AssetList::find($request->asset_id);
            $asset->update(['qty' => $asset->qty - $request->qty]);

            $valideted['destroy_by'] = auth()->id();
            $destroyitems = $destroyitems->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(Destroyitems $destroyitems)
    {
        $destroyitems->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
