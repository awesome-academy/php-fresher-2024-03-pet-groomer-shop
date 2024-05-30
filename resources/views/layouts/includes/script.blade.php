<script src="{{ asset('js/app.js') }}" defer></script>
<script>
    window.translations = {!! $translation !!};
    window.userID = {{ Auth::user()->user_id ?? null }};
</script>
