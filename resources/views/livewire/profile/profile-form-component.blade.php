<div>
    <form wire:submit="updateProfile" class="space-y-6">
        <flux:heading>{{ __('profile.title') }}</flux:heading>

        <div class="flex-1 sm:flex-grow-0"></div>

        <flux:input wire:model="form.name" label="{{ __('name.label') }}" placeholder="{{ __('profile.placeholder') }}" />

        <flux:button type="submit" class="w-full">
            {{ __('name.submit') }}
        </flux:button>

        <flux:button wire:click="deleteProfile" wire:confirm="Delete you and all lists saved?" variant="subtle" type="button" class="w-full">
            {{ __('name.delete') }}
        </flux:button>
    </form>
</div>
