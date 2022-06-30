<?php

namespace App\View\Components;

use App\Models\Navigation;
use App\Models\RollPermission;
use Illuminate\View\Component;

class Sidebar extends Component
{

    public $navigations;
    public $userRoll;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->navigations = Navigation::with('children')->where('parent_id', 0)
            ->get(['id', 'label', 'route', 'parent_id', 'navigate_status']);
        $this->userRoll = RollPermission::find(auth()->user()->roll_id ?? 1);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}
