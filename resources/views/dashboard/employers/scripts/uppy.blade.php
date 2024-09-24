<script>
    document.addEventListener('DOMContentLoaded', function() {
        const Uppy = window.Uppy.Uppy;
        const Dashboard = window.Uppy.Dashboard;
        const XHRUpload = window.Uppy.XHRUpload;

        // Get the CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function initializeUppy() {
            // Initialize Uppy for logo
            const logoUppy = new Uppy({
                    id: 'logo',
                    autoProceed: true,
                    restrictions: {
                        maxFileSize: 3 * 1024 * 1024,
                        maxNumberOfFiles: 1,
                        allowedFileTypes: ['image/*']
                    }
                })
                .use(Dashboard, {
                    inline: true,
                    target: '#logo-uploader',
                    width: '100%',
                    height: 250,
                    disableStatusBar: true,
                })
                .use(XHRUpload, {
                    endpoint: '{{ route('upload.logo') }}',
                    formData: true,
                    fieldName: 'logo',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })

            // Initialize Uppy for featured image
            const featuredImageUppy = new Uppy({
                    id: 'featuredImage',
                    autoProceed: true,
                    restrictions: {
                        maxFileSize: 5 * 1024 * 1024,
                        maxNumberOfFiles: 1,
                        allowedFileTypes: ['image/*']
                    }
                })
                .use(Dashboard, {
                    inline: true,
                    target: '#featured-image-uploader',
                    width: '100%',
                    height: 250,
                    disableStatusBar: true,
                })
                .use(XHRUpload, {
                    endpoint: '{{ route('upload.featured_image') }}',
                    formData: true,
                    fieldName: 'featured_image',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })

            logoUppy.on('upload-success', (file, response) => {
                document.getElementById('logo_path').value = response.body.path;
            });

            featuredImageUppy.on('upload-success', (file, response) => {
                document.getElementById('featured_image_path').value = response.body.path;
            });
        }

        // Check if the elements exist before initializing Uppy
        if (document.getElementById('logo-uploader') && document.getElementById('featured-image-uploader')) {
            initializeUppy();
        } else {
            console.error('Uppy target elements not found');
        }
    });
</script>
