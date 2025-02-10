<div class="flex flex-col h-full space-y-6">
    <div>
        <flux:heading size="xl">{{ __('list.heading') }}</flux:heading>
        <flux:subheading size="lg">{{ __('list.subheading') }}</flux:subheading>
    </div>

    <flux:separator variant="subtle" />

    <div class="flex-1 sm:flex-grow-0"></div>

    <form wire:submit="createList" class="space-y-6">
        <flux:input class="sm:w-80 w-full" wire:model="form.name" label="{{ __('list.label') }}" placeholder="{{ __('list.placeholder') }}" />

        <flux:button type="submit" class="sm:w-fit w-full">
            {{ __('list.submit') }}
        </flux:button>
    </form>
</div>
