<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $assessment->title }}</title>
</head>
<body style="margin:0;padding:0;background:#f2f7f8;font-family:'Century Gothic',Futura,'Avant Garde',Verdana,sans-serif;color:#101820;">
@php $fmt = fn($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.'); @endphp
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f2f7f8;padding:32px 12px;">
    <tr><td align="center">
            <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="max-width:560px;width:100%;background:#ffffff;border-top:4px solid #146c77;border-radius:8px;">
                <tr><td style="padding:32px 32px 8px;">
                        <div style="color:#146c77;font-size:12px;font-weight:bold;letter-spacing:2px;text-transform:uppercase;">Office of Professional Auditors</div>
                        <h1 style="font-size:26px;line-height:1.2;margin:14px 0 0;color:#101820;">Put your training into practice.</h1>
                    </td></tr>
                <tr><td style="padding:12px 32px 0;font-size:15px;line-height:1.6;color:#101820;">
                        <p style="margin:0 0 14px;">Hello {{ $attendant->name }},</p>
                        <p style="margin:0 0 14px;">Your <strong>{{ $assessment->title }}</strong> is ready. Use your personal code to start.</p>
                    </td></tr>
                <tr><td style="padding:4px 32px 0;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#e7f5fb;border-radius:8px;">
                            <tr><td style="padding:18px 20px;">
                                    <div style="font-size:12px;color:#4c4e56;text-transform:uppercase;letter-spacing:1px;">Your personal access code</div>
                                    <div style="font-size:28px;font-weight:bold;letter-spacing:3px;color:#146c77;margin-top:4px;">{{ $attendant->access_code }}</div>
                                </td></tr>
                        </table>
                    </td></tr>
                <tr><td align="center" style="padding:24px 32px 8px;">
                        <a href="{{ $link }}" style="display:inline-block;background:#146c77;color:#ffffff;text-decoration:none;font-weight:bold;font-size:16px;padding:14px 32px;border-radius:8px;">Start your assessment</a>
                    </td></tr>
                <tr><td style="padding:8px 32px 0;font-size:13px;color:#4c4e56;line-height:1.5;word-break:break-all;">
                        Button not working? Open this link:<br><a href="{{ $link }}" style="color:#146c77;">{{ $link }}</a>
                    </td></tr>
                <tr><td style="padding:20px 32px 0;font-size:14px;line-height:1.6;color:#101820;">
                        <strong>Before you begin</strong>
                        <ul style="margin:8px 0 0;padding-left:18px;">
                            <li>{{ $assessment->questions()->count() }} questions, {{ $fmt($assessment->totalMarks()) }} marks. Pass mark: {{ $assessment->pass_mark }}%.</li>
                            <li>Suggested time: {{ $assessment->suggested_minutes }} minutes. A calculator is allowed.</li>
                            <li>Enter your name, this email address and your code on the page.</li>
                            <li>One final submission per code. Keep your code private.</li>
                        </ul>
                    </td></tr>
                <tr><td style="padding:24px 32px 32px;font-size:12px;color:#4c4e56;border-top:0;">
                        Questions? Reply to your trainer. This message was sent to {{ $attendant->email }}.
                    </td></tr>
            </table>
        </td></tr>
</table>
</body>
</html>
