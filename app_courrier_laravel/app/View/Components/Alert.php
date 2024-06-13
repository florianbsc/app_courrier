<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

// class Alert extends Component
// {
//     /**
//      * Create a new component instance.
//      */
//     public function __construct()
//     {
//         //
//     }

//     /**
//      * Get the view / contents that represent the component.
//      */
//     public function render(): View|Closure|string
//     {
//         return view('components.alert');
//     }
// }


class Alert extends Component
{
    public $type;
    public $message;

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param mixed $message
     * @return void
     */
    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
