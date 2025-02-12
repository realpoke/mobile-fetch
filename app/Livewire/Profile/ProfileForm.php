<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProfileForm extends Form
{
    #[Validate('required|min:2|max:30')]
    public string $name;

    public function submit()
    {
        $this->validate();

        Cookie::queue(Cookie::forever('name', $this->name));
    }

    public function deleteMe()
    {
        Cookie::queue(Cookie::forget('name'));

        $cookies = collect(request()->cookies->all())
            ->filter(fn ($value, $key) => Str::startsWith($key, 'l_'))
            ->keyBy(fn ($value, $key) => Str::after($key, 'l_'));

        foreach ($cookies as $id => $cookie) {
            Cookie::queue(Cookie::forget('l_'.$id));
        }
    }

    public function setupUser(string $name)
    {
        $this->name = $name;
    }
}
