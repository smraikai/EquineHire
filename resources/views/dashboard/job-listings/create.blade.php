@extends('layouts.app')

@php
    $metaTitle = 'Create Job Listing | EquineHire';
    $pageTitle = 'Create Job Listing';
@endphp

@section('content')
    <div class="container px-4 py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('employers.job-listings.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 m-4 bg-white rounded-lg shadow-sm sm:m-0">
                @include('dashboard.job-listings._form', ['submitButtonText' => 'Create Job Listing'])
            </form>
        </div>
    </div>
@endsection

@include('dashboard.job-listings._scripts')
