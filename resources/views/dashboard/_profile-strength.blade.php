<div id="profile-strength-card" class="fixed z-50 p-4 bg-white border rounded-lg shadow-md top-4 right-4">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Profile Strength</h3>
            <span id="strength-label" class="text-sm font-medium text-gray-600">Very Weak</span>
        </div>
        <div class="relative w-16 h-16 ml-4">
            <svg class="w-full h-full" viewBox="0 0 36 36">
                <path d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#E5E7EB" stroke-width="3" />
                <path id="strength-progress" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#3B82F6" stroke-width="3"
                    stroke-dasharray="0, 100" />
            </svg>
            <div class="absolute inset-0 flex items-center justify-center">
                <span id="strength-percentage" class="text-sm font-semibold text-gray-700">0%</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quillInitInterval = setInterval(() => {
            if (window.quill) {
                clearInterval(quillInitInterval);
                initializeProfileStrength();
            }
        }, 100);

        function initializeProfileStrength() {
            const fields = [
                'name', 'city', 'state', 'website', 'logo_path', 'featured_image_path'
            ];

            fields.forEach(field => {
                const element = document.getElementById(field);
                if (element) {
                    element.addEventListener('input', updateProfileStrength);
                }
            });

            // For Quill editor (description)
            quill.on('text-change', function() {
                document.getElementById('description').value = quill.root.innerHTML;
                updateProfileStrength();
            });

            // For file uploads (logo and featured image)
            const observer = new MutationObserver(updateProfileStrength);
            observer.observe(document.getElementById('logo_path'), {
                attributes: true
            });
            observer.observe(document.getElementById('featured_image_path'), {
                attributes: true
            });

            // Initial calculation
            updateProfileStrength();
        }

        function updateProfileStrength() {
            const fields = [
                'name', 'city', 'state', 'website', 'logo_path', 'featured_image_path'
            ];

            let filledFields = 0;
            fields.forEach(field => {
                const element = document.getElementById(field);
                if (element && element.value.trim() !== '') {
                    filledFields++;
                }
            });

            // Handle description separately
            const description = document.getElementById('description').value.trim();
            const descriptionLength = description.length;
            let descriptionScore = 0;
            if (descriptionLength > 0) {
                descriptionScore = Math.min(descriptionLength / 800, 1); // Cap at 1 for 800+ characters
            }

            // Calculate total strength (description is worth 2 regular fields)
            const totalFields = fields.length + 2; // +2 for description
            const strength = Math.round(((filledFields + (descriptionScore * 2)) / totalFields) * 100);

            const strengthProgress = document.getElementById('strength-progress');
            const strengthLabel = document.getElementById('strength-label');
            const strengthPercentage = document.getElementById('strength-percentage');

            // Update circular progress bar
            strengthProgress.style.strokeDasharray = `${strength}, 100`;
            strengthPercentage.textContent = `${strength}%`;

            // Update label and color based on strength
            let label, color;
            if (strength < 20) {
                label = 'Needs work';
                color = '#EF4444'; // red-500
            } else if (strength < 40) {
                label = 'Needs improvement';
                color = '#F97316'; // orange-500
            } else if (strength < 60) {
                label = 'Not bad.';
                color = '#EAB308'; // yellow-500
            } else if (strength < 80) {
                label = 'Pretty good.';
                color = '#22C55E'; // green-500
            } else {
                label = 'Looks great!';
                color = '#3B82F6'; // blue-500
            }

            strengthLabel.textContent = label;
            strengthProgress.setAttribute('stroke', color);
        }
    });
</script>
