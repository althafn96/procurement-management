<x-app-layout :title="$title">
    <x-slot name="styles">
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>
    @if(auth()->user()->role->type == 'master')
        @include('user-roles.partials._master_index')
    @else
        @include('user-roles.partials._tenant_index')
    @endif
    <x-slot name="scripts">
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/master/js/user-roles.js') }}"></script>
    </x-slot>
</x-app-layout>
