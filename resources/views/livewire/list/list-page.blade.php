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

                    <flux:menu.separator />

                    <flux:menu.item wire:click="deleteList" wire:confirm="{{ __('list.delete-me') }}" variant="danger" icon="trash">Delete</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </div>

        <flux:subheading size="lg">{{ __('list.fetch') }}</flux:subheading>
    </div>

    <flux:modal name="edit-list" variant="flyout" class="space-y-6">
        <form wire:submit="updateList" class="space-y-6">
            <flux:input class="sm:w-80 w-full" wire:model="form.name" label="{{ __('list.label') }}" placeholder="{{ __('list.placeholder') }}" />

            <flux:button type="submit" class="sm:w-fit w-full">
                {{ __('list.submit') }}
            </flux:button>
        </form>
    </flux:modal>

    <flux:separator variant="subtle" />

    <div class="flex-1 sm:flex-grow-0"></div>
</div>
