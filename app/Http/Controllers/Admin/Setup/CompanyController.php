<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'companies';
    protected $viewName =  'admin.pages.companies';

    protected function getModel()
    {
        return new Company();
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
                'label' => 'Logo',
                'data' => 'logo',
                'searchable' => false,
            ],
            [
                'label' => 'Compnay Name',
                'data' => 'company_name',
                'searchable' => false,
            ],
            [
                'label' => 'Title',
                'data' => 'website',
                'searchable' => false,
            ],
            [
                'label' => 'Phone',
                'data' => 'phone',
                'searchable' => false,
            ],
            [
                'label' => 'Email',
                'data' => 'email',
                'searchable' => false,
            ],
            [
                'label' => 'Address',
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
        $page_title = "Company";
        $page_heading = "Company Setup";
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
                'edit'
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
        $page_title = "Company Create";
        $page_heading = "Company Create";
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
            "logo" => ['image'],
            "favicon" => ['image'],
            "invoice_logo" => ['image'],
            "company_name" => ['string'],
            "website" => ['string'],
            "phone" => ['string'],
            "email" => ['email'],
            "address" => ['string'],
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                $path =  $request->file('logo')->store('compnay', 'public');
                $valideted['logo'] = $path;
            }
            if ($request->hasFile('favicon')) {
                $path =  $request->file('favicon')->store('compnay', 'public');
                $valideted['favicon'] = $path;
            }
            if ($request->hasFile('invoice_logo')) {
                $path =  $request->file('invoice_logo')->store('compnay', 'public');
                $valideted['invoice_logo'] = $path;
            }

            $valideted['create_by'] = auth()->id();
            $this->getModel()->create($valideted);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'Line' . $e->getLine() . 'File' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Company $company)
    {
        $modal_title = 'Company Details';
        $modal_data = $company;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $page_title = "Company Edit";
        $page_heading = "Company Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $company->id);
        $editinfo = $company;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $valideted = $this->validate($request, [
            "logo" => ['image'],
            "favicon" => ['image'],
            "invoice_logo" => ['image'],
            "company_name" => ['string'],
            "website" => ['string'],
            "phone" => ['string'],
            "email" => ['email'],
            "address" => ['string'],
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                if ($company->logo) {
                    Storage::disk('public')->delete($company->logo);
                }
                $path =  $request->file('logo')->store('compnay', 'public');
                $valideted['logo'] = $path;
            }
            if ($request->hasFile('favicon')) {
                if ($company->favicon) {
                    Storage::disk('public')->delete($company->favicon);
                }
                $path =  $request->file('favicon')->store('compnay', 'public');
                $valideted['favicon'] = $path;
            }
            if ($request->hasFile('invoice_logo')) {
                if ($company->invoice_logo) {
                    Storage::disk('public')->delete($company->invoice_logo);
                }
                $path =  $request->file('invoice_logo')->store('compnay', 'public');
                $valideted['invoice_logo'] = $path;
            }

            $valideted['update_by'] = auth()->id();
            $company->update($valideted);

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
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
