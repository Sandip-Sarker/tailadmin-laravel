<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $messageTitle }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .wrapper {
            max-width: 600px;
            margin: 0 auto;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .description {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 30px;
        }
        .otp-section {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            border-radius: 6px;
            text-align: center;
        }
        .otp-label {
            font-size: 14px;
            color: #777;
            margin-bottom: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .verification-code {
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            letter-spacing: 3px;
            font-family: 'Courier New', monospace;
            padding: 10px;
        }
        .validity {
            font-size: 13px;
            color: #999;
            margin-top: 15px;
            font-style: italic;
        }
        .action-info {
            font-size: 15px;
            line-height: 1.7;
            color: #555;
            margin: 20px 0;
            padding: 15px;
            background-color: #f0f4ff;
            border-radius: 6px;
        }
        .action-info strong {
            color: #333;
        }
        .security-notice {
            font-size: 14px;
            color: #d9534f;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px 40px;
            text-align: center;
            font-size: 13px;
            color: #888;
            border-top: 1px solid #eee;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <div class="header">
            <h1>{{ $messageTitle }}</h1>
            <p>{{ config('app.name') }}</p>
        </div>
        
        <div class="content">
            <p class="greeting">Hello {{ $user->name }},</p>
            
            @if($mailType === 'forgot_password')
                <p class="description">We received a request to reset the password for your account. Please use the verification code below to proceed with resetting your password:</p>
            @elseif($mailType === 'verify')
                <p class="description">Please verify your email address by using the verification code below. This will confirm that you have access to this email address.</p>
            @endif
            
            <div class="otp-section">
                <div class="otp-label">Your Verification Code</div>
                <div class="verification-code">{{ $otp }}</div>
                <div class="validity">Valid for 60 secound</div>
            </div>
        
            <div class="action-info">
                @if($mailType === 'forgot_password')
                    <strong>What to do next:</strong> Use this code to reset your password on our platform.
                @elseif($mailType === 'verify')
                    <strong>What to do next:</strong> Enter this code to complete your email verification.
                @endif
            </div>
            
            <div class="security-notice">
                <strong>⚠️ Security Notice:</strong> If you did not request this code, please ignore this email and do not share this code with anyone.
            </div>
        </div>
        
        <div class="footer">
            <p>Thank you for using {{ config('app.name') }}</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
