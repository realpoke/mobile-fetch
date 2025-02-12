<div class="flex flex-col h-full space-y-6">
    <div>
        <div class="flex justify-between">
            <flux:heading size="xl">{{ $list->name }}</flux:heading>
            <flux:dropdown>
                <flux:button squre variant="ghost" inset="bottom" icon-trailing="ellipsis-horizontal" />

                <flux:menu>
                    <flux:modal.trigger name="edit-list">
                        <flux:menu.item icon="pencil">Edit</flux:menu.item>
                    </flux:modal.trigger>
                    <flux:menu.item wire:click="forgetList" icon="bookmark-slash">Forget</flux:menu.item>
                    <flux:menu.item wire:click="fullReset" wire:confirm="{{ __('list.full-reset') }}" icon="document">Full Reset</flux:menu.item>

                    <flux:menu.separator />

                    <flux:menu.item wire:click="deleteList" wire:confirm="{{ __('list.delete-me') }}" variant="danger" icon="trash">Delete</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </div>

        <flux:subheading size="lg">{{ __('list.fetch') }}</flux:subheading>

        <flux:modal name="edit-list" variant="flyout" class="space-y-6">
            <form wire:submit="updateList" class="space-y-6">
                <flux:input class="sm:w-80 w-full" wire:model="form.name"  label="{{ __('list.label') }}" placeholder="{{ __('list.placeholder') }}" />

                <flux:button type="submit" class="sm:w-fit w-full">
                    {{ __('list.submit') }}
                </flux:button>
            </form>
        </flux:modal>

        <flux:modal name="done-modal" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('list.done-heading', ['count' => $done_count]) }}</flux:heading>
                <flux:subheading>{{ __('list.done-subheading') }}</flux:subheading>
            </div>

            <div class="flex justify-end">
                <flux:modal.close>
                    <flux:button icon="x-mark">{{ __('list.done-close') }}</flux:button>
                </flux:modal.close>
            </div>
        </flux:modal>
    </div>

    <form wire:submit="addItem" class="space-y-6">
        <flux:input class="sm:w-80 w-full" wire:model.live="itemForm.name" :clearable="$this->search != ''" label="{{ __('item.label') }}" placeholder="{{ __('item.placeholder') }}" />
    </form>

    @if ($items_count > 0)
        <flux:table>
            <flux:columns>
                <flux:column class="hidden sm:table-cell">{{ __('item.created_by') }}</flux:column>
                <flux:column>{{ __('item.fetched_by') }}</flux:column>
                <flux:column>{{ __('item.name') }}</flux:column>
                <flux:column></flux:column>
            </flux:columns>

            <flux:rows>
                @foreach ($items as $item)
                    <livewire:list.list-row-component wire:key="item-row-id-{{ $item->id }}" :$item :id="$this->list->id" :password="$this->list->password" :fetcher="$profileForm->name" />
                @endforeach
            </flux:rows>
        </flux:table>
    @endif

    @if ($done_count > 0)
        @if ($items_count > 0)
            <flux:separator text="{{ __('list.done', ['count' => $done_count]) }}" />
        @else
            <flux:separator text="{{ __('list.all-done', ['count' => $done_count]) }}" />
        @endif

        <flux:table>
            <flux:columns>
                <flux:column class="hidden sm:table-cell">{{ __('item.created_by') }}</flux:column>
                <flux:column>{{ __('item.fetched_by') }}</flux:column>
                <flux:column>{{ __('item.name') }}</flux:column>
                <flux:column></flux:column>
            </flux:columns>

            <flux:rows>
                @foreach ($done_items as $item)
                    <livewire:list.list-row-component wire:key="done-item-row-id-{{ $item->id }}" :$item :id="$this->list->id" :password="$this->list->password" :fetcher="$profileForm->name" />
                @endforeach
            </flux:rows>
        </flux:table>
    @endif
</div>

@script
<script>
    Echo.channel('list.{{ $this->list->id }}.{{ $this->list->password }}')
        .listen('DeletedListEvent', (event) => {
            const segments = window.location.pathname.split('/').filter(Boolean);
            if (segments[0] === 'list' && segments[1] && segments[2]) {
                const name = segments[1];
                const password = segments[2];
                console.log(name, password);
                if (event.id == '{{ $this->list->id }}' && password == '{{ $this->list->password }}' && name == '{{ $this->list->name }}') {
                    Livewire.navigate('{{ route('landing.page') }}', true);
                }
            }
        })
</script>
@endscript
