<div class="field">
    <label class="label">Numéro de téléphone </label>
    <p class="control has-icons-left has-icons-right">
        <input id="phone" class="input @error('phone') is-danger @enderror" type="text"
               name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus
               placeholder="Votre numéro de téléphone ...">
        <span class="icon is-small is-left">
            <i class="fas fa-phone"></i>
        </span>
    </p>
    @error('phone')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>