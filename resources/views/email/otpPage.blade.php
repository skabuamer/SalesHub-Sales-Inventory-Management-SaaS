<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Inventory OTP</title>
</head>

<body style="margin: 0; padding: 0; width: 100%; background-color: #f1f5f9; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
        style="width: 100%; background-color: #f1f5f9; margin: 0; padding: 0;">
        <tr>
            <td align="center" style="padding: 40px 16px;">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                    style="width: 100%; max-width: 560px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(15, 23, 42, 0.12);">
                    <tr>
                        <td align="center" style="background-color: #0f172a; padding: 28px 32px;">
                            <p
                                style="margin: 0; color: #67e8f9; font-size: 12px; line-height: 18px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px;">
                                Verification Code
                            </p>
                            <h1
                                style="margin: 12px 0 0; color: #ffffff; font-size: 24px; line-height: 32px; font-weight: 700;">
                                {{ config('app.name', 'Sales Inventory') }}
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 36px 32px; color: #334155;">
                            <h2
                                style="margin: 0; color: #020617; font-size: 20px; line-height: 28px; font-weight: 700;">
                                Confirm your email
                            </h2>

                            <p style="margin: 16px 0 0; color: #334155; font-size: 16px; line-height: 28px;">
                                Use the one-time password below to continue your request. This code should only be used
                                by you.
                            </p>

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                                style="margin: 32px 0; width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; background-color: #f8fafc;">
                                <tr>
                                    <td align="center" style="padding: 24px;">
                                        <p
                                            style="margin: 0; color: #64748b; font-size: 12px; line-height: 18px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">
                                            Your OTP
                                        </p>
                                        <p
                                            style="margin: 12px 0 0; color: #020617; font-family: 'Courier New', Courier, monospace; font-size: 40px; line-height: 48px; font-weight: 700; letter-spacing: 8px;">
                                            {{ $otp }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0; color: #475569; font-size: 14px; line-height: 24px;">
                                If you did not request this code, you can safely ignore this email. For your security,
                                do not share this OTP with anyone.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center"
                            style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; padding: 24px 32px;">
                            <p style="margin: 0; color: #64748b; font-size: 12px; line-height: 20px;">
                                &copy; {{ date('Y') }} {{ config('app.name', 'Sales Inventory') }}. All rights
                                reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
