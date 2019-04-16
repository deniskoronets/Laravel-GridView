<select class="form-control" name="filters[{{ $name }}]" v-model="filters['{{ $name }}']" v-on:change="filter(true)">
    <option value=""></option>
    @foreach ($items as $k => $v)
        <option value="{{ $k }}">{{ $v }}</option>
    @endforeach
</select>