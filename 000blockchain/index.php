<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NNG Crypto Swap - Automatic P2P Exchange</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #00d4ff;
            --secondary-color: #ff6b35;
            --accent-color: #6c5ce7;
            --dark-bg: #0a0e27;
            --card-bg: #1a1f3a;
            --text-light: #e2e8f0;
            --text-muted: #94a3b8;
            --gradient-primary: linear-gradient(135deg, #00d4ff, #6c5ce7);
            --gradient-secondary: linear-gradient(135deg, #ff6b35, #ff3e8a);
            --shadow: 0 20px 40px rgba(0, 212, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .bg-animated {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: var(--dark-bg);
        }

        .bg-animated::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(108, 92, 231, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(255, 107, 53, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .navbar {
            background: rgba(26, 31, 58, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: var(--text-light) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(0, 212, 255, 0.2);
        }

        .btn-secondary {
            background: var(--gradient-secondary);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px rgba(255, 107, 53, 0.2);
        }

        .hero-section {
            padding: 8rem 0 4rem;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--text-muted);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .swap-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            margin-top: 2rem;
        }

        .currency-selector {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .currency-selector:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
        }

        .currency-input {
            background: transparent;
            border: none;
            color: var(--text-light);
            font-size: 1.5rem;
            font-weight: 600;
            width: 100%;
            outline: none;
        }

        .currency-input::placeholder {
            color: var(--text-muted);
        }

        .currency-button {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .currency-button:hover {
            transform: scale(1.05);
        }

        .swap-button {
            background: var(--card-bg);
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1rem auto;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .swap-button:hover {
            background: var(--primary-color);
            color: white;
            transform: rotate(180deg);
        }

        .features {
            padding: 4rem 0;
        }

        .feature-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow);
        }

        .feature-icon {
            font-size: 3rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .modal-content {
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-title {
            color: var(--text-light);
        }

        .btn-close {
            filter: invert(1);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            border-radius: 12px;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            color: var(--text-light);
            box-shadow: 0 0 0 0.2rem rgba(0, 212, 255, 0.25);
        }

        .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            border-radius: 12px;
        }

        .form-select:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            color: var(--text-light);
            box-shadow: 0 0 0 0.2rem rgba(0, 212, 255, 0.25);
        }

        .stats-section {
            padding: 2rem 0;
            background: rgba(255, 255, 255, 0.02);
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .swap-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animated"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-exchange-alt me-2"></i>NNG Crypto</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#supportModal">Support</a>
                    </li>
                    <li class="nav-item ms-3">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#walletModal">
                            <i class="fas fa-wallet me-2"></i><span id="walletButtonText">Connect Wallet</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Demo Content -->
    <div class="demo-content">
        <div class="container">
            <h1>NNG Crypto Platform</h1>
            <p>Test the navbar features above - try the Support modal and Wallet connection!</p>
        </div>
    </div>

    <!-- Support Modal -->
    <div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supportModalLabel">
                        <i class="fas fa-headset me-2"></i>Customer Support
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-envelope me-2 text-primary"></i>Email Support</h6>
                            <p>Get help via email within 24 hours</p>
                            <a href="mailto:support@nngcrypto.com" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-paper-plane me-2"></i>Send Email
                            </a>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-comments me-2 text-success"></i>Live Chat</h6>
                            <p>Chat with our support team instantly</p>
                            <button class="btn btn-outline-success btn-sm" onclick="startLiveChat()">
                                <i class="fas fa-comment-dots me-2"></i>Start Chat
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-book me-2 text-info"></i>Documentation</h6>
                            <p>Find answers in our comprehensive guides</p>
                            <button class="btn btn-outline-info btn-sm" onclick="openDocs()">
                                <i class="fas fa-book-open me-2"></i>View Docs
                            </button>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-question-circle me-2 text-warning"></i>FAQ</h6>
                            <p>Check our frequently asked questions</p>
                            <button class="btn btn-outline-warning btn-sm" onclick="openFAQ()">
                                <i class="fas fa-list me-2"></i>View FAQ
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wallet Modal -->
    <div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="walletModalLabel">
                        <i class="fas fa-wallet me-2"></i>Connect Your Wallet
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="connectionStatus" class="connection-status"></div>
                    
                    <p class="text-muted mb-4">Choose your preferred wallet to connect:</p>
                    
                    <div class="wallet-option" onclick="connectWallet('metamask')">
                        <div class="d-flex align-items-center">
                            <i class="fab fa-ethereum wallet-icon"></i>
                            <div>
                                <h6 class="mb-1">MetaMask</h6>
                                <small class="text-muted">Connect using MetaMask wallet</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="wallet-option" onclick="connectWallet('walletconnect')">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-link wallet-icon"></i>
                            <div>
                                <h6 class="mb-1">WalletConnect</h6>
                                <small class="text-muted">Connect using WalletConnect protocol</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="wallet-option" onclick="connectWallet('coinbase')">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-coins wallet-icon"></i>
                            <div>
                                <h6 class="mb-1">Coinbase Wallet</h6>
                                <small class="text-muted">Connect using Coinbase Wallet</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="wallet-option" onclick="connectWallet('trust')">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt wallet-icon"></i>
                            <div>
                                <h6 class="mb-1">Trust Wallet</h6>
                                <small class="text-muted">Connect using Trust Wallet</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-lock me-1"></i>
                            Your wallet connection is secure and encrypted
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Wallet connection functionality
        function connectWallet(walletType) {
            const statusDiv = document.getElementById('connectionStatus');
            const buttonText = document.getElementById('walletButtonText');
            
            // Show loading state
            statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Connecting to ' + walletType + '...';
            statusDiv.className = 'connection-status';
            statusDiv.style.display = 'block';
            
            // Simulate connection process
            setTimeout(() => {
                const isSuccess = Math.random() > 0.3; // 70% success rate for demo
                
                if (isSuccess) {
                    statusDiv.innerHTML = '<i class="fas fa-check-circle me-2"></i>Successfully connected to ' + walletType + '!';
                    statusDiv.className = 'connection-status success';
                    
                    // Update button text
                    buttonText.innerHTML = '<i class="fas fa-check me-2"></i>Connected';
                    
                    // Close modal after 2 seconds
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('walletModal'));
                        modal.hide();
                    }, 2000);
                } else {
                    statusDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Failed to connect. Please try again.';
                    statusDiv.className = 'connection-status error';
                }
            }, 2000);
        }

        // Support functions
        function startLiveChat() {
            alert('Live chat feature would integrate with your customer support system here!');
        }

        function openDocs() {
            alert('Documentation would open here - integrate with your docs system!');
        }

        function openFAQ() {
            alert('FAQ page would open here - integrate with your FAQ system!');
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                if (this.getAttribute('href').startsWith('#') && this.getAttribute('href') !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Auto-collapse navbar on mobile when clicking links
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    const navbarToggler = document.querySelector('.navbar-toggler');
                    navbarToggler.click();
                }
            });
        });
    </script>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">NNG Crypto Swap</h1>
                    <p class="hero-subtitle">
                        Automatic peer-to-peer cryptocurrency exchange. Swap your money into crypto and vice versa with minimal slippage and instant execution. Easily deposit into bank or e-wallet.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">$2.5M</div>
                        <div class="stat-label">Total Volume</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">15K+</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">0.1%</div>
                        <div class="stat-label">Avg Slippage</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">< 30s</div>
                        <div class="stat-label">Execution Time</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Swap Interface -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="swap-card">
                        <div class="text-center mb-4">
                            <h3 class="mb-2">Instant Crypto Swap</h3>
                            <p class="text-muted mb-0">Trade with best rates and minimal fees</p>
                        </div>

                        <!-- From Currency -->
                        <div class="currency-selector">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">From</span>
                                <span class="text-muted">Balance: 0.00</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <input type="number" class="currency-input" placeholder="0.00">
                                <button class="currency-button" data-bs-toggle="modal" data-bs-target="#currencyModal" data-type="from">
                                    <i class="flag flag-id me-2"></i>IDR <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Swap Button -->
                        <div class="swap-button" onclick="swapCurrencies()">
                            <i class="fas fa-arrow-up-down"></i>
                        </div>

                        <!-- To Currency -->
                        <div class="currency-selector">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">To</span>
                                <span class="text-muted">Balance: 0.00</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <input type="number" class="currency-input" placeholder="0.00">
                                <button class="currency-button" data-bs-toggle="modal" data-bs-target="#currencyModal" data-type="to">
                                    <i class="fab fa-bitcoin me-2"></i>BTC <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Exchange Rate -->
                        <div class="text-center my-3">
                            <small class="text-muted">1 BTC = 1,420,000,000 IDR</small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#swapModal">
                                <i class="fas fa-exchange-alt me-2"></i>Swap Now
                            </button>
                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#depositModal">
                                        <i class="fas fa-plus me-2"></i>Deposit
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                        <i class="fas fa-minus me-2"></i>Withdraw
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="mb-4">Why Choose NNG Crypto?</h2>
                    <p class="text-muted">Experience the future of cryptocurrency trading with our advanced P2P platform</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4 class="mb-3">Lightning Fast</h4>
                        <p class="text-muted">Execute trades in under 30 seconds with our optimized matching engine</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="mb-3">Secure Trading</h4>
                        <p class="text-muted">Bank-grade security with multi-signature wallets and cold storage</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="mb-3">Best Rates</h4>
                        <p class="text-muted">Minimal slippage and competitive rates across all trading pairs</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Currency Selection Modal -->
    <div class="modal fade" id="currencyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Currency</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Search currency...">
                    </div>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="fab fa-bitcoin me-2"></i>Bitcoin (BTC)
                        </a>
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="fab fa-ethereum me-2"></i>Ethereum (ETH)
                        </a>
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="fas fa-dollar-sign me-2"></i>USD Tether (USDT)
                        </a>
                        <a href="#" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="flag flag-id me-2"></i>Indonesian Rupiah (IDR)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Swap Confirmation Modal -->
    <div class="modal fade" id="swapModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Swap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <h4>0.001 BTC → 1,420,000 IDR</h4>
                        <p class="text-muted">Exchange Rate: 1 BTC = 1,420,000,000 IDR</p>
                    </div>
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Network Fee:</span>
                            <span>0.0001 BTC</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Platform Fee:</span>
                            <span>0.1%</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>You'll receive:</span>
                            <span>1,418,580 IDR</span>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-lg">Confirm Swap</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deposit Modal -->
    <div class="modal fade" id="depositModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deposit Funds</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Currency</label>
                        <select class="form-select">
                            <option>Bitcoin (BTC)</option>
                            <option>Ethereum (ETH)</option>
                            <option>USD Tether (USDT)</option>
                            <option>Indonesian Rupiah (IDR)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deposit Method</label>
                        <select class="form-select">
                            <option>Bank Transfer</option>
                            <option>E-Wallet (OVO, GoPay, Dana)</option>
                            <option>Crypto Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" placeholder="Enter amount">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">Continue Deposit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdraw Modal -->
    <div class="modal fade" id="withdrawModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Withdraw Funds</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Currency</label>
                        <select class="form-select">
                            <option>Bitcoin (BTC)</option>
                            <option>Ethereum (ETH)</option>
                            <option>USD Tether (USDT)</option>
                            <option>Indonesian Rupiah (IDR)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Withdraw To</label>
                        <select class="form-select">
                            <option>Bank Account</option>
                            <option>E-Wallet (OVO, GoPay, Dana)</option>
                            <option>External Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" placeholder="Enter amount">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Destination Address/Account</label>
                        <input type="text" class="form-control" placeholder="Enter destination">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-secondary">Continue Withdrawal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wallet Connection Modal -->
    <div class="modal fade" id="walletModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Connect Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-3">
                        <button class="btn btn-outline-primary d-flex align-items-center">
                            <i class="fab fa-chrome me-3"></i>
                            <div class="text-start">
                                <div>MetaMask</div>
                                <small class="text-muted">Connect using MetaMask wallet</small>
                            </div>
                        </button>
                        <button class="btn btn-outline-primary d-flex align-items-center">
                            <i class="fas fa-wallet me-3"></i>
                            <div class="text-start">
                                <div>WalletConnect</div>
                                <small class="text-muted">Connect using WalletConnect</small>
                            </div>
                        </button>
                        <button class="btn btn-outline-primary d-flex align-items-center">
                            <i class="fas fa-mobile-alt me-3"></i>
                            <div class="text-start">
                                <div>Trust Wallet</div>
                                <small class="text-muted">Connect using Trust Wallet</small>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Modal -->
    <div class="modal fade" id="supportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Support Center</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-3">
                        <a href="#" class="btn btn-outline-primary text-start">
                            <i class="fas fa-question-circle me-3"></i>
                            <div>
                                <div>FAQ</div>
                                <small class="text-muted">Find answers to common questions</small>
                            </div>
                        </a>
                        <a href="#" class="btn btn-outline-primary text-start">
                            <i class="fas fa-comments me-3"></i>
                            <div>
                                <div>Live Chat</div>
                                <small class="text-muted">Chat with our support team</small>
                            </div>
                        </a>
                        <a href="#" class="btn btn-outline-primary text-start">
                            <i class="fas fa-envelope me-3"></i>
                            <div>
                                <div>Email Support</div>
                                <small class="text-muted">Send us an email</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function swapCurrencies() {
            // Add swap animation logic here
            console.log('Swapping currencies...');
        }

        // Handle currency selection
        document.querySelectorAll('.currency-button').forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                console.log('Selecting currency for:', type);
            });
        });

        // Handle currency modal selections
        document.querySelectorAll('#currencyModal .list-group-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const currency = this.textContent.trim();
                console.log('Selected currency:', currency);
                
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('currencyModal'));
                modal.hide();
            });
        });

        // Handle wallet connections
        document.querySelectorAll('#walletModal .btn').forEach(button => {
            button.addEventListener('click', function() {
                const walletType = this.querySelector('div div').textContent;
                console.log('Connecting to:', walletType);
                
                // Simulate connection process
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Connecting...';
                
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('walletModal'));
                    modal.hide();
                    
                    // Update navbar button
                    const connectBtn = document.querySelector('button[data-bs-target="#walletModal"]');
                    connectBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Connected';
                    connectBtn.classList.remove('btn-primary');
                    connectBtn.classList.add('btn-success');
                }, 2000);
            });
        });

        // Handle swap confirmation
        document.querySelector('#swapModal .btn-primary').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('swapModal'));
                modal.hide();
                
                // Show success message
                alert('Swap completed successfully!');
                this.innerHTML = 'Confirm Swap';
            }, 3000);
        });

        // Handle deposit
        document.querySelector('#depositModal .btn-primary').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('depositModal'));
                modal.hide();
                
                alert('Deposit initiated successfully!');
                this.innerHTML = 'Continue Deposit';
            }, 2000);
        });

        // Handle withdrawal
        document.querySelector('#withdrawModal .btn-secondary').addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('withdrawModal'));
                modal.hide();
                
                alert('Withdrawal request submitted!');
                this.innerHTML = 'Continue Withdrawal';
            }, 2000);
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Update exchange rate periodically
        setInterval(() => {
            const rateElement = document.querySelector('.text-center small');
            if (rateElement) {
                const baseRate = 1420000000;
                const variation = Math.random() * 0.02 - 0.01; // ±1% variation
                const newRate = Math.floor(baseRate * (1 + variation));
                rateElement.textContent = `1 BTC = ${newRate.toLocaleString()} IDR`;
            }
        }, 5000);

        // Add floating particles effect
        function createParticle() {
            const particle = document.createElement('div');
            particle.style.position = 'fixed';
            particle.style.width = '4px';
            particle.style.height = '4px';
            particle.style.background = 'rgba(0, 212, 255, 0.6)';
            particle.style.borderRadius = '50%';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '1';
            particle.style.left = Math.random() * window.innerWidth + 'px';
            particle.style.top = window.innerHeight + 'px';
            particle.style.animation = 'float-up 8s linear infinite';
            
            document.body.appendChild(particle);
            
            setTimeout(() => {
                particle.remove();
            }, 8000);
        }

        // Add CSS animation for floating particles
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float-up {
                0% {
                    transform: translateY(0) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Create particles periodically
        setInterval(createParticle, 2000);

        // Add navbar background on scroll
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(26, 31, 58, 0.98)';
            } else {
                navbar.style.background = 'rgba(26, 31, 58, 0.95)';
            }
        });
    </script>
</body>
</html>