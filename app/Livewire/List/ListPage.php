<?php

namespace App\Livewire\List;

use App\Enums\ItemStatusEnum;
use App\Events\AddedItemToListEvent;
use App\Events\DeletedListEvent;
use App\Events\RefreshListEvent;
use App\Events\UpdatedListEvent;
use App\Events\UpdatedListRowEvent;
use App\Livewire\Profile\ProfileForm;
use App\Models\Fetch;
use Flux\Flux;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

use function Illuminate\Support\defer;

#[Title('title.list')]
#[On('echo:list.{list.id}.{list.password},UpdatedListEvent')]
#[On('echo:list.{list.id}.{list.password},RefreshListEvent')]
#[On('echo:list.{list.id}.{list.password},RemovedItemFromListEvent')]
#[On('echo:list.{list.id}.{list.password},AddedItemToListEvent')]
class ListPage extends Component
{
    public ProfileForm $profileForm;

    public ListForm $form;

    public ItemForm $itemForm;

    public string $search = '';

    #[Locked]
    public Fetch $list;

    public function updated($property)
    {
        if ($property === 'itemForm.name') {
            $this->search = $this->itemForm->name;
            $this->itemForm->resetErrorBag();
        }
    }

    #[On('echo:list.{list.id}.{list.password},DoneListEvent')]
    public function allDone()
    {
        if ($this->list->refresh()->items()->notDone()->count() == 0) {
            Flux::modal('done-modal')->show();
        }
    }

    public function addItem()
    {
        $validated = $this->profileForm->validate();
        if ($this->itemForm->addItem($validated['name'], $this->list->id)) {
            Flux::toast(__('item.added'), variant: 'success');
            $this->reset('search');
            defer(fn () => broadcast(new AddedItemToListEvent($this->list->id, $this->list->password)));
        }
    }

    public function deleteList()
    {
        $this->list->delete();
        Flux::toast(__('list.deleted'), variant: 'success');
        broadcast(new DeletedListEvent($this->list->id, $this->list->password));
    }

    public function updateList()
    {
        $this->form->updateList();
        Flux::toast(__('list.updated'), variant: 'success');

        defer(fn () => broadcast(new UpdatedListEvent($this->list->id, $this->list->password, $this->form->name)));
    }

    public function forgetList()
    {
        Cookie::queue(Cookie::forget('l_'.$this->list->id));
        Flux::toast(__('list.forgot'), variant: 'success');

        return $this->redirect(route('landing.page'), true);
    }

    public function fullReset()
    {
        $this->list->items()->update([
            'status' => ItemStatusEnum::default(),
            'fetched_by' => null,
        ]);
        broadcast(new RefreshListEvent($this->list->id, $this->list->password));
        broadcast(new UpdatedListRowEvent($this->list->id, $this->list->password));
    }

    public function mount(string $slug, string $password)
    {
        $lists = Fetch::where('slug', $slug)->get();

        $foundList = null;
        foreach ($lists as $list) {
            if ($list->password === $password) {
                $foundList = $list;
                break;
            }
        }

        if (is_null($foundList)) {
            return $this->redirect(route('landing.page'), true);
        }

        $this->list = $foundList;

        if (! Cookie::has('l_'.$this->list->id)) {
            Cookie::queue(Cookie::forever('l_'.$this->list->id, $this->list->password));
            $this->dispatch('new-list-cookie');
        }

        $this->profileForm->setupUser(Cookie::get('name'));
    }

    #[On('echo:list.{list.id}.{list.password},RefreshListEvent')]
    public function render()
    {
        $refreshedList = $this->list->refresh();
        $items = $refreshedList->items()->search($this->search)->notDone()->get();
        $doneItems = $refreshedList->items()->search($this->search)->done()->get();
        $this->form->setupList($refreshedList);

        return view('livewire.list.list-page', [
            'items' => $items,
            'items_count' => $items->count(),
            'done_items' => $doneItems,
            'done_count' => $doneItems->count(),
        ]);
    }
}
