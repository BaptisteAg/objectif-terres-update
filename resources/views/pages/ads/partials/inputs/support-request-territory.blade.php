<div class="columns is-desktop">
    <div class="column"></div>
    <div class="column is-half-desktop is-8-mobile ">
        <div class="">
            <label class="label ">Territoire d'accompagnement</label>
            <select :disabled="isInputDisabled" id="support_request_territory_id" class="select is-large"
                    name="support_request_territory_id" v-model="formInput.supportRequestTerritoryId" required>
                @foreach($territories as $territory)
                    <option value="{{ $territory->id }}" {{ $old["support_request_territory_id"] == $territory->id ? "selected":"" }}>{{$territory->name}}</option>
                @endforeach
            </select>
        </div>
        <p v-html="textTerritoryContent"></p>
    </div>
    <div class="column"></div>
</div>