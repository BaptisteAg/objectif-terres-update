<div class="column">
    <div class="field">
        <label for="hasformation" class="label">Formation agricole*</label>
        <div class="control has-icons-left">
            <div class="select is-medium" style="display: block !important;">
                <select id="hasformation"
                        name="hasformation"
                        required
                        v-model="optionHasFormationSelected"
                        class="input @error('hasformation') is-danger @enderror ">
                        <option disabled="disabled" value=""></option>
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
<div  class="column is-half" v-if="optionHasFormationSelected === '1'">
    <div class="field">
        <label class="label">Liste Formation </label>
        <div class="control has-icons-left">
            <div class="select is-medium">
                <select id="formation"
                        name="formation"
                        required
                        class="input @error('formation') is-danger @enderror ">
                        <option disabled="disabled">Sélectionner une formation</option>
                        @foreach(\App\Models\User::$formations as $id => $formation)
                            @if($id !== 4)
                                <option
                                        value="{{$id}}" {{old('formation') == $id ? 'selected' : ''}} >
                                    {{$formation}}
                                </option>
                                @else
                                <option
                                        v-if="optionProfileSelected === '1'"
                                        value="{{$id}}" {{old('formation') == $id ? 'selected' : ''}} >
                                    {{$formation}}
                                </option>
                            @endif
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
