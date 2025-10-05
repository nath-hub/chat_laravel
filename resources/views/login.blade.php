<!DOCTYPE html>
<html lang="fr">



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">


    <!-- ✅ Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optionnel : icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6a1b9a, #8e24aa);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 48px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .header-logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #eaeaec;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .btn-google {
            width: 100%;
            height: 60px;
            border-radius: 15px;
            background-color: white;
            color: #6a1b9a;
            border: 2px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .btn-google:hover {
            background-color: #f5f5f5;
            border-color: #6a1b9a;
        }

        .google-icon {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6a1b9a;
            font-size: 20px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            height: 56px;
            padding: 0 16px 0 48px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #6a1b9a;
            box-shadow: 0 0 0 3px rgba(106, 27, 154, 0.1);
        }

        .btn-submit {
            width: 100%;
            height: 60px;
            border-radius: 15px;
            background-color: #6a1b9a;
            color: white;
            border: none;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 30px;
        }

        .btn-submit:hover {
            background-color: #8e24aa;
        }

        .btn-submit:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .btn-submit.loading {
            position: relative;
            color: transparent;
        }

        .btn-submit.loading::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 3px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .alert {
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .footer-text {
            text-align: center;
            color: #666;
            font-size: 13px;
            line-height: 1.6;
        }

        .footer-text a {
            color: #6a1b9a;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .card {
                padding: 32px 24px;
            }

            h1 {
                font-size: 24px;
            }
        }

        /* Icons using CSS */
        .icon-account::before {
            content: "👤";
        }

        .icon-email::before {
            content: "✉️";
        }
    </style>
</head>

<body>
    <div class="card">
        <!-- Header -->
        <div class="header-logo">
            <img src="./logo.jpg" alt="Logo" class="logo-img" />
        </div>

        <h1>Connexion</h1>
        <p class="subtitle">Accédez à votre espace sécurisé</p>

        <!-- Google Button -->
        <button type="button" class="btn-google">
            <img src="./google-icon.png" alt="Google" class="google-icon" />
            Continuer avec Google
        </button>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div id="alert-container"></div>

        <!-- Form -->
        <form method="POST" action="{{ route('store') }}">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <span class="input-icon icon-account"></span>
                    <input type="text" id="username" name="username" placeholder="Entrer votre nom d'utilisateur" value="{{ old('username') }}" required />
                </div>
                @error('username')
                    <small style="color: #d32f2f;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <span class="input-icon icon-email"></span>
                    <input type="email" id="email" name="email" placeholder="Entrer votre email" value="{{ old('email') }}" required />
                </div>
                @error('email')
                    <small style="color: #d32f2f;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                Continuer avec email
            </button>
        </form>

        <!-- Footer -->
        <div class="footer-text">
            <p>
                En poursuivant, vous acceptez
                <a href="#">la Politique de Confidentialité</a>
                de Legal
            </p>
        </div>
    </div>

</body>

<!-- Bootstrap JS Bundle (avec Popper) -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

{{-- <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const alertContainer = document.getElementById('alert-container');
            const formData = new FormData(this);

            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            alertContainer.innerHTML = '';

            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    alertContainer.innerHTML = `
                        <div class="alert alert-success">
                            ${data.message}
                        </div>
                    `;

                    // Redirect to verify page
                    setTimeout(() => {
                        window.location.href = `/verify?email=${encodeURIComponent(formData.get('email'))}`;
                    }, 1000);
                } else {
                    alertContainer.innerHTML = `
                        <div class="alert alert-error">
                            ${data.message || 'Une erreur est survenue'}
                        </div>
                    `;
                }
            } catch (error) {
                alertContainer.innerHTML = `
                    <div class="alert alert-error">
                        Erreur réseau ou serveur injoignable
                    </div>
                `;
            } finally {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        });
    </script> --}}

</html>
