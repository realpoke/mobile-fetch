<?php

namespace App\Livewire\List;

use App\Enums\ItemStatusEnum;
use App\Events\DoneListEvent;
use App\Events\RefreshListEvent;
use App\Events\RemovedItemFromListEvent;
use App\Events\UpdatedListRowEvent;
use App\Models\Item;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

use function Illuminate\Support\defer;

class ListRowComponent extends Component
{
    public Item $item;

    public $id;

    public $password;

    #[Locked]
    public $fetcher;

    public function nextStatus()
    {
        $oldStatus = $this->item->status;

        $this->item->fetched_by = $this->fetcher;
        $this->item->status = $this->item->status->next();
        $this->item->save();

        if (in_array($this->item->status->value, ItemStatusEnum::doneStatues())) {
            if (in_array($oldStatus->value, ItemStatusEnum::notDoneStatues())) {
                defer(fn () => broadcast(new DoneListEvent($this->id, $this->password)));
            }
            defer(fn () => broadcast(new RefreshListEvent($this->id, $this->password)));
        } else {
            defer(fn () => broadcast(new UpdatedListRowEvent($this->id, $this->password)));
        }
    }

    public function resetStatus()
    {
        $this->item->status = ItemStatusEnum::default();
        $this->item->fetched_by = null;
        $this->item->save();
        defer(fn () => broadcast(new RefreshListEvent($this->id, $this->password)));
    }

    public function deleteItem()
    {
        defer(fn () => $this->item->delete());
        broadcast(new RemovedItemFromListEvent($this->id, $this->password));
        $this->skipRender();
    }

    #[On('echo:list.{id}.{password},UpdatedListRowEvent')]
    public function render()
    {
        return view('livewire.list.list-row-component');
    }
}
