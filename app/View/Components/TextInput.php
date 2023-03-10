<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;
class TextInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $name, $class , $value , $hidden, $disabled;
    public function __construct($name, $class , $value = null, $disabled = false)
    {
        $this->name = $name;
        $this->class = $class;
        $this->value = $value;
        $this->disabled = $disabled;
        $this->hidden  = Str::endsWith($name, '_id');
        // dd($this->hidden);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.text-input');
    }
}
