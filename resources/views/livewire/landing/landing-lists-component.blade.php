<div>
    @if ($this->lists->isNotEmpty())
        <flux:navlist.group expandable expanded="false" heading="{{ __('list.lists') }}">
            @foreach ($this->lists as $list)
                <flux:navlist.item wire:navigate wire:key="{{ $list->id }}" href="{{ $list->page() }}">{{ $list->name }}</flux:navlist.item>
            @endforeach
        </flux:navlist>
    @endif
</div>
