<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; margin: 0; padding: 0; }
        .container { max-width: 480px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px 24px; }
        .header { text-align: center; margin-bottom: 24px; }
        .header h2 { color: #007bff; font-weight: bold; margin: 0; }
        .content { color: #444; font-size: 16px; }
        .footer { margin-top: 32px; text-align: center; color: #888; font-size: 13px; }
        .password-box { background: #f1f1f1; border-radius: 4px; padding: 12px; font-size: 18px; font-weight: bold; color: #ff5722; text-align: center; margin: 24px 0; letter-spacing: 2px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Password Reset for BiT</h2>
        </div>
        <div class="content">
            <p>Hi <strong>{{ $name }}</strong>,</p>
            <p>Your password has been reset. Please use the new password below to log in:</p>
            <div class="password-box">{{ $newPassword }}</div>
            <p>For your security, you will be prompted to change this password after logging in.</p>
            <p style="margin-top:32px; color:#888; font-size:14px;">If you did not request a password reset, please contact support immediately.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} BiT. All rights reserved.
        </div>
    </div>
</body>
</html>
