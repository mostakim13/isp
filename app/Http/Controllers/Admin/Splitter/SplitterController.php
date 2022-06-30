<?php

namespace App\Http\Controllers\Admin\Splitter;

use App\Http\Controllers\Controller;
use App\Models\Core;
use App\Models\Splitter;
use App\Models\Subzone;
use App\Models\Tj;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SplitterController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'splitters';
    protected $viewName =  'admin.pages.splitters';

    protected function getModel()
    {
        return new Splitter();
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
                'label' => 'splitter',
                'data' => 'name',
                'relation' => 'splitter',
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
        $page_title = "Splitter";
        $page_heading = "Splitter List";
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
        $page_title = "Splitter Create";
        $page_heading = "Splitter Create";
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
            "splitter_id" => ['nullable'],
            "name" => ['required'],
            "core" => ['required'],
            "tj_core_id" => ['required'],
            "splitter_core_id" => ['nullable'],
            "colors.*" => [
                Rule::requiredIf(function () use ($request) {
                    return $request->core > 0;
                })
            ],
        ]);

        try {
            DB::beginTransaction();

            $splitter = $this->getModel()->create($valideted);

            if ($request->core > 0) {
                foreach ($request->colors as $index => $color) {
                    $splitter->cores()->create(['color' => $color]);
                }
            }

            if ($request->filled('splitter_id')) {
                $total_connected = $splitter->splitter->connected + 1;
                $splitter->splitter->update([
                    'connected' => $total_connected,
                    'remain' => $splitter->splitter->core - $total_connected,
                ]);
            }

            if ($request->filled('tj_core_id')) {
                Core::find($request->tj_core_id)->update(['status' => 'connected']);

                // $tj = Tj::find($request->tj_id);
                // $tj->update(['connected' => $tj->connected + 1, 'remain' => $tj->remain - 1]);
            }

            if ($request->filled('splitter_core_id')) {
                Core::find($request->splitter_core_id)->update(['status' => 'connected']);
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
    public function show(Request $request, Splitter $splitter)
    {

        $modal_title = 'Splitter Details';
        $modal_data = $splitter;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Splitter $splitter)
    {
        $page_title = "Splitter Edit";
        $page_heading = "Splitter Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $splitter->id);
        $editinfo = $splitter;
        $zones = Zone::all();
        $subzones = Subzone::where('zone_id', $splitter->zone_id)->get();
        $tjs = Tj::where('subzone_id', $splitter->subzone_id)
            ->get();
        $splitters = Splitter::where('id', '<>', $splitter->id)
            ->where('tj_id', $splitter->tj_id)
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
    public function update(Request $request, Splitter $splitter)
    {
        $valideted = $this->validate($request, [
            "zone_id" => ['required'],
            "subzone_id" => ['required'],
            "tj_id" => ['required'],
            "splitter_id" => ['nullable'],
            "name" => ['required'],
            "core" => ['required'],
        ]);

        try {
            DB::beginTransaction();

            //Cache old tj
            $splitter_cache = $splitter->splitter;

            //Update new splitter
            $splitter->update($valideted);

            //check splitter field has or not
            if ($request->filled('splitter_id')) {

                if ($splitter_cache) {
                    //remove old connection
                    $cache_total_connected = $splitter_cache->connected - 1;
                    $splitter_cache->update([
                        'connected' => $cache_total_connected,
                        'remain' => $splitter_cache->core - $cache_total_connected,
                    ]);
                }

                //add new connection
                $updated_splitter = $this->getModel()->find($splitter->id)->splitter;

                if ($updated_splitter) {
                    $total_connected = $updated_splitter->connected + 1;

                    $updated_splitter->update([
                        'connected' => $total_connected,
                        'remain' => $updated_splitter->core - $total_connected,
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
    public function destroy(Splitter $splitter)
    {
        try {
            DB::beginTransaction();

            if ($splitter->splitter) {
                $parent_splitter = $splitter->splitter;

                $total_connected = $parent_splitter->connected - 1;

                $parent_splitter->update([
                    'connected' => $total_connected,
                    'remain' => $parent_splitter->core - $total_connected,
                ]);
            }

            if ($splitter->tj_core_id) {
                Core::find($splitter->tj_core_id)->update(['status' => 'not connected']);
            }

            if ($splitter->splitter_core_id) {
                Core::find($splitter->splitter_core_id)->update(['status' => 'not connected']);
            }

            Splitter::where('splitter_id', $splitter->id)->delete();

            $splitter->delete();

            DB::commit();
            return back()->with('success', 'Data deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }
}
