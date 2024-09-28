@extends('layouts.app')

@php
    $metaTitle = 'Create Employer Profile | EquineHire';
    $pageTitle = 'Create Employer Profile';
@endphp

@section('content')
    <div class="container py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('employers.job-listings.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 bg-white rounded-lg shadow-sm">
                @include('dashboard.job-listings._form', ['submitButtonText' => 'Create Employer Profile'])
            </form>
        </div>
    </div>
@endsection

@include('dashboard.job-listings._scripts')
