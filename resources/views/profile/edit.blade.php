@extends($user->is_employer ? 'layouts.app' : 'layouts.site')

@php
    $metaTitle = 'Account Settings | EquineHire';
    $pageTitle = 'Account Settings';
@endphp

@section('content')
    <div class="py-12 mx-auto">
        <div class="max-w-2xl px-4 mx-auto space-y-6 bg-white rounded-lg sm:px-6 lg:px-8">
            <div class="max-w-2xl py-4">
                @include('profile.partials.update-profile-information-form')
            </div>
            <div class="max-w-2xl py-4">
                @include('profile.partials.update-password-form')
            </div>

            <div class="max-w-2xl py-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
