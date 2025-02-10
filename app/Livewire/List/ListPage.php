<?php

namespace App\Livewire\List;

use App\Events\UpdatedListEvent;
use App\Models\Fetch;
use Flux\Flux;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

use function Illuminate\Support\defer;

#[On('echo:list.{list.id}.{list.password},UpdatedListEvent')]
class ListPage extends Component
{
    public ListForm $form;

    #[Locked]
    public Fetch $list;

    public function deleteList()
    {
        $this->list->delete();
        Flux::toast(__('list.deleted'), variant: 'success');

        return $this->redirect(route('landing.page'), true);
    }

    public function updateList()
    {
        $this->form->updateList();
        Flux::toast(__('list.updated'), variant: 'success');

        defer(fn () => broadcast(new UpdatedListEvent($this->list->id, $this->list->password)));
    }

    public function forgetList()
    {
        Cookie::queue(Cookie::forget('l_'.$this->list->id));
        Flux::toast(__('list.forgot'), variant: 'success');

        return $this->redirect(route('landing.page'), true);
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
        $this->form->setupList($foundList);

        if (! Cookie::has('l_'.$this->list->id)) {
            Cookie::queue(Cookie::forever('l_'.$this->list->id, $this->list->password));
            $this->dispatch('new-list-cookie');
        }
    }
}
