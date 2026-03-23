<footer class="main-footer text-xs py-1 px-2 text-muted">
    © {{ date('Y') }} {{ auth()->user()->tenant->nombre ?? 'Sistema Resto' }}
</footer>