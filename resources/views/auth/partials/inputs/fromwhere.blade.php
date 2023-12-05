<div class="column">
    <div class="field">
        <label for="fromwhere" class="label">Êtes-vous *</label>
        <div class="control has-icons-left">
            <div class="select w-100">
                <select id="fromwhere"
                        name="fromwhere"
                        required
                        class="input @error('fromwhere') is-danger @enderror ">
                    <option disabled="disabled" value="">Vous êtes...</option>
                    @foreach(\App\Models\User::$fromwheres as $id => $fromwhere)
                        <option
                                value="{{$id}}" {{old('fromwhere') == $id ? 'selected' : ''}} >
                            {{ucfirst($fromwhere)}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </div>
        </div>
        @error('fromwhere')
        <article class="message is-danger" role="alert">
            <div class="message-body">
                {{ $message }}
            </div>
        </article>
        @enderror
    </div>
</div>
