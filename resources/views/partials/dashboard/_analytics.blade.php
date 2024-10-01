<div class="overflow-hidden bg-white border sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Job Listing Views</h3>
        <p class="max-w-2xl mt-1 text-sm text-gray-500">Total views for your job listings.</p>
    </div>
    <hr class="max-w-[95%] mx-auto">
    <div class="p-4 border-gray-200 sm:px-6">
        <div id="noDataMessage" class="text-left text-gray-500">
            Loading chart data...
        </div>
        <canvas id="jobListingsChart" width="400" height="100" style="display: none;"></canvas>
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

                    new Chart(document.getElementById('jobListingsChart'), {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Views',
                                data: data.views,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
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
                                        display: true,
                                        text: 'Job Listings'
                                    }
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
