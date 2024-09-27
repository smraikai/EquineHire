@extends('layouts.app')

@php
    $metaTitle = 'Edit Employer Profile | EquineHire';
    $pageTitle = 'Edit Employer Profile';
@endphp

@section('content')
    @include('dashboard._profile-strength')
    <div class="container py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('employers.update', $employer) }}" method="POST" enctype="multipart/form-data"
                class="p-6 bg-white rounded-lg shadow-sm">
                @csrf
                @method('PUT')
                @include('dashboard.employers._form')
            </form>
        </div>
    </div>
@endsection

@include('dashboard.employers._scripts')
