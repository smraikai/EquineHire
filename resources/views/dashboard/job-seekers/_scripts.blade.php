@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
    <link href="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.js"></script>
    @include('dashboard.job-seekers._quill_editor', [
        'placeholder' => 'Describe yourself, your career goals, and what makes you a great candidate',
    ])
    @include('dashboard.job-seekers._uppy')
    <script>
        function formatPhoneNumber(input) {
            // Remove all non-digit characters
            let phoneNumber = input.value.replace(/\D/g, '');

            // Format the number
            if (phoneNumber.length > 0) {
                if (phoneNumber.length <= 3) {
                    phoneNumber = phoneNumber;
                } else if (phoneNumber.length <= 6) {
                    phoneNumber = phoneNumber.slice(0, 3) + '-' + phoneNumber.slice(3);
                } else {
                    phoneNumber = phoneNumber.slice(0, 3) + '-' + phoneNumber.slice(3, 6) + '-' + phoneNumber.slice(6, 10);
                }
            }

            // Update the input value
            input.value = phoneNumber;
        }

        function validateEmail(input) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(input.value)) {
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
            } else {
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phone_number');
            phoneInput.addEventListener('input', function() {
                formatPhoneNumber(this);
            });

            const emailInput = document.getElementById('email');
            emailInput.addEventListener('input', function() {
                validateEmail(this);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const replaceProfilePicture = document.getElementById('replace-profile-picture');
            const replaceResume = document.getElementById('replace-resume');
            const deleteProfilePicture = document.getElementById('delete-profile-picture');
            const deleteResume = document.getElementById('delete-resume');

            if (replaceProfilePicture) {
                replaceProfilePicture.addEventListener('click', function() {
                    const profilePictureUploader = document.getElementById('profile-picture-uploader');
                    if (profilePictureUploader) {
                        profilePictureUploader.classList.remove('hidden');
                        this.closest('.flex.flex-col.items-start.mb-2')?.classList.add('hidden');
                    }
                });
            }

            if (replaceResume) {
                replaceResume.addEventListener('click', function() {
                    hideResumeOnFile();
                });
            }

            if (deleteProfilePicture) {
                deleteProfilePicture.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete the profile picture?')) {
                        deleteFile('profile_picture');
                    }
                });
            }

            if (deleteResume) {
                deleteResume.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete the resume?')) {
                        deleteFile('resume');
                    }
                });
            }

            function hideResumeOnFile() {
                const resumeUploader = document.getElementById('resume-uploader');
                const resumeOnFileContainer = document.querySelector('.flex.items-center.justify-between');
                if (resumeUploader && resumeOnFileContainer) {
                    resumeUploader.classList.remove('hidden');
                    resumeOnFileContainer.classList.add('hidden');
                }
            }

            function deleteFile(type) {
                const urlElement = document.getElementById(type === 'profile_picture' ? 'profile_picture_url' :
                    'resume_url');
                if (!urlElement) return;

                fetch('{{ route('upload.delete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            url: urlElement.value,
                            type: type,
                            job_seeker_id: '{{ $jobSeeker->id }}'
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            if (type === 'resume') {
                                hideResumeOnFile();
                            } else {
                                const profilePictureSection = document.querySelector(
                                    '.flex.flex-col.items-start.mb-2.sm\\:flex-row.sm\\:items-center');
                                if (profilePictureSection) {
                                    profilePictureSection.classList.add('hidden');
                                }

                                const uploaderElement = document.getElementById('profile-picture-uploader');
                                if (uploaderElement) {
                                    uploaderElement.classList.remove('hidden');
                                } else {
                                    console.error(
                                        'Uploader element with ID "profile-picture-uploader" not found');
                                }
                            }

                            urlElement.value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the file. Please try again.');
                    });
            }
        });
    </script>
@endsection
