<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Code d'authentification</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #c3cfe2 0%, #f0d4f5 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .email-wrapper {
            max-width: 600px;
            width: 100%;
        }

        .container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(177, 0, 205, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #b100cd 0%, #9500ab 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: #ffffff;
            border-radius: 20px 20px 0 0;
        }

        .logo {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 600;
            margin: 0;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-top: 8px;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #2d3436;
            margin-bottom: 20px;
        }

        .greeting strong {
            color: #b100cd;
            font-weight: 600;
        }

        .message {
            color: #636e72;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .otp-container {
            background: linear-gradient(135deg, #f0d4f5 0%, #d84deb15 100%);
            border: 2px dashed #b100cd;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            position: relative;
        }

        .otp-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9500ab;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .otp {
            font-size: 42px;
            font-weight: 700;
            color: #b100cd;
            letter-spacing: 8px;
            margin: 10px 0;
            text-shadow: 0 2px 4px rgba(177, 0, 205, 0.1);
        }

        .otp-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
        }

        .warning-box {
            background: rgba(255, 107, 157, 0.1);
            border-left: 4px solid #ff6b9d;
            padding: 16px 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .warning-box p {
            color: #2d3436;
            font-size: 14px;
            margin: 0;
        }

        .warning-box strong {
            color: #ff6b9d;
            font-weight: 600;
        }

        .info-box {
            background: rgba(0, 201, 167, 0.1);
            border-left: 4px solid #00c9a7;
            padding: 16px 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .info-box p {
            color: #2d3436;
            font-size: 14px;
            margin: 0;
            line-height: 1.5;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #b100cd 0%, #9500ab 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            margin: 20px auto;
            display: block;
            text-align: center;
            box-shadow: 0 4px 15px rgba(177, 0, 205, 0.3);
            transition: transform 0.2s;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(177, 0, 205, 0.4);
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #dfe6e9, transparent);
            margin: 30px 0;
        }

        .footer {
            background: #f5f7fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #dfe6e9;
        }

        .footer-logo {
            font-size: 14px;
            color: #b100cd;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .footer-text {
            font-size: 12px;
            color: #95a5a6;
            line-height: 1.6;
            margin: 8px 0;
        }

        .footer-links {
            margin-top: 15px;
        }

        .footer-links a {
            color: #b100cd;
            text-decoration: none;
            font-size: 12px;
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .social-icons {
            margin-top: 15px;
        }

        .social-icons span {
            font-size: 20px;
            margin: 0 8px;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .header {
                padding: 30px 20px;
            }

            .content {
                padding: 30px 20px;
            }

            .otp {
                font-size: 32px;
                letter-spacing: 6px;
            }

            .footer {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <div class="logo">💬</div>
                <h1>Code d'authentification</h1>
                <p>Sécurisez votre accès à Chat</p>
            </div>

            <!-- Content -->
            <div class="content">
                <p class="greeting">
                    Bonjour <strong>{{ $username }}</strong>,
                </p>

                <p class="message">
                    Nous avons reçu une demande de connexion à votre compte. Pour des raisons de sécurité, veuillez
                    utiliser le code ci-dessous pour vous authentifier.
                </p>

                <!-- OTP Box -->
                <div class="otp-container">
                    <div class="otp-icon">🔐</div>
                    <div class="otp-label">Votre code de vérification</div>
                    <div class="otp">{{ $code }}</div>
                </div>

                <!-- Warning Box -->
                <div class="warning-box">
                    <p>⏱️ Ce code expire dans <strong>10 minutes</strong>. Utilisez-le rapidement pour continuer.</p>
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <p>
                        ℹ️ Si vous n'avez pas demandé ce code, ignorez cet email ou contactez notre support
                        immédiatement.
                    </p>
                </div>

                <div class="divider"></div>

                <p class="message" style="text-align: center; color: #95a5a6; font-size: 13px;">
                    Besoin d'aide ? Notre équipe est là pour vous assister.
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="footer-logo">💬 Chat Application</div>
                <p class="footer-text">
                    Votre plateforme de messagerie sécurisée
                </p>
                <p class="footer-text">
                    &copy; {{ date('Y') }} Chat - Tous droits réservés
                </p>
                <div class="footer-links">
                    <a href="#">Politique de confidentialité</a>
                    <a href="#">Conditions d'utilisation</a>
                    <a href="#">Support</a>
                </div>

                <div class="social-icons">
                    <span>📱</span>
                    <span>🌐</span>
                    <span>📧</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
