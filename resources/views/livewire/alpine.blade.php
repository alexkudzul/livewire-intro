<div>
    {{-- Con Livewire --}}
    <p>Count con Livewire {{ $count }}</p>
    <button wire:click="increase">Aumentar desde livewire</button>

    {{-- Con Alpine --}}
    {{-- @entangle permite "entrelazar" una propiedad de Livewire y Alpine
        juntas. Con entrelazamiento, cuando un valor cambia, el otro también
        cambiará.
    --}}
    {{-- En caso de no querer que se actualice ambas propiedades (count) de
        livewire y alpine, se utiliza .defer en el @entangle esto permite
        actualizar solo en alpine. Hasta que se ejecute una acción en
        livewire ambas propiedades se actualizan.
    --}}
    <div x-data="{ count: @entangle('count').defer }">
        <p>Count con Alpine <span x-text="count"></span></p>
        <button @click="count++">Aumentar desde alpine</button>
    </div>
</div>
