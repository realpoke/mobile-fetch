<?php

namespace App\Livewire\Landing;

use App\Models\Fetch;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\On;
use Livewire\Component;

class LandingListRowComponent extends Component
{
    public $id;

    public $password;

    public $name;

    public $page;

    public $hide = false;

    #[On('echo:list.{id}.{password},DeletedListEvent')]
    public function deleteList(array $data)
    {
        if ($data['id'] == $this->id) {
            $fetch = Fetch::where('id', $this->id)->where('password', $this->password)->first();
            if (is_null($fetch)) {
                Cookie::queue(Cookie::forget('l_'.$this->id));
                $this->hide = true;
            }
        }
    }

    public function render()
    {
        $fetch = Fetch::where('id', $this->id)->where('password', $this->password)->first();

        if (! is_null($fetch)) {
            $this->name = $fetch->name;
            $this->page = $fetch->page();
        } else {
            Cookie::queue(Cookie::forget('l_'.$this->id));
            $this->hide = true;
        }

        return view('livewire.landing.landing-list-row-component');
    }
}
