<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background-color: #0d6efd; color: #ffffff; text-align: center; padding: 30px;">
                            <h2 style="margin:0; font-weight: 600;">Reset Your Password</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px; color: #333333; font-size: 16px; line-height: 1.5;">
                            <p>Hi {{ $name }},</p>
                            <p>You requested a password reset. Click the button below to reset your password:</p>
                            <p style="text-align: center; margin: 30px 0;">
                                <a href="{{ url('password/reset/'.$token) }}"
                                   style="background-color: #0d6efd; color: #ffffff; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: 500; display: inline-block;">
                                   Reset Password
                                </a>
                            </p>
                            <p>If you did not request this, simply ignore this email. Your account is safe.</p>

                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #f1f3f5; text-align: center; padding: 20px; color: #6c757d; font-size: 14px;">
                            © {{ date('Y') }} . All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
