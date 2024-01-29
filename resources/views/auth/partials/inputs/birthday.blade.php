<div class="field">
    <label class="label">Date de naissance*</label>
    <p class="control has-icons-left has-icons-right">
        <input id="birthday"
               class="input is-rounded @error('birthday') is-danger @enderror"
               type="date"
               name="birthday"
               value="{{ old('birthday') }}"
               required
               autocomplete="birthday"
               autofocus
               placeholder="">
        <span class="icon is-small is-left">
        <i class="fas fa-calendar"></i>
    </span>
    </p>
    @error('birthday')
    <article class="message is-danger" role="alert">
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
    @enderror
</div>

