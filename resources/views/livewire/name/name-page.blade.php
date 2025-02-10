<div class="sm:w-96 w-full">
    <form wire:submit="setupName" class="space-y-6 w-full">
        <flux:heading size="xl" class="text-center">{{ __('name.title') }}</flux:heading>
        <flux:input wire:model="form.name" label="{{ __('name.label') }}" placeholder="{{ __('name.placeholder') }}" />

        <flux:button type="submit" class="w-full">
            {{ __('name.submit') }}
        </flux:button>
    </form>
</div>
