@foreach ($model as $row)
    @foreach ($row->getAttributes() as $key => $value)
        <p>{{ $key }}, {{ $value }}</p>
    @endforeach
@endforeach

@define ('number') 10 @enddefine