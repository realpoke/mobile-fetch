<?php

namespace App\Livewire\List;

use App\Models\Item;
use Livewire\Form;

class ItemForm extends Form
{
    public string $name;

    protected $rules = [
        'name' => 'required|min:1|max:100',
    ];

    public function addItem(string $by, int $listId): bool
    {
        $this->validate();

        $item = new Item;
        $item->name = $this->name;
        $item->added_by = $by;
        $item->fetch_id = $listId;

        $this->name = '';

        return $item->save();
    }
}
