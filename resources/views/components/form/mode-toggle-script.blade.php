@once
@push('page-script')
<script>
  // Alpine store: no usa $wire.set => no AJAX. Solo sincroniza el hidden con .defer
  if (!window.modeToggle) {
    window.modeToggle = (opts)=>({
      model: opts.model,
      value: null,
      init(){
        // Lee el valor actual del componente Livewire desde el front-store (no hace request)
        try {
          const id = this.$root.closest('[wire\\:id]')?.getAttribute('wire:id');
          if (id && this.model && window.Livewire) {
            this.value = window.Livewire.find(id).get(this.model);
          }
        } catch(e) {}
        if (!this.value) this.value = opts.isSite ? 'override' : 'inherit';
        this.syncHidden();
      },
      select(v){
        if (this.value === v) return;
        this.value = v;
        this.syncHidden();
        this.$dispatch('mode-changed', { model: this.model, value: v });
      },
      syncHidden(){
        const h = this.$refs.hiddenMode;
        if (!h) return;
        h.value = this.value;
        // Marca “dirty” en Livewire pero SIN request (por .defer)
        h.dispatchEvent(new Event('input', { bubbles: true }));
        h.dispatchEvent(new Event('change', { bubbles: true }));
      }
    });
  }
</script>
@endpush
@endonce
