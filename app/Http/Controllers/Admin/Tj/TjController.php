<?php

namespace App\Http\Controllers\Admin\Tj;

use App\Http\Controllers\Controller;
use App\Models\Core;
use App\Models\Splitter;
use App\Models\Subzone;
use App\Models\Tj;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TjController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'tjs';
    protected $viewName =  'admin.pages.tjs';

    protected function getModel()
    {
        return new Tj();
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
        $page_title = "Tj";
        $page_heading = "Tj List";
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
        $page_title = "TJ Create";
        $page_heading = "TJ Create";
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
            "tj_id" => ['nullable'],
            "name" => ['required'],
            "core" => ['required'],
            "core_id" => ['nullable'],
            "colors.*" => [
                Rule::requiredIf(function () use ($request) {
                    return $request->core > 0;
                })
            ],
        ]);

        try {
            DB::beginTransaction();

            $tj = Tj::create($valideted);

            if ($request->core > 0) {
                foreach ($request->colors as $index => $color) {
                    $tj->cores()->create(['color' => $color]);
                }
            }


            if ($request->filled('tj_id')) {
                $total_connected = $tj->tj->connected + 1;
                $tj->tj->update([
                    'connected' => $total_connected,
                    'remain' => $tj->tj->core - $total_connected,
                ]);
            }

            if ($request->filled('core_id')) {
                Core::find($request->core_id)->update(['status' => 'connected']);
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
    public function show(Request $request, Tj $tj)
    {

        $modal_title = 'Tj Details';
        $modal_data = $tj;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Tj $tj)
    {
        $page_title = "Tj Edit";
        $page_heading = "Tj Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $tj->id);
        $editinfo = $tj;
        $zones = Zone::all();
        $subzones = Subzone::where('zone_id', $editinfo->zone_id)->get();
        $tjs = Tj::where('id', '<>', $tj->id)
            ->where('subzone_id', $tj->subzone_id)
            ->whereColumn('connected', '<', 'core')
            ->get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tj $tj)
    {
        $valideted = $this->validate($request, [
            "zone_id" => ['required'],
            "subzone_id" => ['required'],
            "tj_id" => ['nullable'],
            "name" => ['required'],
            "core" => ['required'],
        ]);

        try {
            DB::beginTransaction();

            //Cache old tj
            $tj_cache = $tj->tj;

            //Update new tj
            $tj->update($valideted);


            // if ($request->core > 0) {
            //     foreach ($request->colors as $index => $color) {
            //         $tj->cores()->create(['color' => $color]);
            //     }
            // }

            //check tj field has or not
            if ($request->filled('tj_id')) {

                if ($tj_cache) {
                    //remove old connection
                    $cache_total_connected = $tj_cache->connected - 1;
                    $tj_cache->update([
                        'connected' => $cache_total_connected,
                        'remain' => $tj_cache->core - $cache_total_connected,
                    ]);
                }
                //add new connection
                $updated_tj = $this->getModel()::find($tj->id)->tj;

                if ($updated_tj) {
                    $total_connected = $updated_tj->connected + 1;

                    $updated_tj->update([
                        'connected' => $total_connected,
                        'remain' => $updated_tj->core - $total_connected,
                    ]);
                }

                if ($request->filled('core_id')) {
                    Core::find($request->core_id)->update(['status' => 'connected']);
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
    public function destroy(Tj $tj)
    {
        try {
            DB::beginTransaction();

            if ($tj->tj) {
                $parent_tj = $tj->tj;

                $total_connected = $parent_tj->connected - 1;

                $parent_tj->update([
                    'connected' => $total_connected,
                    'remain' => $parent_tj->core - $total_connected,
                ]);
            }
            if ($tj->core_id) {
                Core::find($tj->core_id)->update(['status' => 'not connected']);
            }

            Tj::where('tj_id', $tj->id)->delete();

            $tj->delete();

            DB::commit();
            return back()->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }
}
