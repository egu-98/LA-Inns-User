@if( $errors->count() )
        @foreach( $errors->all() as $error )
            <p class="uk-text-danger">{{ $error }}</p>
        @endforeach
@endif