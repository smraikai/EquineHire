<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job Application Received</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.5;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            background-color: #f3f4f6;
            padding: 30px;
        }

        .container {
            max-width: 500px;
            margin: 25px auto;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 30px;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            max-width: 200px;
        }

        h1 {
            color: #111827;
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 20px 0;
            text-align: center;
        }

        .button {
            display: block;
            background-color: #2563eb;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 500;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            margin: 25px auto;
            max-width: 200px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="logo">
                <img src="https://equinehire-static-assets.s3.amazonaws.com/logo.png" alt="EquineHire Logo">
            </div>
            <div style="width: 75px; height: 5px; background-color: #1d4ed8; margin: 15px auto;"></div>

            <h1>New Application Received</h1>

            <p style="text-align: center;">
                You have received a new application for:<br>
                <strong>{{ $jobApplication->jobListing->title }}</strong>
            </p>

            <a href="{{ route('employer.applications.show', $jobApplication->id) }}" class="button">
                View Application
            </a>

        </div>

        <div class="footer">
            <p>This is a notification email from EquineHire.</p>
            <p>Need help? Contact us at <a href="mailto:help@equinehire.com">help@equinehire.com</a></p>
        </div>
    </div>
</body>

</html>
