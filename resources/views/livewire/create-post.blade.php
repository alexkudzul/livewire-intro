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
                {{-- wire:ignore - Ignora los cambios de DOM --}}
                <div wire:ignore>
                    <textarea id="editor" class="form-control w-full" rows="6" wire:model.defer="content"></textarea>
                </div>
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

    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

        <script>
            ClassicEditor
                .create(document.querySelector('#editor'))
                /* Al ignorar el dom en el div del 'editor' con wire:ignore,
                 perdemos el acceso a la propiedad 'content', por lo que no se
                 puede guardar lo que se escriba dentro de ella */
                .then(function(editor) {
                    /* Eschamos el evento 'change' cada vez que haya un cambio
                    en el 'data', que se ejecute una acción. */
                    editor.model.document.on('change:data', () => { // Parte de la configuración de ckeditor
                        /* Usamos el metodo magico $set() de livewire y cada
                        vez que se modifique algo en el editor.getData(),
                        tambien se vea modificado en la propiedad 'content' */
                        @this.set('content', editor.getData()); // Parte de la configuración de livewire
                    });

                    // Cuando abrimos el modal se ejecuta updatingOpen() de CreatePost.php y recibimos el evento resetCKEditor
                    Livewire.on('resetCKEditor', () => {
                        // Limpia el editor.
                        editor.setData('');
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
        {{--
            - Ver más
            - https://laravel-livewire.com/docs/2.x/alpine-js#ignoring-dom-changes
            - https://ckeditor.com/docs/ckeditor5/latest/installation/getting-started/editor-lifecycle.html#listening-to-changes
        --}}
    @endpush
</div>
