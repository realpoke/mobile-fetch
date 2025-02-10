<?php

namespace App\Livewire\Profile;

use Flux\Flux;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ProfileFormComponent extends Component
{
    public ProfileForm $form;

    public function updateProfile()
    {
        $this->form->submit();

        Flux::toast('Profile updated!', variant: 'success');
        Flux::modal('edit-profile')->close();

        $this->dispatch('profile-updated', $this->form->name);
    }

    public function deleteProfile()
    {
        $this->form->deleteMe();

        Flux::toast('Profile deleted!', variant: 'success');

        $this->redirect(route('name.page'), true);
    }

    public function mount()
    {
        $this->form->name = Cookie::get('name');
    }

    public function render()
    {
        return view('livewire.profile.profile-form-component');
    }
}
