<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NNG Crypto Swap - Peer-to-Peer Exchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6a11cb;
            --secondary: #2575fc;
            --accent: #00c6ff;
            --success: #17ae79;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --gradient: linear-gradient(135deg, var(--primary), var(--secondary));
        }
        
        body {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: var(--light);
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .app-container {
            background: rgba(26, 26, 46, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 1200px;
            margin: 2rem auto;
        }
        
        .header {
            background: var(--gradient);
            padding: 1.5rem;
            position: relative;
        }
        
        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .tagline {
            color: rgba(255, 255, 255, 0.85);
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }
        
        .balance-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .balance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .balance-value {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0.5rem 0;
        }
        
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .action-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            color: white;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .action-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .action-btn i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .btn-primary-custom {
            background: var(--gradient);
            border: none;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.4);
        }
        
        .features-section {
            padding: 2rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            margin: 2rem 0;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            background: rgba(37, 117, 252, 0.1);
        }
        
        .modal-content {
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 10px;
            padding: 0.8rem 1rem;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            border-color: var(--accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 198, 255, 0.25);
        }
        
        .currency-select {
            background: rgba(37, 117, 252, 0.2);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.5rem;
        }
        
        .crypto-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            font-size: 1.2rem;
            margin-right: 10px;
        }
        
        .exchange-arrow {
            background: var(--gradient);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1rem auto;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .exchange-arrow:hover {
            transform: rotate(180deg);
        }
        
        .footer {
            padding: 2rem;
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        
        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 10% 20%, rgba(106, 17, 203, 0.2) 0%, transparent 40%), 
                        radial-gradient(circle at 90% 80%, rgba(37, 117, 252, 0.2) 0%, transparent 40%);
            z-index: -1;
            animation: moveBackground 20s infinite alternate;
        }
        
        @keyframes moveBackground {
            0% { background-position: 10% 20%, 90% 80%; }
            100% { background-position: 20% 30%, 80% 70%; }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .stats-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin: 1rem 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .stats-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent);
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
    
    <div class="container py-4">
        <div class="app-container">
            <!-- Header -->
            <div class="header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="logo">
                            <i class="fas fa-exchange-alt"></i>
                            <span>NNG Crypto Swap</span>
                        </div>
                        <p class="tagline">Swap your money into crypto and vice versa with less slippage and instant execution. Easily deposit into bank or e-wallet.</p>
                    </div>
                    <div>
                        <button class="btn btn-outline-light rounded-pill">
                            <i class="fas fa-user me-2"></i>Account
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="p-4">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Balance Card -->
                        <div class="balance-card floating">
                            <h5>Your Total Balance</h5>
                            <div class="balance-value">$12,458.75</div>
                            <div class="d-flex mt-3">
                                <div class="me-3">
                                    <small class="text-muted">Crypto Value</small>
                                    <div>$8,240.50</div>
                                </div>
                                <div>
                                    <small class="text-muted">Fiat Value</small>
                                    <div>$4,218.25</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Grid -->
                        <h4 class="mt-4 mb-3">Quick Actions</h4>
                        <div class="action-grid">
                            <div class="action-btn" data-bs-toggle="modal" data-bs-target="#swapModal">
                                <i class="fas fa-exchange-alt"></i>
                                <h5>Swap</h5>
                                <p class="small">Exchange crypto/fiat instantly</p>
                            </div>
                            <div class="action-btn" data-bs-toggle="modal" data-bs-target="#depositModal">
                                <i class="fas fa-wallet"></i>
                                <h5>Deposit</h5>
                                <p class="small">Add funds to your account</p>
                            </div>
                            <div class="action-btn" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                <i class="fas fa-money-bill-wave"></i>
                                <h5>Withdraw</h5>
                                <p class="small">Cash out to bank/e-wallet</p>
                            </div>
                            <div class="action-btn" data-bs-toggle="modal" data-bs-target="#historyModal">
                                <i class="fas fa-history"></i>
                                <h5>History</h5>
                                <p class="small">View transaction history</p>
                            </div>
                        </div>
                        
                        <!-- Stats Section -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <i class="fas fa-bolt text-warning mb-2"></i>
                                    <div>Swap Speed</div>
                                    <div class="stats-value">&lt; 30s</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <i class="fas fa-percentage text-info mb-2"></i>
                                    <div>Slippage</div>
                                    <div class="stats-value">0.15%</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stats-card">
                                    <i class="fas fa-users text-success mb-2"></i>
                                    <div>Active Users</div>
                                    <div class="stats-value">24.5K</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <!-- Features Section -->
                        <div class="features-section">
                            <h4 class="mb-4">Why Choose NNG Crypto Swap?</h4>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="feature-card">
                                        <i class="fas fa-shield-alt fa-2x text-success mb-3"></i>
                                        <h5>Secure Transactions</h5>
                                        <p class="small">Military-grade encryption protects all your transactions and data</p>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="feature-card">
                                        <i class="fas fa-rocket fa-2x text-primary mb-3"></i>
                                        <h5>Instant Execution</h5>
                                        <p class="small">Peer-to-peer matching for near-instant swaps</p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="feature-card">
                                        <i class="fas fa-globe-americas fa-2x text-info mb-3"></i>
                                        <h5>Global Access</h5>
                                        <p class="small">Available in 100+ countries with multiple currency support</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Support -->
                        <div class="text-center mt-4 p-3 rounded" style="background: rgba(0, 198, 255, 0.1); border: 1px solid rgba(0, 198, 255, 0.2);">
                            <h5>Need Help?</h5>
                            <p>Our support team is available 24/7</p>
                            <button class="btn btn-primary-custom">
                                <i class="fas fa-headset me-2"></i>Live Chat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h5>NNG Crypto Swap</h5>
                        <p class="small">Peer-to-peer crypto exchange with minimal fees and maximum security.</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-light">About Us</a></li>
                            <li><a href="#" class="text-light">Fees</a></li>
                            <li><a href="#" class="text-light">Blog</a></li>
                            <li><a href="#" class="text-light">API</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Connect With Us</h5>
                        <div class="d-flex gap-3 mt-3 justify-content-center">
                            <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-light"><i class="fab fa-telegram fa-lg"></i></a>
                            <a href="#" class="text-light"><i class="fab fa-discord fa-lg"></i></a>
                            <a href="#" class="text-light"><i class="fab fa-medium fa-lg"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="my-4 bg-light">
                <p class="mb-0 small">&copy; 2023 NNG Crypto Swap. All rights reserved.</p>
            </div>
        </div>
    </div>
    
    <!-- Swap Modal -->
    <div class="modal fade" id="swapModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exchange-alt me-2"></i>Swap Assets</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">From</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="1.0">
                                    <select class="currency-select">
                                        <option>BTC</option>
                                        <option>ETH</option>
                                        <option>USDT</option>
                                        <option>USD</option>
                                        <option>EUR</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="crypto-icon">
                                    <i class="fab fa-bitcoin"></i>
                                </div>
                                <div>
                                    <div>Bitcoin</div>
                                    <small class="text-muted">Balance: 0.85 BTC</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <div class="exchange-arrow">
                                <i class="fas fa-exchange-alt text-white"></i>
                            </div>
                        </div>
                        
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label class="form-label">To</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="29370.25">
                                    <select class="currency-select">
                                        <option>USD</option>
                                        <option>EUR</option>
                                        <option>BTC</option>
                                        <option>ETH</option>
                                        <option>USDT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="crypto-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                                <div>
                                    <div>US Dollar</div>
                                    <small class="text-muted">Balance: $4,218.25</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 rounded" style="background: rgba(255, 255, 255, 0.05);">
                        <div class="d-flex justify-content-between">
                            <span>Exchange Rate:</span>
                            <span>1 BTC = $29,370.25</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Estimated Fee:</span>
                            <span>$8.81 (0.03%)</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Estimated Time:</span>
                            <span>15-30 seconds</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom">Confirm Swap</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Deposit Modal -->
    <div class="modal fade" id="depositModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-wallet me-2"></i>Deposit Funds</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" placeholder="Enter amount">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-light flex-grow-1">
                                <i class="fas fa-university me-2"></i>Bank
                            </button>
                            <button class="btn btn-outline-light flex-grow-1">
                                <i class="fab fa-paypal me-2"></i>PayPal
                            </button>
                            <button class="btn btn-outline-light flex-grow-1">
                                <i class="fab fa-cc-stripe me-2"></i>Card
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Destination Wallet</label>
                        <select class="form-select">
                            <option>Bitcoin (BTC) Wallet</option>
                            <option>Ethereum (ETH) Wallet</option>
                            <option>USDT Wallet</option>
                            <option>USD Fiat Wallet</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-info">
                        <small><i class="fas fa-info-circle me-2"></i>Deposits are processed within 1-3 business days. Crypto deposits may take up to 30 minutes for network confirmation.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom">Initiate Deposit</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Withdraw Modal -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-money-bill-wave me-2"></i>Withdraw Funds</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" placeholder="Enter amount">
                        </div>
                        <small class="text-muted">Available: $4,218.25</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Withdrawal Method</label>
                        <select class="form-select">
                            <option>Bank Transfer (3-5 days)</option>
                            <option>PayPal (Instant)</option>
                            <option>Skrill (Instant)</option>
                            <option>Neteller (Instant)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Destination</label>
                        <select class="form-select">
                            <option>Bank Account ****1234</option>
                            <option>Paypal: user@example.com</option>
                            <option>Add New Method</option>
                        </select>
                    </div>
                    
                    <div class="alert alert-warning">
                        <small><i class="fas fa-exclamation-triangle me-2"></i>Withdrawals may take 3-5 business days for bank transfers. Instant methods have 1% fee.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary-custom">Request Withdrawal</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- History Modal -->
    <div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-history me-2"></i>Transaction History</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Swaps</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Deposits</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Withdrawals</a>
                        </li>
                    </ul>
                    
                    <div class="mt-3">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent text-light">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <i class="fas fa-exchange-alt text-primary me-2"></i>
                                        <span>Swap: 0.5 ETH to USDT</span>
                                    </div>
                                    <small>2 hours ago</small>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small>Completed</small>
                                    <span class="text-success">+$850.50</span>
                                </div>
                            </a>
                            
                            <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent text-light">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <i class="fas fa-wallet text-info me-2"></i>
                                        <span>Deposit: Bank Transfer</span>
                                    </div>
                                    <small>1 day ago</small>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small>Processing</small>
                                    <span class="text-success">+$1,200.00</span>
                                </div>
                            </a>
                            
                            <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent text-light">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <i class="fas fa-money-bill-wave text-warning me-2"></i>
                                        <span>Withdrawal: PayPal</span>
                                    </div>
                                    <small>3 days ago</small>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small>Completed</small>
                                    <span class="text-danger">-$500.00</span>
                                </div>
                            </a>
                            
                            <a href="#" class="list-group-item list-group-item-action border-0 bg-transparent text-light">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <i class="fas fa-exchange-alt text-primary me-2"></i>
                                        <span>Swap: $1,000 to BTC</span>
                                    </div>
                                    <small>1 week ago</small>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small>Completed</small>
                                    <span class="text-success">+0.034 BTC</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary-custom">Export History</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple animation for the swap arrow
        document.querySelector('.exchange-arrow').addEventListener('click', function() {
            this.classList.toggle('rotate');
        });
    </script>
</body>
</html>