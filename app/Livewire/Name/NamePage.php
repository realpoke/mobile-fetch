<?php

namespace App\Livewire\Name;

use App\Livewire\Profile\ProfileForm;
use Illuminate\Support\Facades\Cookie;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('title.name')]
class NamePage extends Component
{
    public ProfileForm $form;

    public function setupName()
    {
        $this->form->submit();

        if (Cookie::has('next')) {
            return $this->redirect(Cookie::get('next'), true);
        }

        return $this->redirect(route('landing.page'), true);
    }
}
