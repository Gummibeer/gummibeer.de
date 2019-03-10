@if(file_exists(storage_path('app/schema-org.html')))
    {!! file_get_contents(storage_path('app/schema-org.html')) !!}
@endif
