<?php

namespace App\Http\Controllers;

use App\Imports\BillingImport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function user_import_form()
    {
        $page_heading = "Customers Import Form";

        $store_url = route('imports.customer');

        return view('admin.pages.imports.user', get_defined_vars());
    }

    public function user_file_import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);

        Excel::import(new UsersImport, $request->file);

        return back()->with('success', 'User Imported successfully');
    }

    public function billing_import_form()
    {
        $page_heading = "Billing Import Form";

        $store_url = route('imports.billings');

        return view('admin.pages.imports.billing', get_defined_vars());
    }

    public function billing_file_import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);
        Excel::import(new BillingImport, $request->file);

        return back()->with('success', 'User Imported successfully');
    }
}
