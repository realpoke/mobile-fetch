<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfileNameComponent extends Component
{
    public string $name;

    #[On('profile-updated')]
    public function profileUpdated(string $name)
    {
        $this->name = $name;
    }

    public function render()
    {
        $this->name = Cookie::get('name');

        return view('livewire.profile.profile-name-component');
    }
}
