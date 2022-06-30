<?php

namespace App\Http\Controllers;

use App\Models\GroupAccess;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccessController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private $accesses = [

        ["basic", "Basic", 'access' => [
            ["dashboard", "Dashboard show"]
        ]],

        ["user", "User", "access" => [
            ["user_list", "User table show"],
            ["user_create", "User create"],
            ["user_update", "User edit and update"],
            ["user_delete", "User delete"],
            ["user_access", "User permission access"],
        ]],

        ["group", "Group", "access" => [
            ["group_list", "Group table show"],
            ["group_update", "Group create, edit and update"],
            ["group_delete", "Group delete"],
            ["group_access", "Group permission access"],
        ]],

    ];

    /**
     * Retrive All Access Array List
     */
    public static function getAccessArr()
    {
        return (new Self())->accesses;
    }

    /**
     * Check Access is Present or Not
     */
    public static function hasAccessInSession($key)
    {
        $access_arr = [];
        if (Session::has("group_access")) {
            $access_arr = Session::get("group_access");
        } else {
            $access_arr = "";
        }
    }

    /**
     * Store Access Group Permission
     */
    public function storePermission(Request $request, $group)
    {
        try {
            $group_access = GroupAccess::where("group_id", $group->id)->first();
            if (empty($group_access)) {
                $group_access = new GroupAccess();
            }
            $group_access->group_id = $group->id;
            $group_access->group_access = $request->access;
            $group_access->save();

            $group_permission = Auth::user()->group->group_accesses->group_access ?? [];
            Session::put('group_permission', $group_permission);

            return back()->with('success', "Group Permission Update Successfully");
        } catch (Exception $e) {
            return back()->with('failed', $this->getError($e));
        }
    }


    /**
     * Get or Reterve All Permission Under this User
     */
    protected function getAccessPermission()
    {
        if (Session::has('group_permission')) {
            return Session::get('group_permission');
        }
        $group_permission = Auth::user()->group->group_accesses->group_access ?? [];
        Session::put('group_permission', $group_permission);
        return $group_permission;
    }

    /**
     * Check The Access Permission
     * If Developer Then @return true
     * @param String | Array
     * @return bool
     */
    public static function checkAccess($access_arr)
    {
        if (Auth::user()->is_developer) {
            return true;
        }

        if (!is_array($access_arr)) {
            $access_arr = [$access_arr];
        }

        $permissions = (new AccessController())->getAccessPermission();
        foreach ($access_arr as $key) {
            if (in_array($key, $permissions)) {
                return true;
            }
        }
    }

    /**
     * Check The Access Permission
     * @param permissions => String | Array
     * @return bool
     */
    public static function hasAccess($access_arr, $permissions = [])
    {
        if (!is_array($access_arr)) {
            $access_arr = [$access_arr];
        }
        if (count($permissions) == 0) {
            $permissions = (new AccessController())->getAccessPermission();
        }

        foreach ($access_arr as $key) {
            if (in_array($key, $permissions)) {
                return true;
            }
        }
    }

    public function logout()
    {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('/');
    }
}
