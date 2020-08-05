@use('@view/Layouts/Layout.prelang.php')

@in('content')
    <h1>{{ @(var) }}</h1>

    @error('var')
        <h2>{{ @(error) }}</h2>
    @enderror

    @for (@(i) = 5; @(i) >= 0; @(i)--)
        <h3>{{ @(i) }}</h3>
    @endfor

    @include('@view/include.php')

    @if (true)
        <p>if</p>
    @endif

    @if (false)
        <p>if</p>
    @elseif (true)
        <p>elseif</p>
        @endif

    @if (false)
        <p>if</p>
    @elseif (false)
        <p>elseif</p>
    @else
        <p>else</p>
    @endif
@endin