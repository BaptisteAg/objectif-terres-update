<div class="column">
    <div class="field">
        <label for="hasformation" class="label">Formation agricole *</label>
        <div class="control has-icons-left">
            <div class="select " style="display: block !important;">
                <select id="hasformation"
                        name="hasformation"
                        required
                        v-model="optionHasFormationSelected"
                        class="input @error('hasformation') is-danger @enderror ">
                        <option value="" selected></option>
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                </select>
            </div>
            <div class="icon is-small is-left">
                <i class="fas fa-pen"></i>
            </div>
        </div>
        @error('hasformation')
        <article class="message is-danger" role="alert">
            <div class="message-body">
                {{ $message }}
            </div>
        </article>
        @enderror
    </div>
</div>
<div class="column" v-if="optionHasFormationSelected === '1'">
    <div class="field">
        <label class="label">Liste Formation *</label>
        <div class="control has-icons-left">
            <div class="select ">
                <select id="formation"
                        name="formation"
                        required
                        v-model="formationSelected"
                        class="input @error('formation') is-danger @enderror ">
                        <option disabled="disabled">Sélectionner une formation</option>
                        @foreach(\App\Models\User::$formations as $id => $formation)
                            <option
                                    value="{{$id}}" {{old('formation') == $id ? 'selected' : ''}} >
                                {{$formation}}
                            </option>
                        @endforeach
                </select>
            </div>
        </div>
        @error('formation')
        <article class="message is-danger" role="alert">
            <div class="message-body">
                {{ $message }}
            </div>
        </article>
        @enderror
    </div>
</div>
