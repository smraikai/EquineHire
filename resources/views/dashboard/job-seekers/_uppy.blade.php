<script>
    document.addEventListener('DOMContentLoaded', function() {
        const Uppy = window.Uppy.Uppy;
        const Dashboard = window.Uppy.Dashboard;
        const XHRUpload = window.Uppy.XHRUpload;

        // Get the CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function initializeUppy() {
            // Initialize Uppy for profile picture
            const profilePictureUppy = new Uppy({
                    id: 'profilePicture',
                    autoProceed: true,
                    restrictions: {
                        maxFileSize: 2 * 1024 * 1024,
                        maxNumberOfFiles: 1,
                        allowedFileTypes: ['image/*']
                    }
                })
                .use(Dashboard, {
                    inline: true,
                    target: '#profile-picture-uploader',
                    width: '100%',
                    height: 300,
                    disableStatusBar: true,
                })
                .use(XHRUpload, {
                    endpoint: '{{ route('upload.profile_picture') }}',
                    formData: true,
                    fieldName: 'profile_picture',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })

            // Initialize Uppy for resume
            const resumeUppy = new Uppy({
                    id: 'resume',
                    autoProceed: true,
                    restrictions: {
                        maxFileSize: 5 * 1024 * 1024,
                        maxNumberOfFiles: 1,
                        allowedFileTypes: ['.pdf', '.doc', '.docx']
                    }
                })
                .use(Dashboard, {
                    inline: true,
                    target: '#resume-uploader',
                    width: '100%',
                    height: 300,
                    disableStatusBar: true,
                })
                .use(XHRUpload, {
                    endpoint: '{{ route('upload.resume') }}',
                    formData: true,
                    fieldName: 'resume',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })

            profilePictureUppy.on('upload-success', (file, response) => {
                document.getElementById('profile_picture_url').value = response.body.path;
            });

            resumeUppy.on('upload-success', (file, response) => {
                document.getElementById('resume_url').value = response.body.path;
                const resumeContainer = document.querySelector('#resume-uploader').closest('div');
                const resumeInfo = document.createElement('div');
                resumeInfo.className = 'flex items-center mb-2';
                resumeInfo.innerHTML = `
        <svg class="w-8 h-8 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
        </svg>
        <span class="text-sm text-gray-600">Resume Uploaded</span>
    `;
                resumeContainer.prepend(resumeInfo);
            });
        }

        // Check if the elements exist before initializing Uppy
        if (document.getElementById('profile-picture-uploader') && document.getElementById('resume-uploader')) {
            initializeUppy();
        } else {
            console.error('Uppy target elements not found');
        }
    });
</script>
