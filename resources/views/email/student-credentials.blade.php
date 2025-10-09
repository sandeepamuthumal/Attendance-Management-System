<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login Credentials & QR Code</title>
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
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        .credentials-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .credential-item {
            margin: 10px 0;
        }
        .credential-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 120px;
        }
        .credential-value {
            color: #333;
            font-family: 'Courier New', monospace;
            background-color: #fff;
            padding: 5px 10px;
            border-radius: 3px;
            display: inline-block;
        }
        .qr-section {
            background-color: #e8f4f8;
            border: 2px dashed #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
        }
        .qr-section h3 {
            color: #667eea;
            margin-top: 0;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #5568d3;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box {
            background-color: #d1ecf1;
            border-left: 4px solid #0dcaf0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Welcome to {{ config('app.name') }}</h1>
        </div>

        <div class="content">
            <h2>Hello {{ $student->name }},</h2>

            <p>Welcome to our attendance management system! Your student account has been successfully created.</p>

            <p>You can now access the system using the following credentials:</p>

            <div class="credentials-box">
                <div class="credential-item">
                    <span class="credential-label">Student ID:</span>
                    <span class="credential-value">{{ $student->student_id }}</span>
                </div>
                <div class="credential-item">
                    <span class="credential-label">Email:</span>
                    <span class="credential-value">{{ $student->email }}</span>
                </div>
                <div class="credential-item">
                    <span class="credential-label">Password:</span>
                    <span class="credential-value">{{ $password }}</span>
                </div>
            </div>

            <div class="warning">
                <strong>⚠️ Security Notice:</strong> Please change your password after your first login for security purposes.
            </div>

            <div class="qr-section">
                <h3>📱 Your Attendance QR Code</h3>
                <p>Your personal QR code for attendance marking is attached to this email.</p>
                <p><strong>Important:</strong> This QR code is unique to you. Please download and save it securely. You'll need to present this code when marking attendance.</p>
            </div>

            <div class="info-box">
                <strong>💡 How to use your QR Code:</strong>
                <ul style="text-align: left; margin: 10px 0;">
                    <li>Download the QR code image attached to this email</li>
                    <li>Save it on your mobile device for easy access</li>
                    <li>Present the QR code to your teacher when asked</li>
                    <li>Keep your QR code private - do not share it with others</li>
                </ul>
            </div>

            <center>
                <a href="{{ route('login') }}" class="button">Login to Your Account</a>
            </center>

            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

            <p>Best regards,<br>{{ config('app.name') }} Team</p>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
