<flux:row>
    <flux:cell class="hidden sm:table-cell"><flux:profile :name="$item->added_by" :chevron="false" /></flux:cell>
    @if ($item->fetched_by)
        <flux:cell><flux:profile :name="$item->fetched_by" :chevron="false" /></flux:cell>
    @else
        <flux:cell>--</flux:cell>
    @endif
    <flux:cell><div class="flex justify-between items-baseline">
        {{ $item->name }}
        <flux:badge :color="$item->status->color()" size="sm" class="items-center gap-1">
            {{ $item->status->label() }}
            @if ($item->status->value == "fetching")
                <div class="relative size-2 rounded-full bg-current">
                    <div class="absolute size-2 rounded-full bg-current animate-ping"></div>
                </div>
            @endif
        </flux:badge>
    </div></flux:cell>
    <flux:cell class="text-right"><div class="flex gap-4 justify-end items-baseline">
        @if ($item->status->value == "free")
            <flux:button wire:click="nextStatus" variant="primary" size="sm" icon="arrow-down-tray"></flux:button>
        @elseif ($item->status->value == 'fetching')
            <flux:button wire:click="nextStatus" variant="primary" size="sm" icon="clipboard-document-check"></flux:button>
        @else
            <flux:dropdown>
                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal"></flux:button>

                <flux:menu>
                    <flux:menu.item wire:click="resetStatus" icon="arrow-uturn-left">{{ __('item.reset') }}</flux:menu.item>
                    @if ($item->status->value != 'not_found')
                        <flux:menu.item wire:click="nextStatus" icon="no-symbol">{{ __('item.not-found') }}</flux:menu.item>
                    @endif

                    <flux:menu.separator />

                    <flux:menu.item wire:confirm="{{ __('item.delete-confirm') }}" wire:click="deleteItem" variant="danger" icon="trash">{{ __('item.delete') }}</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        @endif
    </div></flux:cell>
</flux:row>
