<?php

namespace App\Http\Controllers\Admin\Box;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Subzone;
use App\Models\Tj;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'boxes';
    protected $viewName =  'admin.pages.boxes';

    protected function getModel()
    {
        return new Box();
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
                'label' => 'core',
                'data' => 'core',
                'searchable' => false,
            ],
            [
                'label' => 'Connected',
                'data' => 'connected',
                'searchable' => false,
            ],
            [
                'label' => 'Remain',
                'data' => 'remain',
                'searchable' => false,
            ],
            [
                'label' => 'Zone',
                'data' => 'name',
                'relation' => 'zone',
                'searchable' => false,
            ],
            [
                'label' => 'Subxone',
                'data' => 'name',
                'relation' => 'subzone',
                'searchable' => false,
            ],
            [
                'label' => 'TJ',
                'data' => 'name',
                'relation' => 'tj',
                'searchable' => false,
            ],
            [
                'label' => 'Splitter',
                'data' => 'name',
                'relation' => 'splitter',
                'searchable' => false,
            ],
            [
                'label' => 'Box',
                'data' => 'name',
                'relation' => 'box',
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
        $page_title = "Box";
        $page_heading = "Box List";
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
        $page_title = "Box Create";
        $page_heading = "Box Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $zones = Zone::all();
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
            "zone_id" => ['required'],
            "subzone_id" => ['required'],
            "tj_id" => ['required'],
            "splitter_id" => ['required'],
            "box_id" => ['nullable'],
            "name" => ['required'],
            "core" => ['required'],
        ]);


        try {
            DB::beginTransaction();

            $box = $this->getModel()->create($valideted);

            if ($request->filled('box_id')) {
                $total_connected = $box->box->connected + 1;
                $box->box->update([
                    'connected' => $total_connected,
                    'remain' => $box->box->core - $total_connected,
                ]);
            }
            DB::commit();

            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Box $box)
    {

        $modal_title = 'Box Details';
        $modal_data = $box;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Box $box)
    {
        $page_title = "Box Edit";
        $page_heading = "Box Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $box->id);
        $editinfo = $box;
        $zones = Zone::all();
        $subzones = Subzone::where('zone_id', $box->zone_id)->get();
        $tjs = Tj::where('subzone_id', $box->subzone_id)
            ->get();
        $boxes = Box::where('id', '<>', $box->id)
            ->where('tj_id', $box->tj_id)
            ->whereColumn('connected', '<', 'core')
            ->get();

        // dd(get_defined_vars());
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Box $box)
    {
        $valideted = $this->validate($request, [
            "zone_id" => ['required'],
            "subzone_id" => ['required'],
            "tj_id" => ['required'],
            "splitter_id" => ['required'],
            "box_id" => ['nullable'],
            "name" => ['required'],
            "core" => ['required'],
        ]);

        try {
            DB::beginTransaction();

            //Cache old tj
            $box_cache = $box->box;

            //Update new box
            $box->update($valideted);

            //check box field has or not
            if ($request->filled('box_id')) {

                if ($box_cache) {
                    //remove old connection
                    $cache_total_connected = $box_cache->connected - 1;
                    $box_cache->update([
                        'connected' => $cache_total_connected,
                        'remain' => $box_cache->core - $cache_total_connected,
                    ]);
                }

                //add new connection
                $updated_box = $this->getModel()->find($box->id)->box;

                if ($updated_box) {
                    $total_connected = $updated_box->connected + 1;

                    $updated_box->update([
                        'connected' => $total_connected,
                        'remain' => $updated_box->core - $total_connected,
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        try {
            DB::beginTransaction();

            if ($box->box) {
                $parent_box = $box->box;

                $total_connected = $parent_box->connected - 1;

                $parent_box->update([
                    'connected' => $total_connected,
                    'remain' => $parent_box->core - $total_connected,
                ]);
            }

            $box->delete();

            DB::commit();
            return back()->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }
}
