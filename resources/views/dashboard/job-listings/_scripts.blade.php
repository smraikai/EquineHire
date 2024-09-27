@section('scripts_css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
@endsection

@section('scripts')
    @include('partials.scripts._quill_editor', [
        'placeholder' => 'Describe the job role, responsibilities, qualifications, and any other relevant details',
    ])
    <!-- Scripts for Job Listing Forms -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Existing code for application type and remote position...

            const salaryTypeSelect = document.getElementById('salary_type');
            const hourlyRateFields = document.getElementById('hourly_rate_fields');
            const annualSalaryFields = document.getElementById('annual_salary_fields');
            const hourlyRateMinInput = document.getElementById('hourly_rate_min');
            const hourlyRateMaxInput = document.getElementById('hourly_rate_max');
            const salaryRangeMinInput = document.getElementById('salary_range_min');
            const salaryRangeMaxInput = document.getElementById('salary_range_max');

            function toggleSalaryFields() {
                const selectedSalaryType = salaryTypeSelect.value;

                if (selectedSalaryType === 'hourly') {
                    hourlyRateFields.style.display = 'grid';
                    annualSalaryFields.style.display = 'none';
                    hourlyRateMinInput.required = true;
                    hourlyRateMaxInput.required = true;
                    salaryRangeMinInput.required = false;
                    salaryRangeMaxInput.required = false;
                } else if (selectedSalaryType === 'annual') {
                    hourlyRateFields.style.display = 'none';
                    annualSalaryFields.style.display = 'grid';
                    hourlyRateMinInput.required = false;
                    hourlyRateMaxInput.required = false;
                    salaryRangeMinInput.required = true;
                    salaryRangeMaxInput.required = true;
                } else {
                    hourlyRateFields.style.display = 'none';
                    annualSalaryFields.style.display = 'none';
                    hourlyRateMinInput.required = false;
                    hourlyRateMaxInput.required = false;
                    salaryRangeMinInput.required = false;
                    salaryRangeMaxInput.required = false;
                }
            }

            salaryTypeSelect.addEventListener('change', toggleSalaryFields);

            // Initial toggle on page load
            toggleSalaryFields();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const applicationTypeInputs = document.querySelectorAll('input[name="application_type"]');
            const applicationLinkContainer = document.getElementById('application_link_container');
            const emailLinkContainer = document.getElementById('email_link_container');
            const applicationLinkInput = document.getElementById('application_link');
            const emailLinkInput = document.getElementById('email_link');

            function toggleApplicationFields() {
                const selectedType = document.querySelector('input[name="application_type"]:checked').value;

                if (selectedType === 'link') {
                    applicationLinkContainer.style.display = 'block';
                    emailLinkContainer.style.display = 'none';
                    applicationLinkInput.required = true;
                    emailLinkInput.required = false;
                } else if (selectedType === 'email') {
                    applicationLinkContainer.style.display = 'none';
                    emailLinkContainer.style.display = 'block';
                    applicationLinkInput.required = false;
                    emailLinkInput.required = true;
                }
            }

            applicationTypeInputs.forEach(input => {
                input.addEventListener('change', toggleApplicationFields);
            });

            // Initial toggle on page load
            toggleApplicationFields();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Existing code for application type...

            const remotePositionInputs = document.querySelectorAll('input[name="remote_position"]');
            const locationFields = document.getElementById('location_fields');
            const cityInput = document.getElementById('city');
            const stateInput = document.getElementById('state');

            function toggleLocationFields() {
                const isRemote = document.querySelector('input[name="remote_position"]:checked').value === '1';

                if (isRemote) {
                    locationFields.style.display = 'none';
                    cityInput.required = false;
                    stateInput.required = false;
                } else {
                    locationFields.style.display = 'grid';
                    cityInput.required = true;
                    stateInput.required = true;
                }
            }

            remotePositionInputs.forEach(input => {
                input.addEventListener('change', toggleLocationFields);
            });

            // Initial toggle on page load
            toggleLocationFields();
        });
    </script>
    <!-- End Scripts for Job Listing -->
@endsection
