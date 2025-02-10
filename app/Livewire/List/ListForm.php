<?php

namespace App\Livewire\List;

use App\Models\Fetch;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ListForm extends Form
{
    #[Validate('required|min:2|max:100')]
    public string $name;

    public Fetch $list;

    public function setupList(Fetch $list)
    {
        $this->list = $list;
        $this->name = $list->name;
    }

    public function makeList()
    {
        $this->validate();

        $list = new Fetch;

        $list->name = $this->name;
        $list->save();

        $this->list = $list;
    }

    public function updateList()
    {
        $this->validate();
        $this->list->name = $this->name;
        $this->list->save();
    }

    public function listPage()
    {
        return $this->list?->page();
    }
}
