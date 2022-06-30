<?php

namespace Database\Seeders;

use App\Models\Navigation;
use App\Models\RollPermission;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Navigation::truncate();
        $menus = [
            [
                'label' => 'Configration',
                'route' => null,
                'icon' => 'fa fa-congs',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Device',
                        'route' => 'devices.index',
                    ],
                    [
                        'label' => 'Connection Type',
                        'route' => 'connections.index',
                    ],
                    [
                        'label' => 'Client Type',
                        'route' => 'client_types.index',
                    ],
                    [
                        'label' => 'Protocol Type',
                        'route' => 'protocols.index',
                    ],
                    [
                        'label' => 'Packages',
                        'route' => 'packages2.index',
                    ],
                    [
                        'label' => 'User Package',
                        'route' => 'userpackage.index',
                    ],
                    [
                        'label' => 'Billing Status',
                        'route' => 'billingstatus.index',
                    ],
                    [
                        'label' => 'Payment Methods',
                        'route' => 'payments.index',
                    ],
                ]
            ],
            [
                'label' => 'Mikrotik Setup',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [

                    [
                        'label' => 'PPP Profiles',
                        'route' => 'm_p_p_p_profiles.index',
                    ],
                    [
                        'label' => 'IP Pool',
                        'route' => 'mpool.index',
                    ],
                    [
                        'label' => 'Vlan',
                        'route' => 'vlan.index',
                    ],
                    [
                        'label' => 'Ip Address',
                        'route' => 'ip_address.index',
                    ],

                ]
            ],
            [
                'label' => 'Network',
                'route' => null,
                'icon' => 'fa fa-congs',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'District',
                        'route' => 'district.index',
                    ],
                    [
                        'label' => 'Upazila',
                        'route' => 'upozilla.index',
                    ],
                    [
                        'label' => 'Zone',
                        'route' => 'zones.index',
                    ],
                    [
                        'label' => 'Sub zones',
                        'route' => 'subzones.index',
                    ],
                    [
                        'label' => 'TJ Box',
                        'route' => 'tjs.index',
                    ],
                    [
                        'label' => 'Splitter',
                        'route' => 'splitters.index',
                    ],
                    [
                        'label' => 'Box',
                        'route' => 'boxes.index',
                    ]
                ]
            ],
            // [
            //     'label' => 'Users',
            //     'route' => null,
            //     'icon' => 'fa fa-users',
            //     'parent_id' => 0,
            //     'submenu' => [
            //         [
            //             'label' => 'Create',
            //             'route' => 'users.create',
            //         ],
            //         [
            //             'label' => 'Users',
            //             'route' => 'users.index',
            //         ],
            //     ]
            // ],

            [
                'label' => 'Client',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    // [
                    //     'label' => 'New Connection',
                    //     'route' => 'newconnection.index',
                    // ],
                    [
                        'label' => 'All Customer',
                        'route' => 'customers.index',
                    ],
                    [
                        'label' => 'Create Customer',
                        'route' => 'customers.create',
                    ],
                    [
                        'label' => 'Advance Billing',
                        'route' => 'advancebilling.index',
                    ],
                    [
                        'label' => 'Active Connection',
                        'route' => 'activeconnections.index',
                    ],
                    [
                        'label' => 'Import Customer',
                        'route' => 'imports.customer',
                    ],

                ]
            ],

            [
                'label' => 'Billing',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Pending List',
                        'route' => 'billcollect.index',
                    ],
                    [
                        'label' => 'Collected List',
                        'route' => 'billcollected.index',
                    ],
                    [
                        'label' => 'Import Billings',
                        'route' => 'imports.billings',
                    ],

                ]
            ],
            [
                'label' => 'Mikrotik Server',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Server',
                        'route' => 'mikrotikserver.index',
                    ],
                ]
            ],

            [
                'label' => 'HR & PAYROLL',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Department',
                        'route' => 'department.index',
                    ],
                    [
                        'label' => 'Designation',
                        'route' => 'designation.index',
                    ],
                    [
                        'label' => 'Employee',
                        'route' => 'employees.index',
                    ],
                    [
                        'label' => 'Create Employee',
                        'route' => 'employees.create',
                    ],
                    [
                        'label' => 'Salary Sheet',
                        'route' => 'salarys.index',
                    ],
                ]
            ],
            [
                'label' => 'Mac Reseller',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Package',
                        'route' => 'macpackage.index',
                    ],
                    [
                        'label' => 'Tariff Config',
                        'route' => 'mactariffconfig.index',
                    ],
                    [
                        'label' => 'Add Mac Reseller',
                        'route' => 'macreseller.create',
                    ],
                    [
                        'label' => 'All Mac Reseller',
                        'route' => 'macreseller.index',
                    ],
                ]
            ],



            [
                'label' => 'Support & Ticketing',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Support Category',
                        'route' => 'supportcategory.index',
                    ],
                    [
                        'label' => 'Client Support',
                        'route' => 'supportticket.index',
                    ],
                ]
            ],

            [
                'label' => 'Bandwidth Buy',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Item',
                        'route' => 'items.index',
                    ],
                    [
                        'label' => 'Item Cateory',
                        'route' => 'itemcategory.index',
                    ],
                    [
                        'label' => 'Providers',
                        'route' => 'providers.index',
                    ],
                ]
            ],
            [
                'label' => 'Bandwidth Sale',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Clients',
                        'route' => 'bandwidthCustomers.index',
                    ],
                    [
                        'label' => 'Sale Invoice',
                        'route' => 'bandwidthsaleinvoice.index',
                    ],
                ]
            ],


            [
                'label' => 'Inventory Setup',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'All Products',
                        'route' => 'products.index',
                    ],
                    [
                        'label' => 'Create Products',
                        'route' => 'products.create',
                    ],
                    [
                        'label' => 'All Product Category',
                        'route' => 'productCategory.index',
                    ],
                    [
                        'label' => 'Create  Category',
                        'route' => 'productCategory.create',
                    ],

                    [
                        'label' => 'All Unit',
                        'route' => 'units.index',
                    ],
                    [
                        'label' => 'Create Unit',
                        'route' => 'units.create',
                    ],

                    [
                        'label' => 'All Brands',
                        'route' => 'brands.index',
                    ],
                    [
                        'label' => 'Create Brands',
                        'route' => 'brands.create',
                    ],

                ]
            ],
            [
                'label' => 'Inventory',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'All Purchases',
                        'route' => 'purchases.index',
                    ],
                    [
                        'label' => 'Create Purchases',
                        'route' => 'purchases.create',
                    ],
                    [
                        'label' => 'Stock Details',
                        'route' => 'purchases.stock.list',
                    ],
                    [
                        'label' => 'All Stock Out',
                        'route' => 'stockout.index',
                    ],
                    [
                        'label' => 'Create Stock Out',
                        'route' => 'stockout.create',
                    ],


                ]
            ],
            [
                'label' => 'Supplier',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'All Supplier',
                        'route' => 'suppliers.index',
                    ],
                    [
                        'label' => 'Create Supplier',
                        'route' => 'suppliers.create',
                    ],
                ]
            ],
            [
                'label' => 'Reports',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'BTRC',
                        'route' => 'reports.btrc',
                    ],
                    [
                        'label' => 'Discount',
                        'route' => 'reports.discounts',
                    ],
                    [
                        'label' => 'Bill Collect',
                        'route' => 'reports.bill.index',
                    ],
                    [
                        'label' => 'Customer',
                        'route' => 'reports.customers',
                    ],

                ]
            ],
            [
                'label' => 'Asset Management',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Asset Category',
                        'route' => 'assets.index',
                    ],
                    // [
                    //     'label' => 'Asset Category Create',
                    //     'route' => 'assets.create',
                    // ],
                    [
                        'label' => 'Reason List',
                        'route' => 'reasons.index',
                    ],
                    [
                        'label' => 'Asset List',
                        'route' => 'assetlist.index',
                    ],
                    [
                        'label' => 'Destroy Items',
                        'route' => 'destroyitems.index',
                    ],
                ]
            ],
            [
                'label' => 'Accounting',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Accounts Head',
                        'route' => 'accounts.index',
                    ],
                    [
                        'label' => 'Opening Balance',
                        'route' => 'openingbalance.index',
                    ],
                    [
                        'label' => 'Balance Transfer',
                        'route' => 'balancetransfer.index',
                    ],
                    [
                        'label' => 'Bill Transfer',
                        'route' => 'billtransfer.index',
                    ],
                    [
                        'label' => 'Supplier Ledger',
                        'route' => 'supplier_ledger.index',
                    ],
                ]
            ],
            [
                'label' => 'Income',
                'route' => null,
                'icon' => 'fa fa-users',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'Income Category',
                        'route' => 'incomeCategory.index',
                    ],
                    [
                        'label' => 'Daily Income',
                        'route' => 'dailyIncome.index',
                    ],
                    [
                        'label' => 'Income History',
                        'route' => 'incomeHistory.index',
                    ],
                    [
                        'label' => 'Installation Fee',
                        'route' => 'installationFee.index',
                    ],
                ]
            ],

            [
                'label' => 'Expense',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [

                    [
                        'label' => 'Expense List',
                        'route' => 'expenses.index',
                    ],
                    [
                        'label' => 'Create Expense',
                        'route' => 'expenses.create',
                    ],
                    [
                        'label' => 'Expense Category',
                        'route' => 'expense_category.index',
                    ],
                    [
                        'label' => 'Create Expense Category',
                        'route' => 'expense_category.create',
                    ],

                ]
            ],

            [
                'label' => 'Client Support',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [

                    [
                        'label' => 'Ticketing',
                        'route' => 'ticketing.index',
                    ],
                    [
                        'label' => 'Support History',
                        'route' => 'supporthistory.index',
                    ],


                ]
            ],
            [
                'label' => 'Billing Details',
                'route' => 'billing_details.index',
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [],
            ],
            [
                'label' => 'Package Update and Down Rate',
                'route' => 'package_update_and_down_rate.index',
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [],
            ],

            [
                'label' => 'SMS Service',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'All Sms',
                        'route' => 'sms.index',
                    ],
                    [
                        'label' => 'Create Sms',
                        'route' => 'sms.create',
                    ],
                ]
            ],
            // [
            //     'label' => 'PayRoll',
            //     'route' => null,
            //     'icon' => 'fa fa-cogs',
            //     'parent_id' => 0,
            //     'submenu' => [
            //         [
            //             'label' => 'All Salary',
            //             'route' => 'salarys.index',
            //         ],
            //     ]
            // ],
            // [
            //     'label' => 'Packages',
            //     'route' => null,
            //     'icon' => 'fa fa-cogs',
            //     'parent_id' => 0,
            //     'submenu' => [

            //         [
            //             'label' => 'Packages',
            //             'route' => 'packages.index',
            //         ],

            //     ]
            // ],

            // [
            //     'label' => 'Discount',
            //     'route' => null,
            //     'icon' => 'fa fa-cogs',
            //     'parent_id' => 0,
            //     'submenu' => [

            //         [
            //             'label' => 'Discount',
            //             'route' => 'discounts.index',
            //         ],

            //     ]
            // ],
            [
                'label' => 'System',
                'route' => null,
                'icon' => 'fa fa-cogs',
                'parent_id' => 0,
                'submenu' => [
                    [
                        'label' => 'User Roll',
                        'route' => 'rollPermission.index',
                    ],
                    [
                        'label' => 'Company Setup',
                        'route' => 'companies.index',
                    ],

                ]
            ],
        ];

        $main = array();
        $submain = array();
        foreach ($menus as $key => $menu) {
            $navigration  = new Navigation();
            $navigration->label = $menu['label'];
            $navigration->route = $menu['route'];
            $navigration->icon = $menu['icon'];
            $navigration->parent_id = 0;
            $navigration->navigate_status = 1;
            $navigration->save();
            $mainadd['parent_id'] =  $navigration->id;
            if (isset($menu['submenu']) && count($menu['submenu']) > 0) {
                foreach ($menu['submenu'] as $index => $submenu) {
                    $child = new Navigation();
                    $child->label = $submenu['label'];
                    $child->route = $submenu['route'];
                    $child->parent_id = $navigration->id;
                    $child->navigate_status = 1;
                    $child->save();
                    $submainadd['child_id'] =  $child->id;
                    array_push($submain, $submainadd);
                }
            }
            array_push($main, $mainadd);
            $navigration->submenu = $menu['submenu'];
        }
        $parent_id = array_map('array_pop', $main);
        $child_id = array_map('array_pop', $submain);
        RollPermission::create([
            "name" => "Super Admin",
            "parent_id" => implode(',', $parent_id),
            "child_id" => implode(',', $child_id),
        ]);
    }
}