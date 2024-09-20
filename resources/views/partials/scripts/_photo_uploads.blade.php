@php
    $existingFiles = $business->photos
        ->map(function ($photo) {
            return [
                'source' => $photo->path,
                'options' => ['type' => 'local'],
            ];
        })
        ->toArray();
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Check for Active Upoads
        let activeUploads = 0;

        function updateButtonState() {
            const form = document.getElementById('listing_form');
            form.dataset.activeUploads = activeUploads;
            const buttons = document.querySelectorAll('#publishUpdateBtn1, #publishUpdateBtn2');
            buttons.forEach(button => {
                button.disabled = activeUploads > 0;
                button.style.opacity = activeUploads > 0 ? '0.5' : '1';
                button.style.cursor = activeUploads > 0 ? 'not-allowed' : 'pointer';
            });
        }

        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Logo FilePond instance
        FilePond.create(document.querySelector('input[id="logo_upload"]'), {
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'],
            files: @json($business->logo ? [['source' => $business->logo, 'options' => ['type' => 'local']]] : []),
            server: {
                url: '/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                process: {
                    ondata: (formData) => {
                        activeUploads++;
                        updateButtonState();
                        return formData;
                    },
                    onload: (response) => {
                        const data = JSON.parse(response);
                        document.getElementById('logo_url').value = data.path;
                        activeUploads--;
                        updateButtonState();
                    }
                },
                remove: (source, load, error) => {
                    fetch('/delete-logo', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                business_id: {{ $business->id }},
                                file_path: source
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                load();
                            } else {
                                error('Failed to delete file');
                            }
                        })
                        .catch(() => error('Failed to delete file'));
                }
            }
        });

        // Featured Image FilePond instance
        FilePond.create(document.querySelector('input[id="featured_image"]'), {
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'],
            files: @json($business->featured_image ? [['source' => $business->featured_image, 'options' => ['type' => 'local']]] : []),
            server: {
                url: '/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                process: {
                    ondata: (formData) => {
                        activeUploads++;
                        updateButtonState();
                        return formData;
                    },
                    onload: (response) => {
                        const data = JSON.parse(response);
                        document.getElementById('featured_image_url').value = data.path;
                        activeUploads--;
                        updateButtonState();
                    }
                },
                remove: (source, load, error) => {
                    fetch('/delete-featured-image', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                business_id: {{ $business->id }},
                                file_path: source
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                load();
                            } else {
                                error('Failed to delete file');
                            }
                        })
                        .catch(() => error('Failed to delete file'));
                }
            }
        });

        // Additional Photos FilePond instance
        FilePond.create(document.querySelector('input[id="additional_photos"]'), {
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'],
            allowMultiple: true,
            maxFiles: 10,
            files: @json($existingFiles),
            server: {
                url: '/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                process: {
                    ondata: (formData) => {
                        activeUploads++;
                        updateButtonState();
                        return formData;
                    },
                    onload: (response) => {
                        const data = JSON.parse(response);
                        const urlsElement = document.getElementById('additional_photos_urls');
                        if (urlsElement) {
                            let existingUrls = JSON.parse(urlsElement.value || '[]');
                            existingUrls = existingUrls.concat(data.paths);
                            urlsElement.value = JSON.stringify(existingUrls);
                        }
                        activeUploads--;
                        updateButtonState();
                    }
                },
                remove: (source, load, error) => {
                    fetch('/delete-additional-photo', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                business_id: {{ $business->id }},
                                file_path: source
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                load();
                            } else {
                                error('Failed to delete file');
                            }
                        })
                        .catch(() => error('Failed to delete file'));
                }

            }
        });
    });
</script>
