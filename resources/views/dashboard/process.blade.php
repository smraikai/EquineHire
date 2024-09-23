<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing - EquineHire</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .loader,
        .loader:before,
        .loader:after {
            border-radius: 50%;
            width: 2.5em;
            height: 2.5em;
            animation: bblFadInOut 1.8s infinite ease-in-out;
            animation-fill-mode: both
        }

        .loader {
            color: #10b981;
            font-size: 7px;
            position: relative;
            text-indent: -9999em;
            transform: translateZ(0);
            animation-delay: -.16s;
            display: inline-block;
            margin-right: 10px
        }

        .loader:before,
        .loader:after {
            content: '';
            position: absolute;
            top: 0
        }

        .loader:before {
            left: -3.5em;
            animation-delay: -.32s
        }

        .loader:after {
            left: 3.5em
        }

        @keyframes bblFadInOut {

            0%,
            80%,
            100% {
                box-shadow: 0 2.5em 0 -1.3em
            }

            40% {
                box-shadow: 0 2.5em 0 0
            }
        }
    </style>
</head>

<body>
    <div class="flex flex-col items-center justify-center min-h-screen">
        <div class="p-8 text-center">
            <span class="mb-8 loader"></span>
            <h1 class="mb-4 text-4xl font-bold text-gray-900 fancy-title">We're working our magic!</h1>
            <p class="mt-4 text-lg text-gray-600">This may take a few moments.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function checkProcessingStatus() {
            $.get('/check-processing-status/{{ $business->id }}', function(data) {
                if (data.completed) {
                    // Replace the current state in history
                    history.replaceState(null, '', data.redirect);
                    // Redirect to the new URL
                    window.location.href = data.redirect;
                } else {
                    setTimeout(checkProcessingStatus, 1000);
                }
            });
        }

        $(document).ready(function() {
            // Replace the current state in history with the edit page URL
            history.replaceState(null, '', '{{ route('employer.edit', $business->id) }}');

            setTimeout(checkProcessingStatus, 3000);

            // Add automatic redirect after 8 seconds
            setTimeout(function() {
                window.location.href = '{{ route('employer.edit', $business->id) }}';
            }, 8000);
        });
    </script>

</body>

</html>
