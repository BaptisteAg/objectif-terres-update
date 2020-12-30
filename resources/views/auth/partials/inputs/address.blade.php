<div class="field">
    <label class="label">Adresse </label>
    <p class="control has-icons-left">
        <input id="street" class="input @error('street') is-danger @enderror"
               type="text"
               name="street"
               value="{{ old('street') }}"
               autocomplete="street-address"
               autofocus
               placeholder="Votre adresse ...">
        <span class="icon is-small is-left">
            <i class="fas fa-map-marker-alt"></i>
        </span>
    </p>
    @error('street')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>