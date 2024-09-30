@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
    <link href="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.js"></script>
    @include('dashboard.employers._uppy')
    @include('partials.scripts._quill_editor', [
        'placeholder' => 'Describe your company, its mission, and what makes it a great place to work',
    ])
    <script>
        // Auto prepend https:// to website input
        const websiteInput = document.getElementById('website');
        websiteInput.addEventListener('blur', function() {
            if (websiteInput.value && !websiteInput.value.startsWith('http://') && !websiteInput.value
                .startsWith('https://')) {
                websiteInput.value = 'https://' + websiteInput.value;
            }
        });
    </script>
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
                            type: type,
                            employer_id: '{{ $employer->id }}'
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
                            const imgSelector =
                                `img[alt="{{ $employer->name }} ${type === 'logo' ? 'logo' : 'featured image'}"]`;
                            const img = document.querySelector(imgSelector);
                            if (img) {
                                const parentContainer = img.closest('.mb-2');
                                if (parentContainer) parentContainer.remove();
                            }

                            pathElement.value = '';

                            const uploaderId = type === 'logo' ? 'logo-uploader' : 'featured-image-uploader';
                            const uploaderElement = document.getElementById(uploaderId);
                            if (uploaderElement) {
                                uploaderElement.classList.remove('hidden');
                            } else {
                                console.error(`Uploader element with ID "${uploaderId}" not found`);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the image. Please try again.');
                    });
            }
        });
    </script>
@endsection
