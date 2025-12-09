<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ImpactGuru CRM | Professional Customer Management</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .hero-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .content-wrapper {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 3rem;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            letter-spacing: 1px;
        }

        nav {
            display: flex;
            gap: 1.5rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        nav a:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .hero-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            max-width: 1200px;
            width: 100%;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 900;
            color: white;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-content p {
            font-size: 1.125rem;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .cta-button {
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .cta-primary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(245, 87, 108, 0.3);
        }

        .cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(245, 87, 108, 0.4);
        }

        .cta-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 2px solid white;
        }

        .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
        }

        .hero-image {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-wrapper {
            width: 100%;
            max-width: 500px;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%);
            border-radius: 1rem;
            padding: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .image-wrapper img {
            width: 100%;
            height: auto;
            border-radius: 0.5rem;
            display: block;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 0.5rem;
            border-left: 4px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
        }

        .feature-item strong {
            color: white;
            display: block;
            margin-bottom: 0.5rem;
        }

        .feature-item p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.85);
        }

        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }

            header {
                padding: 1rem 1.5rem;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .cta-button {
                width: 100%;
            }

            .features {
                grid-template-columns: 1fr;
            }

            main {
                padding: 2rem 1rem;
            }
        }
    </style>
</head>
<body class="antialiased">
    <div class="hero-bg">
        <div class="content-wrapper">
            <header>
                <div class="logo">🚀 ImpactGuru CRM</div>
                @if (Route::has('login'))
                    <nav>
                        @auth
                            <a href="{{ url('/dashboard') }}">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main>
                <div class="hero-container">
                    <div class="hero-content">
                        <h1>Manage Your Business Effortlessly</h1>
                        <p>
                            ImpactGuru CRM is your comprehensive solution for customer relationship management. 
                            Track orders, manage customers, generate real-time reports, and export data with ease. 
                            Designed for modern businesses that value efficiency and growth.
                        </p>

                        <div class="cta-buttons">
                            <a href="{{ route('login') }}" class="cta-button cta-primary">Get Started Now</a>
                        </div>

                        <div class="features">
                            <div class="feature-item">
                                <strong>📊 Real-Time Analytics</strong>
                                <p>Track customer metrics and order statistics instantly</p>
                            </div>
                            <div class="feature-item">
                                <strong>👥 Customer Management</strong>
                                <p>Organize and manage customer data efficiently</p>
                            </div>
                            <div class="feature-item">
                                <strong>📦 Order Tracking</strong>
                                <p>Monitor order status and details seamlessly</p>
                            </div>
                        </div>
                    </div>

                    <div class="hero-image">
                        <div class="image-wrapper">
                            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" style="filter: drop-shadow(0 10px 30px rgba(0,0,0,0.2));">
                                <!-- Professional Dashboard Illustration -->
                                <defs>
                                    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:rgba(255,255,255,0.8);stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:rgba(255,255,255,0.3);stop-opacity:1" />
                                    </linearGradient>
                                </defs>
                                <!-- Monitor Frame -->
                                <rect x="30" y="40" width="340" height="240" rx="12" fill="url(#grad1)" stroke="rgba(255,255,255,0.5)" stroke-width="2"/>
                                <!-- Screen -->
                                <rect x="50" y="60" width="300" height="200" rx="8" fill="rgba(255,255,255,0.95)"/>
                                <!-- Dashboard Elements -->
                                <rect x="70" y="80" width="80" height="50" rx="4" fill="#667eea" opacity="0.8"/>
                                <rect x="170" y="80" width="80" height="50" rx="4" fill="#764ba2" opacity="0.8"/>
                                <rect x="270" y="80" width="50" height="50" rx="4" fill="#f5576c" opacity="0.8"/>
                                <!-- Chart -->
                                <line x1="70" y1="170" x2="75" y2="140" stroke="#667eea" stroke-width="3"/>
                                <line x1="85" y1="170" x2="90" y2="120" stroke="#764ba2" stroke-width="3"/>
                                <line x1="100" y1="170" x2="105" y2="100" stroke="#f5576c" stroke-width="3"/>
                                <line x1="115" y1="170" x2="120" y2="130" stroke="#667eea" stroke-width="3"/>
                                <!-- Monitor Stand -->
                                <rect x="140" y="300" width="120" height="60" rx="4" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.5)" stroke-width="2"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>