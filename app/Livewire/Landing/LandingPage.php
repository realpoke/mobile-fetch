<?php

namespace App\Livewire\Landing;

use App\Livewire\List\ListForm;
use Flux\Flux;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('title.landing')]
class LandingPage extends Component
{
    public ListForm $form;

    public function createList()
    {
        $this->form->makeList();

        Flux::toast('List created!', variant: 'success');
        $this->redirect($this->form->listPage(), true);
    }

    public function render()
    {
        return view('livewire.landing.landing-page');
    }
}
