<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Box;
use App\Models\Splitter;
use App\Models\Subzone;
use App\Models\Tj;
use App\Models\Zone;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function zones(Request $request)
    {
        return Zone::get();
    }

    public function get_subzones(Request $request)
    {
        $subzones = new Subzone();

        if ($request->zone_id) {
            $subzones = $subzones->where('zone_id', $request->zone_id);
        }

        $subzones = $subzones->get(['id', 'name']);

        $options = '<option value="" selected disabled>Select Option</option>';
        foreach ($subzones as $subzone) {
            $options .= '<option value="' . $subzone->id . '">' . $subzone->name . '</option>';
        }

        return $options;
    }

    public function get_tjs(Request $request)
    {
        $tjs = new Tj();

        if ($request->subzone_id) {
            $tjs = $tjs->where('subzone_id', $request->subzone_id);
        }
        $tjs = $tjs->whereColumn('connected', '<', 'core');
        $tjs = $tjs->get();

        $options = '<option value="">Select Option</option>';
        if ($tjs->isNotEmpty()) {
            foreach ($tjs as $tj) {
                $options .= '<option value="' . $tj->id . '">' . $tj->name . ' (' . $tj->remain . ') </option>';
            }
        }

        return $options;
    }

    public function get_splitters(Request $request)
    {
        $splitters = new Splitter();

        if ($request->tj_id) {
            $splitters = $splitters->where('tj_id', $request->tj_id);
        }
        $splitters = $splitters->whereColumn('connected', '<', 'core');
        $splitters = $splitters->get();

        $options = '<option value="">Select Option</option>';
        if ($splitters->isNotEmpty()) {
            foreach ($splitters as $splitter) {
                $options .= '<option value="' . $splitter->id . '">' . $splitter->name . ' (' . $splitter->remain . ') </option>';
            }
        }

        return $options;
    }
    public function get_boxes(Request $request)
    {
        $boxes = new Box();

        if ($request->splitter_id) {
            $boxes = $boxes->where('splitter_id', $request->splitter_id);
        }
        $boxes = $boxes->whereColumn('connected', '<', 'core');
        $boxes = $boxes->get();

        $options = '<option value="">Select Option</option>';
        if ($boxes->isNotEmpty()) {
            foreach ($boxes as $box) {
                $options .= '<option value="' . $box->id . '">' . $box->name . ' (' . $box->remain . ') </option>';
            }
        }

        return $options;
    }


    public function findAvailabelCore(Request $request)
    {
        $model = $request->model_name::find($request->model_id);

        $options = '<option value="">Select Option</option>';
        if ($model) {
            foreach ($model->cores()->where('status', 'not connected')->get() as $core) {
                $options .= '<option value="' . $core->id . '">' . $core->color . ' </option>';
            }
        }

        return $options;
    }

    public function get_splitterscore(Request $request)
    {
        $model = $request->model_name::where("tj_core_id", $request->model_id);
        dd($model->get());
        $options = '<option value="">Select Option</option>';

        if ($model) {
            foreach ($model->get() as $spliter) {
                $options .= '<option value="' . $spliter->id . '">' . $spliter->name . ' </option>';
            }
        }

        return $options;
    }



    /**
     * get results for when add new clients
     */

    public function get_tjs_for_new_clients(Request $request)
    {
        $tjs = new Tj();

        if ($request->subzone_id) {
            $tjs = $tjs->where('subzone_id', $request->subzone_id);
        }

        $tjs = $tjs->get();

        $options = '<option value="">Select Option</option>';
        if ($tjs->isNotEmpty()) {
            foreach ($tjs as $tj) {
                $options .= '<option value="' . $tj->id . '">' . $tj->name . ' (' . $tj->remain . ') </option>';
            }
        }

        return $options;
    }



    /**
     * Get cores
     */
    public function get_cores_for_new_clients(Request $request)
    {
        $this->validate($request, [
            'model_name' => ['required'],
            'model_id' => ['required']
        ]);

        $model = $request->model_name::find($request->model_id);

        $options = '<option value="">Select Option</option>';

        if ($model) {
            foreach ($model->cores as $core) {
                $options .= '<option value="' . $core->id . '">' . $core->color . ' </option>';
            }
        }

        return $options;
    }


    /**
     * Get Spliter list
     */
    public function get_splitters_for_new_clients(Request $request)
    {
        $this->validate($request, [
            'column_name' => ['required'],
            'id' => ['required'],
        ]);
        $splitters = new Splitter();

        if ($request->id) {
            $splitters = $splitters->where($request->column_name, $request->id);
        }

        $splitters = $splitters->get();

        $options = '<option value="">Select Option</option>';

        if ($splitters->isNotEmpty()) {
            foreach ($splitters as $splitter) {
                $options .= '<option value="' . $splitter->id . '">' . $splitter->name . ' (' . $splitter->remain . ') </option>';
            }
        }

        return $options;
    }
}
