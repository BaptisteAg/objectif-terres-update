<div class="field">
    <label class="label">Adresse email*</label>
    <p class="control has-icons-left has-icons-right">
        <input id="email"
               class="input @error('email') is-danger @enderror"
               type="email"
               name="email"
               value="{{ old('email') }}"
               required
               autocomplete="email"
               autofocus
               placeholder="Votre adresse email...">
        <span class="icon is-small is-left">
            <i class="fas fa-envelope"></i>
        </span>
    </p>
    @error('email')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>