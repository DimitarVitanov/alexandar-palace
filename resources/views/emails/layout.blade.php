<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Alexandar Palace' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            background-color: #f7f7f7;
            color: #1f1f1f;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }
        .email-wrapper {
            background-color: #ffffff;
            margin: 0 auto;
            max-width: 600px;
            width: 100%;
        }
        .header {
            background: #ffffff;
            border-bottom: 1px solid #e4e4e4;
            padding: 34px 30px 30px;
            text-align: center;
        }
        .logo {
            color: #20201e;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 22px;
            font-weight: normal;
            letter-spacing: 3px;
            margin-bottom: 7px;
        }
        .tagline {
            color: #77746f;
            font-size: 10px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
        }
        .content {
            padding: 44px 38px;
        }
        .greeting {
            color: #20201e;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 26px;
            font-weight: normal;
            letter-spacing: -.2px;
            margin-bottom: 16px;
        }
        .message {
            color: #555555;
            font-size: 15px;
            line-height: 1.75;
            margin-bottom: 20px;
        }
        .details-box {
            background-color: #ffffff;
            border: 1px solid #e2e2e2;
            padding: 22px;
            margin: 26px 0;
        }
        .details-box h3 {
            color: #20201e;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1.6px;
            margin-bottom: 17px;
            text-transform: uppercase;
        }
        .details-row {
            border-top: 1px solid #ededed;
            display: flex;
            font-size: 14px;
            margin: 0;
            padding: 11px 0;
        }
        .details-row:first-of-type { border-top: 0; padding-top: 0; }
        .details-label {
            color: #777777;
            flex-shrink: 0;
            width: 142px;
        }
        .details-value {
            color: #282725;
            font-weight: 500;
        }
        .cta-button {
            background: #282725;
            color: #ffffff;
            display: inline-block;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1.3px;
            margin: 20px 0;
            padding: 14px 24px;
            text-decoration: none;
            text-transform: uppercase;
        }
        .divider {
            background: #dedede;
            height: 1px;
            margin: 32px 0;
        }
        .footer {
            background-color: #fafafa;
            border-top: 1px solid #e2e2e2;
            padding: 30px;
            text-align: center;
        }
        .footer-logo {
            color: #343330;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 15px;
            font-weight: normal;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }
        .footer-contact {
            color: #77746f;
            font-size: 12px;
            line-height: 1.8;
        }
        .footer-contact a {
            color: #343330;
            text-decoration: underline;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            background-color: #ffffff;
            border: 1px solid #d8d8d8;
            color: #343330;
            display: inline-block;
            font-size: 14px;
            height: 35px;
            line-height: 35px;
            margin: 0 5px;
            text-decoration: none;
            width: 35px;
        }
        .copyright {
            border-top: 1px solid #e2e2e2;
            color: #888888;
            font-size: 11px;
            margin-top: 20px;
            padding-top: 20px;
        }
        .highlight {
            color: #20201e;
            font-weight: bold;
        }
        .status-badge {
            border: 1px solid #b8b8b8;
            color: #444444;
            display: inline-block;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.4px;
            padding: 7px 11px;
            text-transform: uppercase;
        }
        .status-pending, .status-confirmed, .status-cancelled { background-color: transparent; color: #444444; }
        @media only screen and (max-width: 600px) {
            .email-wrapper { width: 100% !important; }
            .content { padding: 30px 20px !important; }
            .header { padding: 28px 20px !important; }
            .footer { padding: 26px 20px !important; }
            .greeting { font-size: 23px !important; }
            .message { font-size: 16px !important; }
            .details-box { padding: 18px !important; }
            .details-row { display: block !important; margin-bottom: 14px !important; }
            .details-label { display: block !important; margin-bottom: 3px !important; width: 100% !important; }
            .cta-button { box-sizing: border-box !important; padding: 15px 18px !important; width: 100% !important; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <img src="{{ config('app.url') }}/assets/paradise/img/logo.png" alt="Alexandar Palace" style="max-width: 200px; height: auto; margin-bottom: 10px;">
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <img src="{{ config('app.url') }}/assets/paradise/img/logo.png" alt="Alexandar Palace" style="max-width: 150px; height: auto; margin-bottom: 15px;">
            <div class="footer-contact">
                <p>Blvd. 8th September No. 15, Skopje, Macedonia</p>
                <p>Phone: <a href="tel:+38923092392">+389 (2) 3092 392</a></p>
                <p>Email: <a href="mailto:info@aleksandarpalace.com.mk">info@aleksandarpalace.com.mk</a></p>
            </div>
            <div class="copyright">
                &copy; {{ date('Y') }} Alexandar Palace Hotel. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
