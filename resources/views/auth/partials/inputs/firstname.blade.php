<div class="field">
    <label class="label">Prénom*</label>
    <div class="control has-icons-left">
        <input id="first_name" name="first_name"
               class="input is-medium is-rounded @error('first_name')is-danger @enderror" type="text"
               value="{{ old('first_name') }}" required autocomplete="first_name"
               autofocus
               placeholder="Votre prénom...">
        <span class="icon is-small is-left">
            <i class="fas fa-user"></i>
        </span>
    </div>
    @error('first_name')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>
