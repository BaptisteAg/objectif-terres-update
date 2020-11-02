<div class="field">
    <label class="label">Nom*</label>
    <div class="control has-icons-left">
        <input id="name" name="name" class="input @error('name')is-danger @enderror"
               type="text"
               value="{{ old('name') }}" required autocomplete="name" autofocus
               placeholder="Votre nom...">
        <span class="icon is-small is-left">
            <i class="fas fa-user"></i>
        </span>
    </div>
    @error('name')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>