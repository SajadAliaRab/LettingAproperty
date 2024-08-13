<x-filament-panels::page>
<form wire:submit="submit" class="space-y-6">
        {{ $this->form }}
         <!-- submit button below the form -->
        <div class="flex justify-start">
            <x-filament::button type="submit">
                Submit Request
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
