@use('Layouts/layout.prelang')

@in('content')
    {{ @(var) }}
    @php
    if (isset(@(inputErrors)) && isset(@(inputErrors['var']))):
    @endphp
        {{ @(inputErrors['var']) }}
    @php
    endif;
    @endphp
@endin