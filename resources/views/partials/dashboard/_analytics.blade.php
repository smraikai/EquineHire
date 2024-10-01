<div class="overflow-hidden bg-white rounded-lg shadow">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Job Listing Views</h3>
            </div>
            <div class="flex items-center">
                <span id="totalViews" class="text-2xl font-semibold text-gray-900">-</span>
                <span class="ml-2 text-sm font-medium text-gray-500">total views</span>
            </div>
        </div>
        <div class="mt-4">
            <div id="noDataMessage" class="py-8 text-center text-gray-500">
                Loading chart data...
            </div>
            <canvas id="jobListingsChart" class="w-full h-64" style="display: none;"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/job-listings-views')
            .then(response => {
                if (response.status === 204) {
                    throw new Error('No job listings found');
                }
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                if (data.labels && data.labels.length > 0) {
                    document.getElementById('noDataMessage').style.display = 'none';
                    document.getElementById('jobListingsChart').style.display = 'block';

                    const totalViews = data.views.reduce((a, b) => a + b, 0);
                    document.getElementById('totalViews').textContent = totalViews;

                    new Chart(document.getElementById('jobListingsChart'), {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Page Views',
                                data: data.views,
                                backgroundColor: 'rgba(59, 130, 246, 0.8)', // blue-500 with opacity
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Views'
                                    }
                                },
                                x: {
                                    title: {
                                        display: false,
                                        text: 'Job Listings'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                } else {
                    document.getElementById('noDataMessage').textContent =
                        'No views yet? Don\'t worry, your chart is just warming up!';
                }
            })
            .catch(error => {
                console.error('Error fetching chart data:', error);
                if (error.message === 'No job listings found') {
                    document.getElementById('noDataMessage').textContent =
                        'You haven\'t created any job listings yet. Create one to start seeing analytics!';
                } else {
                    document.getElementById('noDataMessage').textContent =
                        'Error loading chart data: ' + error.message;
                }
            });
    });
</script>
