@extends('layouts.app')

@php
    $metaTitle = 'Create Your Profile | EquineHire';
    $pageTitle = 'Create Your Profile';
@endphp

@section('content')
    <div class="container relative py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard.job-seekers.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 m-4 bg-white rounded-lg shadow-sm sm:m-0">
                @csrf
                @include('dashboard.job-seekers._form')
            </form>
        </div>
    </div>
@endsection

@include('dashboard.job-seekers._scripts')
