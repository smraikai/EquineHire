<div id="listing-strength-card"
    class="z-50 w-full p-4 mb-4 bg-white border rounded-lg shadow-md md:fixed md:top-4 md:right-4 md:w-64 md:mb-0">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Listing Strength</h3>
            <span id="strength-label" class="text-sm font-medium text-gray-600">Needs work</span>
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
    <div id="listing-advice" class="mt-2 text-sm text-gray-600"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quillInitInterval = setInterval(() => {
            if (window.quill) {
                clearInterval(quillInitInterval);
                initializeListingStrength();
            }
        }, 100);

        function initializeListingStrength() {
            quill.on('text-change', updateListingStrength);
            updateListingStrength();
        }

        function updateListingStrength() {
            const description = quill.getText().trim();
            const descriptionLength = description.length;
            const strength = Math.min(Math.round((descriptionLength / 600) * 100), 100);

            console.log(`Description length: ${descriptionLength}, Strength: ${strength}%`);

            const strengthProgress = document.getElementById('strength-progress');
            const strengthLabel = document.getElementById('strength-label');
            const strengthPercentage = document.getElementById('strength-percentage');
            const listingAdvice = document.getElementById('listing-advice');

            strengthProgress.style.strokeDasharray = `${strength}, 100`;
            strengthPercentage.textContent = `${strength}%`;

            let label, color;
            if (strength < 20) {
                label = 'Needs work';
                color = '#EF4444'; // red-500
            } else if (strength < 40) {
                label = 'Needs improvement';
                color = '#F97316'; // orange-500
            } else if (strength < 60) {
                label = 'Not bad';
                color = '#EAB308'; // yellow-500
            } else if (strength < 80) {
                label = 'Pretty good';
                color = '#22C55E'; // green-500
            } else {
                label = 'Looks great!';
                color = '#3B82F6'; // blue-500
            }

            strengthLabel.textContent = label;
            strengthProgress.setAttribute('stroke', color);

            if (strength < 80) {
                listingAdvice.textContent =
                    'Tip: A strong job description includes key responsibilities, required qualifications, company culture, and benefits.';
                listingAdvice.classList.remove('hidden');
            } else {
                listingAdvice.classList.add('hidden');
            }
        }
    });
</script>
