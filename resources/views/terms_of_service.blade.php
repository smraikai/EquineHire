@extends('layouts.site')

@php
    $metaTitle = 'Terms of Service | EquineHire';
    $metaDescription =
        'Read the Terms of Service for EquineHire, outlining the rules and regulations for using our platform.';
@endphp

@section('content')
    <div class="py-24 bg-white sm:py-32">
        <div class="max-w-3xl px-6 mx-auto lg:px-8">
            <div class="max-w-2xl mx-auto lg:mx-0">
                <h1 class="text-5xl font-bold tracking-tight text-gray-900 sm:text-6xl fancy-title">Terms of Service</h1>
                <p class="mt-6 text-lg text-gray-600">
                    Welcome to EquineHire. By using our platform, you agree to comply with and be bound by the
                    following terms and conditions.
                </p>
            </div>
            <div class="max-w-2xl mx-auto mt-4 lg:mx-0 lg:max-w-none">

                <div class="mt-16">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">User Accounts</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Users are responsible for maintaining the confidentiality of their account information and password.
                        You agree to accept responsibility for all activities that occur under your account.
                    </p>
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">User Eligibility</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        EquineHire is intended for use by individuals who are 18 years of age or older and located
                        within the United States of America. By using our platform, you confirm that you meet these
                        eligibility requirements. Users outside the USA or under the age of 18 are not permitted to use our
                        services.
                    </p>
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Content</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Users are solely responsible for the content they post on EquineHire. We reserve the right to
                        remove any content that violates our policies or is deemed inappropriate.
                    </p>
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Service Usage</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        EquineHire is a platform for connecting horse owners with equine professionals. We do not
                        endorse or guarantee the quality of services provided by professionals listed on our platform.
                    </p>
                    <p class="mt-4 text-lg text-gray-600">
                        Users agree to use the service for lawful purposes only and in a way that does not infringe upon the
                        rights of others or inhibit their use and enjoyment of the service.
                    </p>
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Liability</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        EquineHire is not liable for any damages or losses resulting from the use of our platform or
                        the services provided by professionals listed on our site.
                    </p>
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Payments and Refunds</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Payments for EquineHire services are processed securely through our payment provider.
                        Subscription fees are charged on a recurring basis according to the plan selected by the user.
                    </p>
                    <p class="mt-4 text-lg text-gray-600">
                        Refunds may be issued at the discretion of EquineHire management. Generally, refunds are only
                        provided in cases of technical issues preventing service delivery or other exceptional
                        circumstances. Users should contact our support team within 7 days of the charge date to request a
                        refund.
                    </p>
                    <p class="mt-4 text-lg text-gray-600">
                        EquineHire reserves the right to modify pricing and refund policies at any time, with notice
                        provided to users prior to any changes taking effect.
                    </p>
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Changes to Terms</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        We reserve the right to modify these terms at any time. Users will be notified of any changes, and
                        continued use of the platform constitutes acceptance of the modified terms.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
