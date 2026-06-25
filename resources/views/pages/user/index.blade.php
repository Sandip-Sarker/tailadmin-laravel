@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Users List" />
    <div class="space-y-6">
        <x-tables.basic-tables.user-tables-lists
            :users="$users"
            :search="$search"
            :perPage="$perPage"
        />
    </div>
@endsection