<div class="field">
    <label class="label">Mot de passe*</label>
    <p class="control has-icons-left">
        <input id="password"
               name="password"
               class="input @error('password') is-danger @enderror "
               type="password"
               required
               autocomplete="new-password"
               placeholder="Votre mot de passe..."
               value="{{ old('password') }}"
               minlength="5">
        <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
        </span>
    </p>
    @error('password')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>
<div class="field">
    <label class="label">Confirmation mot de passe*</label>
    <p class="control has-icons-left">
        <input id="password-confirm"
               name="password_confirmation"
               class="input"
               type="password"
               value="{{ old('password_confirmation') }}"
               autocomplete="new-password"
               required
               placeholder="Ressaisissez mot de passe...">
        <span class="icon is-small is-left">
            <i class="fas fa-lock"></i>
        </span>
    </p>
</div>