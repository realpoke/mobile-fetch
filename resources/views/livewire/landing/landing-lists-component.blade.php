<div>
    @if ($this->lists->isNotEmpty())
        <flux:navlist.group expandable expanded="false" heading="{{ __('list.lists') }}">
            @foreach ($this->lists as $id => $password)
                <livewire:landing.landing-list-row-component wire:key="landing-list-row-{{ $id }}" :id="$id" :password="$password" />
            @endforeach
        </flux:navlist>
    @endif
</div>
