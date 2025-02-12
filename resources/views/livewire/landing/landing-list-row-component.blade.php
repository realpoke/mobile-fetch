<div x-data x-show="! $wire.hide">
    <flux:navlist.item wire:navigate href="{{ $this->page }}" x-text="$wire.name"></flux:navlist.item>
</div>

@script
<script>
    Echo.channel('list.{{ $this->id }}.{{ $this->password }}')
        .listen('UpdatedListEvent', (event) => {
            $wire.name = event.name;
    })
</script>
@endscript
