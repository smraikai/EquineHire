<script>
    document.addEventListener('DOMContentLoaded', function() {
        const replaceLogo = document.getElementById('replace-logo');
        const replaceFeaturedImage = document.getElementById('replace-featured-image');
        const deleteLogo = document.getElementById('delete-logo');
        const deleteFeaturedImage = document.getElementById('delete-featured-image');

        if (replaceLogo) {
            replaceLogo.addEventListener('click', function() {
                const logoUploader = document.getElementById('logo-uploader');
                if (logoUploader) {
                    logoUploader.classList.remove('hidden');
                    this.closest('.mb-2')?.classList.add('hidden');
                }
            });
        }

        if (replaceFeaturedImage) {
            replaceFeaturedImage.addEventListener('click', function() {
                const featuredImageUploader = document.getElementById('featured-image-uploader');
                if (featuredImageUploader) {
                    featuredImageUploader.classList.remove('hidden');
                    this.closest('.mb-2')?.classList.add('hidden');
                }
            });
        }

        if (deleteLogo) {
            deleteLogo.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete the logo?')) {
                    deleteImage('logo');
                }
            });
        }

        if (deleteFeaturedImage) {
            deleteFeaturedImage.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete the featured image?')) {
                    deleteImage('featured_image');
                }
            });
        }

        function deleteImage(type) {
            const pathElement = document.getElementById(type === 'logo' ? 'logo_path' : 'featured_image_path');
            if (!pathElement) return;

            fetch('{{ route('upload.delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        path: pathElement.value,
                        type: type
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const imgSelector =
                            `img[alt="{{ $employer->name }} ${type === 'logo' ? 'logo' : 'featured image'}"]`;
                        const img = document.querySelector(imgSelector);
                        if (img) img.parentElement.remove();

                        pathElement.value = '';

                        const uploaderElement = document.getElementById(`${type}-uploader`);
                        if (uploaderElement) uploaderElement.classList.remove('hidden');
                    }
                });
        }
    });

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
