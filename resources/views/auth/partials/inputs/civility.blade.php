<div class="field">
    <label class="label" for="civility">Civilité*</label>
    <div class="control has-icons-left">
        <div class="select is-fullwidth">
            <select id="civility" name="civility"
                    class="input @error('civility') is-danger @enderror "
                    required>
                <option value=""></option>
                @foreach(\App\Models\User::$civilities as $id => $civ)
                    <option
                            value="{{$id}}" {{old('civility') == $id ? 'selected' : ''}}>
                        {{$civ}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="icon is-small is-left">
            <i class="fas fa-user"></i>
        </div>
    </div>
</div>
