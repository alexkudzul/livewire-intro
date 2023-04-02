<div>
    <x-danger-button wire:click="$set('open', true)">
        Crear nuevo Post
    </x-danger-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear nuevo Post
        </x-slot>

        <x-slot name="content">
            {{-- wire:loading -> oculta la alerta y solo se va a mostrar cuando se procese una image --}}
            <div wire:loading wire:target="image"
                class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">¡Imagen cargando!</strong>
                <span class="block sm:inline">Espere un momento hasta que la imagen se haya procesado</span>
            </div>

            @if ($image)
                <img class="mb-4" src="{{ $image->temporaryUrl() }}" alt="">
            @endif
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

            <div>
                <input type="file" wire:model="image" id="{{ $identifier }}">
                <x-input-error for="image" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)" class="mr-3">
                Cancelar
            </x-secondary-button>

            {{-- Se desactiva el boton mientras se carga la imagen con la finalidad de evitar un error de validación --}}
            <x-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image"
                class="disabled:opacity-25">
                Crear Post
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
