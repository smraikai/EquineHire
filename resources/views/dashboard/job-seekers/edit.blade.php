@extends('layouts.app')

@php
    $metaTitle = 'Edit Your Profile | EquineHire';
    $pageTitle = 'Edit Your Profile';
@endphp

@section('content')
    <div class="container relative py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('job-seekers.update', $jobSeeker) }}" method="POST" enctype="multipart/form-data"
                class="p-6 m-4 bg-white rounded-lg shadow-sm sm:m-0">
                @csrf
                @method('PUT')
                @include('dashboard.job-seekers._form')
            </form>
        </div>
    </div>
@endsection

@include('dashboard.job-seekers._scripts')
