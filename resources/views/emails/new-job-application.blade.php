<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Job Application Received</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
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
            overflow: hidden;
            padding: 30px;
        }

        .spacer {
            padding: 15px 0;
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
            margin: 0 0 30px 0;
        }

        h2 {
            color: #374151;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
        }

        p {
            margin: 0;
        }

        .label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .value {
            font-size: 14px;
            color: #111827;
        }

        .button {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
            transition-duration: 200ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .button:hover {
            background-color: #1d4ed8;
        }

        .button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.5);
        }

        hr {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 15px;
            max-width: 85%;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        .content {
            padding: 15px;
        }

        table {
            margin-top: 15px;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            font-weight: 600;
            color: #374151;
            background-color: #f9fafb;
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
            <div class="content">
                <h1>New Applicant for {{ $jobApplication->jobListing->title }}</h1>

                <h2>Applicant Information</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                    <tr>
                        <td>{{ $jobApplication->name }}</td>
                        <td>{{ $jobApplication->email }}</td>
                        <td>{{ $jobApplication->phone }}</td>
                    </tr>
                </table>


                <div class="spacer">
                    <h2>Resume</h2>
                    @if ($jobApplication->resume_path)
                        <a href="{{ Storage::disk('s3')->url($jobApplication->resume_path) }}" target="_blank">View
                            Resume</a>
                    @else
                        <span class="value">No resume uploaded.</span>
                    @endif
                </div>

                <div class="spacer">
                    <h2>Cover Letter</h2>
                    <p>{{ $jobApplication->cover_letter ?? 'No cover letter provided.' }}</p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>This is a transactional email regarding a job application on EquineHire.</p>
            <p>If you need any assistance, please contact us at <a
                    href="mailto:help@equinehire.com">help@equinehire.com</a>.</p>
        </div>

    </div>
</body>

</html>
