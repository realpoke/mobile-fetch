<?php

namespace App\Livewire\Landing;

use App\Models\Fetch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class LandingListsComponent extends Component
{
    public function getListeners(): array
    {
        $listeners = new Collection;
        foreach ($this->lists as $item) {
            $listeners->add(['echo:list.'.$item->id.'.'.$item->password.',UpdatedListEvent' => '$refresh']);
        }

        return $listeners->collapse()->toArray();
    }

    #[Computed()]
    public function lists(): Collection
    {
        $lists = collect(request()->cookies->all())
            ->filter(fn ($value, $key) => Str::startsWith($key, 'l_'))
            ->keyBy(fn ($value, $key) => Str::after($key, 'l_'));

        $modelLists = new Collection;
        foreach ($lists as $id => $password) {
            $fetch = Fetch::where('id', $id)->where('password', $password)->first();

            if (! is_null($fetch)) {
                $modelLists->add($fetch);
            } else {
                Cookie::queue(Cookie::forget('l_'.$id));
            }
        }

        return $modelLists;
    }

    #[On('new-list-cookie')]
    public function render()
    {
        return view('livewire.landing.landing-lists-component');
    }
}
