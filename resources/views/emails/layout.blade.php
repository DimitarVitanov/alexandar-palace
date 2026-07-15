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
            font-family: 'Georgia', 'Times New Roman', serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            color: #d4af37;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }
        .tagline {
            color: #a0a0a0;
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 24px;
            color: #1a1a2e;
            margin-bottom: 20px;
        }
        .message {
            color: #555;
            margin-bottom: 25px;
            font-size: 16px;
        }
        .details-box {
            background-color: #f8f6f0;
            border-left: 4px solid #d4af37;
            padding: 25px;
            margin: 25px 0;
        }
        .details-box h3 {
            color: #1a1a2e;
            font-size: 16px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .details-row {
            display: flex;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .details-label {
            color: #888;
            width: 140px;
            flex-shrink: 0;
        }
        .details-value {
            color: #333;
            font-weight: 500;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #d4af37 0%, #c9a227 100%);
            color: #1a1a2e;
            padding: 15px 35px;
            text-decoration: none;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 13px;
            margin: 20px 0;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #d4af37, transparent);
            margin: 30px 0;
        }
        .footer {
            background-color: #1a1a2e;
            padding: 30px;
            text-align: center;
        }
        .footer-logo {
            color: #d4af37;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }
        .footer-contact {
            color: #a0a0a0;
            font-size: 13px;
            line-height: 1.8;
        }
        .footer-contact a {
            color: #d4af37;
            text-decoration: none;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            display: inline-block;
            width: 35px;
            height: 35px;
            background-color: #2a2a4e;
            color: #d4af37;
            text-decoration: none;
            line-height: 35px;
            margin: 0 5px;
            font-size: 14px;
        }
        .copyright {
            color: #666;
            font-size: 11px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #2a2a4e;
        }
        .highlight {
            color: #d4af37;
            font-weight: bold;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-cancelled {
            background-color: #f8d7da;
            color: #842029;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 30px 20px;
            }
            .details-box {
                padding: 20px;
            }
            .details-row {
                flex-direction: column;
            }
            .details-label {
                width: 100%;
                margin-bottom: 3px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <div class="logo">ALEXANDAR PALACE</div>
            <div class="tagline">Luxury Hotel & Spa</div>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            <div class="footer-logo">ALEXANDAR PALACE</div>
            <div class="footer-contact">
                <p>Bul. Ilinden 123, Skopje, North Macedonia</p>
                <p>Phone: <a href="tel:+38923123456">+389 2 312 3456</a></p>
                <p>Email: <a href="mailto:info@alexandarpalace.mk">info@alexandarpalace.mk</a></p>
            </div>
            <div class="copyright">
                &copy; {{ date('Y') }} Alexandar Palace Hotel. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
