<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin:0;padding:24px;background:#eef3f8;font-family:Arial,sans-serif;color:#1f2937;">
    <div style="max-width:580px;margin:0 auto;">
        <div style="text-align:center;padding:8px 0 18px;">
            <div style="font-size:18px;font-weight:700;color:#1a3c5e;">Ananth Decodes Logistics</div>
        </div>

        <div style="background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 14px 40px rgba(15,30,46,0.08);">
            <div style="background:#1a3c5e;padding:24px 32px;">
                <div style="color:#93c5fd;font-size:12px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">Account Security</div>
                <h1 style="margin:0;color:#ffffff;font-size:22px;line-height:1.35;">Reset your password</h1>
                <p style="margin:8px 0 0;color:#dbeafe;font-size:14px;line-height:1.7;">We received a request to reset the password for your Ananth Decodes Logistics account.</p>
            </div>

            <div style="padding:30px 32px;">
                <p style="margin:0 0 14px;color:#374151;font-size:15px;line-height:1.8;">Hi,</p>
                <p style="margin:0 0 16px;color:#374151;font-size:15px;line-height:1.8;">
                    Use the button below to create a new password and regain access to your account. For security, this reset link is time-sensitive.
                </p>

                <div style="background:#f8fafc;border-left:4px solid #3882fa;border-radius:0 8px 8px 0;padding:14px 16px;margin:18px 0 22px;">
                    <strong style="display:block;color:#1e3a8a;font-size:14px;margin-bottom:4px;">Important</strong>
                    <span style="color:#475569;font-size:14px;line-height:1.7;">This password reset link will expire in 60 minutes. If you did not request it, you can safely ignore this email.</span>
                </div>

                <div style="text-align:center;margin:28px 0 24px;">
                    <a href="{{ route('reset.password.get', $token) }}" style="display:inline-block;background:#3882fa;color:#ffffff;text-decoration:none;font-weight:700;font-size:14px;padding:13px 28px;border-radius:8px;">Reset Password</a>
                </div>

                <p style="margin:0 0 10px;color:#374151;font-size:14px;line-height:1.8;">
                    If the button does not work, copy and paste this link into your browser:
                </p>
                <div style="word-break:break-word;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:14px 16px;">
                    <a href="{{ route('reset.password.get', $token) }}" style="color:#2563eb;font-size:14px;line-height:1.8;text-decoration:none;">{{ route('reset.password.get', $token) }}</a>
                </div>

                <p style="margin:24px 0 0;color:#374151;font-size:14px;line-height:1.8;">
                    Regards,<br>
                    <strong>Ananth Decodes Logistics</strong>
                </p>
            </div>

            <div style="padding:16px 32px;border-top:1px solid #e5e7eb;color:#94a3b8;font-size:12px;line-height:1.7;">
                This is an automated password reset email from Ananth Decodes Logistics.
            </div>
        </div>
    </div>
</body>
</html>
