<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="{{ asset('/app.css') }}">
    <!-- ✅ Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optionnel : icônes Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


</head>

<body>
    {{-- @extends('layouts.app')

@section('content') --}}
    <div class="landing-container">
        <!-- Hero Section -->
        <div class="hero-section animated-fade-in">
            <div class="header-logo">
                <img src="{{ asset('logo.jpg') }}" alt="Logo" class="logo-img" />
            </div>
            <h1 class="page-title">Legal Chat IA</h1>
            <p class="hero-text">
                Votre assistant juridique intelligent pour toutes vos questions de droit français
            </p>
        </div>

        <!-- Feature Cards Section -->
        <div class="cards-container">
            <div class="cards-row">
                @foreach ($cards as $card)
                    <div class="card-col">
                        <div class="feature-card">
                            <div class="icon-container">
                                <i class="mdi {{ $card['icon'] }}"
                                    style="font-size: 40px; color: {{ $card['color'] }};"></i>
                            </div>
                            <h2 class="card-title">{{ $card['titre'] }}</h2>
                            <div class="card-text">{{ $card['test'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main CTA Card -->
        <div class="main-cta-wrapper">
            <div class="main-cta-card">
                <div class="cta-card-content">
                    <h2 class="cta-title">Commencez dès maintenant</h2>
                    <p class="cta-description">
                        Posez vos questions juridiques et obtenez des réponses expertes instantanément.
                        Essai gratuit pendant 1 mois, puis abonnement pour continuer.
                    </p>
                </div>
                <div class="cta-actions">
                    <div class="cta-content">

                        <a href="{{ session('user_id') ? route('home') : route('login_get') }}" class="btn-primary">
                            <i class="mdi mdi-chat-processing"></i>
                            Démarrer le chat
                        </a>

                        <div class="features-list">
                            <div class="feature-item">
                                <i class="mdi mdi-check"></i>
                                <span>1 mois gratuit</span>
                            </div>
                            <div class="feature-item">
                                <i class="mdi mdi-check"></i>
                                <span>Sans engagement</span>
                            </div>
                            <div class="feature-item">
                                <i class="mdi mdi-check"></i>
                                <span>Questions illimitées</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-container">
            <div class="stats-row">
                @foreach ($stats as $stat)
                    <div class="stat-col">
                        <div class="feature-card stat-card animated-zoom-in">
                            <h2 class="stat-number">{{ $stat['number'] }}</h2>
                            <div class="stat-text">{{ $stat['text'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .landing-container {
            background: linear-gradient(to left, var(--background-secondary), var(--background-color));
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Hero Section */
        .hero-section {
            padding: 40px 20px;
        }

        .header-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #f0f0f0f5;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .page-title {
            font-size: 2rem;
            margin: 20px 0;
            font-weight: 600;
            color: #333;
        }

        .hero-text {
            font-size: 22px;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Cards Container */
        .cards-container {
            width: 100%;
            padding: 48px 16px;
        }

        .cards-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card-col {
            flex: 0 1 calc(25% - 24px);
            min-width: 280px;
            max-width: 356px;
        }

        .feature-card {
            background: #ffffff;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
            padding: 24px;
            min-height: 200px;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
            border-color: #1976d2;
        }

        .icon-container {
            padding: 10px;
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
        }

        .card-title {
            color: #333;
            font-size: 1.25rem;
            line-height: 1.4;
            margin-bottom: 16px;
            font-weight: 500;
        }

        .card-text {
            color: #666;
            line-height: 1.5;
        }

        /* Main CTA Card */
        .main-cta-wrapper {
            width: 100%;
            max-width: 800px;
            padding: 0 16px;
            margin: 0 auto 48px;
        }

        .main-cta-card {
            background: #ffffff;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
            min-height: 300px;
        }

        .cta-card-content {
            padding: 24px 16px;
        }

        .cta-title {
            font-size: 1.5rem;
            color: #333;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .cta-description {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
        }

        .cta-actions {
            display: flex;
            justify-content: center;
            padding: 0 16px 24px;
        }

        .cta-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            width: 100%;
        }

        .btn-primary {
            width: 260px;
            height: 80px;
            border-radius: 15px;
            background-color: #1976d2;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 20px;
            text-decoration: none;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #f0f0f0;
            color: #1976d2;
        }

        .btn-primary i {
            font-size: 24px;
        }

        .features-list {
            display: flex;
            justify-content: center;
            gap: 24px;
            flex-wrap: wrap;
            width: 100%;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 14px;
        }

        .feature-item i {
            color: #1976d2;
            font-size: 20px;
        }

        /* Stats Section */
        .stats-container {
            width: 100%;
            padding: 48px 16px;
        }

        .stats-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 24px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .stat-col {
            flex: 0 1 calc(33.333% - 24px);
            min-width: 250px;
        }

        .stat-card {
            min-height: 120px;
        }

        .stat-number {
            color: #333;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .stat-text {
            color: #666;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animated-zoom-in {
            animation: zoomIn 0.5s ease-out;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .logo-img {
                width: 80px;
                height: 80px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .hero-text {
                font-size: 18px;
                padding: 0 16px;
            }

            .card-col {
                flex: 0 1 100%;
            }

            .feature-card {
                padding: 20px 16px;
                min-height: 180px;
            }

            .card-title {
                font-size: 1.1rem;
            }

            .main-cta-card {
                margin: 0 16px;
                min-height: 280px;
            }

            .cta-description {
                font-size: 14px;
                padding: 0 8px;
            }

            .btn-primary {
                width: 100%;
                max-width: 260px;
            }

            .features-list {
                gap: 16px;
            }

            .feature-item {
                font-size: 13px;
            }

            .feature-item i {
                font-size: 16px;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .stat-col {
                flex: 0 1 100%;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .hero-text {
                font-size: 20px;
            }

            .card-col {
                flex: 0 1 calc(50% - 24px);
            }

            .cta-description {
                font-size: 15px;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
</body>

<!-- Bootstrap JS Bundle (avec Popper) -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
