<div>
    <x-danger-button wire:click="$set('open', true)">
        Crear nuevo Post
    </x-danger-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear nuevo Post
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-label value="Título del Post" />
                <x-input class="w-full" type="text" wire:model="title" />
                <x-input-error for="title" />
            </div>

            <div class="mb-4">
                <x-label value="Contenido del Post" />
                <textarea class="form-control w-full" rows="6" wire:model.defer="content"></textarea>
                <x-input-error for="content" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)" class="mr-3">
                Cancelar
            </x-secondary-button>

            <x-danger-button wire:click="save">
                Crear Post
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
