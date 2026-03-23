<x-app-layout>

<div class="p-6">

    <livewire:roles.roles-index />

    <div class="mt-6">
        <livewire:roles.roles-form />
    </div>

</div>

</x-app-layout>
@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection
