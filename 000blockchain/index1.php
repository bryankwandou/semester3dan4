<?php
// Ramps Normies - Seamless FIAT On & Off Ramps
// PHP Template

// Configuration
$site_name = "Ramps Normies";
$site_tagline = "Seamless FIAT On & Off Ramps";
$site_description = "With Ramps Normies, seamlessly transfer funds between bank accounts and crypto wallets. Discover the ease of crypto transactions with us.";

// Navigation items
$nav_items = [
    ['name' => 'Home', 'url' => '#home'],
    ['name' => 'About', 'url' => '#about'],
    ['name' => 'How It Works', 'url' => '#how-it-works'],
    ['name' => 'Features', 'url' => '#features'],
    ['name' => 'Contact', 'url' => '#contact']
];

// Features data
$features = [
    [
        'icon' => '🏦',
        'title' => 'Bank Integration',
        'description' => 'Connect your Indonesian bank account for seamless transfers'
    ],
    [
        'icon' => '💰',
        'title' => 'Crypto Wallet Support',
        'description' => 'Support for major crypto wallets and digital assets'
    ],
    [
        'icon' => '🔒',
        'title' => 'Secure Transactions',
        'description' => 'Bank-level security for all your crypto transactions'
    ],
    [
        'icon' => '⚡',
        'title' => 'Fast Processing',
        'description' => 'Quick on-ramp and off-ramp processing times'
    ]
];

// How it works steps
$steps = [
    [
        'step' => '1',
        'title' => 'Connect Wallet',
        'description' => 'Connect your crypto wallet to our secure platform'
    ],
    [
        'step' => '2',
        'title' => 'Link Bank Account',
        'description' => 'Securely link your Indonesian bank account'
    ],
    [
        'step' => '3',
        'title' => 'Transfer Funds',
        'description' => 'Seamlessly transfer between FIAT and crypto'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> | <?php echo $site_tagline; ?></title>
    <meta name="description" content="<?php echo $site_description; ?>">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-menu a:hover {
            color: #667eea;
        }

        .cta-button {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        /* Hero Section */
        .hero {
            padding: 120px 0 80px;
            text-align: center;
            color: white;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn-primary {
            background: white;
            color: #667eea;
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            background: white;
            color: #667eea;
        }

        /* Main Content */
        .main-content {
            background: white;
            margin-top: -50px;
            border-radius: 30px 30px 0 0;
            position: relative;
            z-index: 1;
        }

        .section {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }

        /* Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: #f8f9ff;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        /* How It Works */
        .steps-container {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            margin-top: 3rem;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1rem;
        }

        .step-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .step-description {
            color: #666;
        }

        /* Footer */
        footer {
            background: #1a1a1a;
            color: white;
            padding: 3rem 0;
            text-align: center;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: #667eea;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #667eea;
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 2rem;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .steps-container {
                flex-direction: column;
            }

            .container {
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo"><?php echo $site_name; ?></div>
            <ul class="nav-menu">
                <?php foreach ($nav_items as $item): ?>
                    <li><a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
            <a href="#connect" class="cta-button">Connect Wallet</a>
        </nav>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="container">
                <h1><?php echo $site_name; ?></h1>
                <p><?php echo $site_description; ?></p>
                <div class="hero-buttons">
                    <button class="btn-primary">Get Started</button>
                    <button class="btn-secondary">Learn More</button>
                </div>
            </div>
        </section>

        <div class="main-content">
            <section class="section" id="features">
                <div class="container">
                    <h2 class="section-title">Why Choose Ramps Normies?</h2>
                    <div class="features-grid">
                        <?php foreach ($features as $feature): ?>
                            <div class="feature-card">
                                <div class="feature-icon"><?php echo $feature['icon']; ?></div>
                                <h3 class="feature-title"><?php echo $feature['title']; ?></h3>
                                <p class="feature-description"><?php echo $feature['description']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="section" id="how-it-works">
                <div class="container">
                    <h2 class="section-title">How It Works</h2>
                    <div class="steps-container">
                        <?php foreach ($steps as $step): ?>
                            <div class="step">
                                <div class="step-number"><?php echo $step['step']; ?></div>
                                <h3 class="step-title"><?php echo $step['title']; ?></h3>
                                <p class="step-description"><?php echo $step['description']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section class="section" id="about">
                <div class="container">
                    <h2 class="section-title">About Ramps Normies</h2>
                    <p style="text-align: center; max-width: 800px; margin: 0 auto; font-size: 1.1rem; color: #666;">
                        Ramps Normies is Indonesia's premier FIAT on & off ramp platform, designed to make crypto 
                        transactions accessible and seamless for everyone. We bridge the gap between traditional 
                        banking and the crypto world, enabling you to effortlessly move funds between your bank 
                        account and crypto wallet.
                    </p>
                </div>
            </section>
        </div>
    </main>

    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Ramps Normies</h3>
                    <p>Making crypto accessible for everyone in Indonesia.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Support</h3>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Contact Support</a></li>
                        <li><a href="#">Community</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Compliance</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Ramps Normies. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>