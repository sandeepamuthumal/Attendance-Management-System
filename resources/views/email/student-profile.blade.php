<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile & QR Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px;
        }

        .section-title {
            color: #667eea;
            font-size: 18px;
            font-weight: bold;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #667eea;
        }

        .profile-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }

        .profile-row {
            display: table;
            width: 100%;
            margin: 12px 0;
        }

        .profile-label {
            display: table-cell;
            font-weight: bold;
            color: #555;
            width: 150px;
            padding-right: 15px;
        }

        .profile-value {
            display: table-cell;
            color: #333;
        }

        .student-id-badge {
            background-color: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
        }

        .qr-section {
            background: linear-gradient(135deg, #e8f4f8 0%, #f0e8f8 100%);
            border: 2px solid #667eea;
            padding: 25px;
            margin: 25px 0;
            border-radius: 12px;
            text-align: center;
        }

        .qr-section h3 {
            color: #667eea;
            margin-top: 0;
            font-size: 20px;
        }

        .qr-note {
            background-color: #fff;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
            font-size: 14px;
        }

        .classes-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .classes-table th {
            background-color: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .classes-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .classes-table tr:last-child td {
            border-bottom: none;
        }

        .classes-table tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        .info-box {
            background-color: #d1ecf1;
            border-left: 4px solid #0dcaf0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .info-box ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .info-box li {
            margin: 5px 0;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .no-classes {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Student Profile Information</h1>
            <p style="margin: 10px 0 0 0; font-size: 14px;">{{ config('app.name') }}</p>
        </div>

        <div class="content">
            <p>Dear {{ $student->name }},</p>

            <p>Your student profile has been successfully created in our attendance management system. Below are your
                details and personalized QR code.</p>

            {{-- Student Information Section --}}
            <h2 class="section-title">📋 Student Information</h2>

            <div class="profile-section">
                <div class="profile-row">
                    <div class="profile-label">Student ID:</div>
                    <div class="profile-value">
                        <span class="student-id-badge">{{ $student->student_id }}</span>
                    </div>
                </div>

                <div class="profile-row">
                    <div class="profile-label">Name:</div>
                    <div class="profile-value">{{ $student->full_name }}</div>
                </div>

                <div class="profile-row">
                    <div class="profile-label">Email:</div>
                    <div class="profile-value">{{ $student->email }}</div>
                </div>

                @if ($student->nic)
                    <div class="profile-row">
                        <div class="profile-label">NIC:</div>
                        <div class="profile-value">{{ $student->nic }}</div>
                    </div>
                @endif

                @if ($student->contact_no)
                    <div class="profile-row">
                        <div class="profile-label">Contact:</div>
                        <div class="profile-value">{{ $student->contact_no }}</div>
                    </div>
                @endif

                @if ($student->parent_contact_no)
                    <div class="profile-row">
                        <div class="profile-label">Parent Contact:</div>
                        <div class="profile-value">{{ $student->parent_contact_no }}</div>
                    </div>
                @endif

                @if ($student->address)
                    <div class="profile-row">
                        <div class="profile-label">Address:</div>
                        <div class="profile-value">{{ $student->address }}</div>
                    </div>
                @endif
            </div>

            {{-- Enrolled Classes Section --}}
            <h2 class="section-title">📚 Enrolled Classes</h2>

            @if ($classes && count($classes) > 0)
                <table class="classes-table">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Grade</th>
                            <th>Year</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $enrollment)
                            <tr>
                                <td><strong>{{ $enrollment->class->class_name }}</strong></td>
                                <td>{{ $enrollment->class->subject->subject }}</td>
                                <td>{{ $enrollment->class->teacher->user->full_name }}</td>
                                <td>{{ $enrollment->class->grade->grade }}</td>
                                <td>{{ $enrollment->class->year }}</td>
                                <td>
                                    <span class="status-badge {{ $enrollment->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $enrollment->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-classes">
                    <p>No classes enrolled yet. Please contact your administrator to enroll in classes.</p>
                </div>
            @endif

            {{-- QR Code Section --}}
            <h2 class="section-title">🎫 Your Attendance QR Code</h2>

            <div class="qr-section">
                <h3>Personal QR Code</h3>
                <div class="qr-note">
                    <strong>QR Code for: {{ $student->student_id }}</strong>
                    <p style="margin: 5px 0;">Your unique QR code is attached to this email as
                        <strong>"attendance-qr-code.png"</strong>
                    </p>
                </div>
                <p>This QR code is your digital identity for marking attendance in all your classes.</p>
            </div>

            <div class="info-box">
                <strong>💡 How to use your QR Code:</strong>
                <ul>
                    <li><strong>Download:</strong> Save the QR code image attached to this email</li>
                    <li><strong>Store Safely:</strong> Keep it on your mobile device or print it out</li>
                    <li><strong>Present When Asked:</strong> Show the QR code to your teacher during attendance</li>
                    <li><strong>Keep Private:</strong> This QR code is unique to you - do not share it with others</li>
                </ul>
            </div>

            <p style="margin-top: 30px;">If you have any questions about your enrollment or need assistance, please
                contact your class coordinator or the administration office.</p>

            <p>Best regards,<br>
                <strong>{{ config('app.name') }} Administration</strong>
            </p>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>For support, please contact: {{ config('mail.from.address') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
