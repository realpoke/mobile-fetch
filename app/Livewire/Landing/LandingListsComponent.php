<?php

namespace App\Livewire\Landing;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('new-list-cookie')]
class LandingListsComponent extends Component
{
    #[Computed()]
    public function lists(): Collection
    {
        $lists = collect(request()->cookies->all())
            ->filter(fn ($value, $key) => Str::startsWith($key, 'l_'))
            ->keyBy(fn ($value, $key) => Str::after($key, 'l_'));

        return $lists;
    }

    public function render()
    {
        return view('livewire.landing.landing-lists-component');
    }
}
