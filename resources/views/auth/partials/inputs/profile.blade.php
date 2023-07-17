<div class="column">
    <div class="field">
        <label for="profile" class="label">Situation*</label>
        <div class="control has-icons-left">
            <div class="select" style="display: block !important;">
                <select id="profile"
                        name="profile"
                        required
                        v-model="optionProfileSelected"
                        class="input @error('profile') is-danger @enderror ">
                    <option disabled="disabled">Vous êtes...</option>
                    @foreach(\App\Models\User::$profiles as $id => $prof)
                        <option
                                value="{{$id}}" {{old('profile') == $id ? 'selected' : ''}} >
                            {{ucfirst($prof)}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </div>
        </div>
        @error('profile')
        <article class="message is-danger" role="alert">
            <div class="message-body">
                {{ $message }}
            </div>
        </article>
        @enderror
    </div>
</div>
<!--div v-if="optionProfileSelected === '7'" class="column is-half">
    <div class="field">
        <label class="label">Situation autre </label>
        <p class="control has-icons-left has-icons-right">
            <input id="other_profile"
                   class="input @error('other_profile') is-danger @enderror"
                   type="text"
                   name="other_profile" value="{{ old('other_profile') }}" required
                   autocomplete="other_profile"
                   placeholder="Veuillez préciser ...">
            <span class="icon is-small is-left">
                <i class="fas fa-pen"></i>
            </span>
        </p>
        @error('other_profile')
        <article class="message is-danger" role="alert">
            <div class="message-body">
                {{ $message }}
            </div>
        </article>
        @enderror
    </div>
</div-->
