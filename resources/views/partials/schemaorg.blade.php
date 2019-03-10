@if(file_exists($schemaPath = storage_path('app/schema-org.json')))
    <script type="application/ld+json">{!! file_get_contents($schemaPath) !!}</script>
@endif
