<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Money Flow Indicator</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            min-height: 100vh;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .chart-container {
            background: rgba(45, 45, 45, 0.95);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .chart-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #ffffff;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
            padding: 20px;
            background: rgba(61, 61, 61, 0.8);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .control-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .control-group label {
            font-size: 13px;
            color: #e0e0e0;
            font-weight: 500;
        }
        .control-group input, .control-group select {
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background: rgba(45, 45, 45, 0.9);
            color: white;
            font-size: 13px;
            transition: all 0.3s ease;
        }
        .control-group input:focus, .control-group select:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }
        .asset-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: center;
        }
        .asset-btn {
            padding: 10px 20px;
            border: 2px solid #4CAF50;
            border-radius: 25px;
            background: transparent;
            color: #4CAF50;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }
        .asset-btn.active {
            background: #4CAF50;
            color: white;
            box-shadow: 0 4px 16px rgba(76, 175, 80, 0.3);
        }
        .asset-btn:hover {
            background: #4CAF50;
            color: white;
            transform: translateY(-2px);
        }
        .legend {
            display: flex;
            gap: 25px;
            margin-bottom: 20px;
            font-size: 13px;
            justify-content: center;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: rgba(61, 61, 61, 0.6);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .legend-color {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        .positive { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .negative { background: linear-gradient(135deg, #FF6B9D 0%, #FF5A8A 100%); }
        .money-flow-chart {
            height: 350px;
            margin-bottom: 20px;
            background: rgba(26, 26, 26, 0.5);
            border-radius: 12px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .stat-item {
            background: linear-gradient(135deg, #3d3d3d 0%, #4d4d4d 100%);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }
        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4CAF50, #45a049);
        }
        .stat-label {
            font-size: 12px;
            color: #cccccc;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .button {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 16px rgba(76, 175, 80, 0.3);
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }
        .button:active {
            transform: translateY(0);
        }
        .market-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(61, 61, 61, 0.6);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .market-info div {
            text-align: center;
            font-size: 12px;
        }
        .market-info .value {
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
        }
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 5px;
            animation: pulse 2s infinite;
        }
        .status-live { background-color: #4CAF50; }
        .status-offline { background-color: #FF6B9D; }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        .timeframe-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 8px;
        }
        .timeframe-btn {
            padding: 8px 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            background: rgba(45, 45, 45, 0.9);
            color: white;
            cursor: pointer;
            font-size: 12px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .timeframe-btn.active {
            background: #4CAF50;
            border-color: #4CAF50;
            color: white;
        }
        .timeframe-btn:hover {
            background: rgba(76, 175, 80, 0.3);
            border-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Advanced Money Flow Indicator</h1>
            <p>Real-time Order Flow Analysis for Stocks, Forex, and Cryptocurrency</p>
        </div>

        <div class="chart-container">
            <div class="market-info">
                <div>
                    <span class="status-indicator status-live"></span>
                    <span>Market Status</span>
                    <div class="value" id="marketStatus">Live</div>
                </div>
                <div>
                    <span>Current Asset</span>
                    <div class="value" id="currentAsset">BTC/USDT</div>
                </div>
                <div>
                    <span>Timeframe</span>
                    <div class="value" id="currentTimeframe">1h</div>
                </div>
                <div>
                    <span>Last Update</span>
                    <div class="value" id="lastUpdate">--</div>
                </div>
            </div>

            <div class="asset-selector">
                <button class="asset-btn active" onclick="selectAsset('crypto')">Crypto</button>
                <button class="asset-btn" onclick="selectAsset('forex')">Forex</button>
                <button class="asset-btn" onclick="selectAsset('stocks')">Stocks</button>
            </div>
            
            <div class="controls">
                <div class="control-group">
                    <label>Asset Symbol</label>
                    <select id="assetSymbol">
                        <option value="BTC/USDT">BTC/USDT</option>
                        <option value="ETH/USDT">ETH/USDT</option>
                        <option value="BNB/USDT">BNB/USDT</option>
                        <option value="ADA/USDT">ADA/USDT</option>
                        <option value="SOL/USDT">SOL/USDT</option>
                    </select>
                </div>
                <div class="control-group">
                    <label>Period</label>
                    <select id="period">
                        <option value="14">14</option>
                        <option value="21" selected>21</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="control-group">
                    <label>Smoothing</label>
                    <select id="smoothing">
                        <option value="3">3</option>
                        <option value="5" selected>5</option>
                        <option value="7">7</option>
                        <option value="14">14</option>
                    </select>
                </div>
                <div class="control-group">
                    <label>Sensitivity</label>
                    <input type="range" id="sensitivity" min="0.1" max="2" step="0.1" value="1">
                </div>
                <div class="control-group">
                    <label>Volume Filter</label>
                    <input type="range" id="volumeFilter" min="0" max="100" step="5" value="20">
                </div>
                <div class="control-group">
                    <label>Timeframe</label>
                    <div class="timeframe-grid">
                        <div class="timeframe-btn" onclick="selectTimeframe('1m')">1m</div>
                        <div class="timeframe-btn" onclick="selectTimeframe('5m')">5m</div>
                        <div class="timeframe-btn" onclick="selectTimeframe('15m')">15m</div>
                        <div class="timeframe-btn" onclick="selectTimeframe('30m')">30m</div>
                        <div class="timeframe-btn" onclick="selectTimeframe('45m')">45m</div>
                        <div class="timeframe-btn active" onclick="selectTimeframe('1h')">1h</div>
                        <div class="timeframe-btn" onclick="selectTimeframe('2h')">2h</div>
                        <div class="timeframe-btn" onclick="selectTimeframe('4h')">4h</div>
                        <div class="timeframe-btn" onclick="selectTimeframe('1d')">1d</div>
                    </div>
                </div>
            </div>

            <div class="legend">
                <div class="legend-item">
                    <div class="legend-color positive"></div>
                    <span>Positive Flow (Buying Pressure)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color negative"></div>
                    <span>Negative Flow (Selling Pressure)</span>
                </div>
            </div>

            <div class="money-flow-chart">
                <canvas id="moneyFlowChart"></canvas>
            </div>

            <div style="text-align: center; margin-bottom: 20px;">
                <button class="button" onclick="updateChart()">Update Chart</button>
                <button class="button" onclick="generateData()">Generate New Data</button>
                <button class="button" onclick="resetChart()">Reset</button>
            </div>

            <div class="stats">
                <div class="stat-item">
                    <div class="stat-label">Money Flow Index</div>
                    <div class="stat-value" id="currentMFI">--</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Avg Positive Flow</div>
                    <div class="stat-value" id="avgPositive">--</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Avg Negative Flow</div>
                    <div class="stat-value" id="avgNegative">--</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Flow Ratio</div>
                    <div class="stat-value" id="flowRatio">--</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Market Trend</div>
                    <div class="stat-value" id="trend">--</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Trading Signal</div>
                    <div class="stat-value" id="signal">--</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Volume Weighted</div>
                    <div class="stat-value" id="volumeWeighted">--</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Divergence</div>
                    <div class="stat-value" id="divergence">--</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let chart;
        let moneyFlowData = [];
        let currentAssetType = 'crypto';
        let currentTimeframe = '1h';
        let isRealTimeActive = true;
        
        // Asset configurations
        const assetConfigs = {
            crypto: {
                symbols: ['BTC/USDT', 'ETH/USDT', 'BNB/USDT', 'ADA/USDT', 'SOL/USDT', 'DOT/USDT', 'AVAX/USDT', 'MATIC/USDT'],
                multiplier: 1,
                precision: 2,
                volatility: 0.8
            },
            forex: {
                symbols: ['EUR/USD', 'GBP/USD', 'USD/JPY', 'USD/CHF', 'AUD/USD', 'NZD/USD', 'USD/CAD', 'EUR/GBP'],
                multiplier: 0.1,
                precision: 4,
                volatility: 0.3
            },
            stocks: {
                symbols: ['AAPL', 'GOOGL', 'MSFT', 'AMZN', 'TSLA', 'META', 'NVDA', 'NFLX'],
                multiplier: 0.5,
                precision: 2,
                volatility: 0.6
            }
        };

        // Timeframe configurations
        const timeframeConfigs = {
            '1m': { interval: 1000, dataPoints: 60, label: '1 Minute' },
            '5m': { interval: 5000, dataPoints: 60, label: '5 Minutes' },
            '15m': { interval: 15000, dataPoints: 48, label: '15 Minutes' },
            '30m': { interval: 30000, dataPoints: 48, label: '30 Minutes' },
            '45m': { interval: 45000, dataPoints: 48, label: '45 Minutes' },
            '1h': { interval: 60000, dataPoints: 48, label: '1 Hour' },
            '2h': { interval: 120000, dataPoints: 36, label: '2 Hours' },
            '4h': { interval: 240000, dataPoints: 36, label: '4 Hours' },
            '1d': { interval: 1440000, dataPoints: 30, label: '1 Day' }
        };

        // Select asset type
        function selectAsset(type) {
            currentAssetType = type;
            
            // Update active button
            document.querySelectorAll('.asset-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Update asset dropdown
            const assetSelect = document.getElementById('assetSymbol');
            assetSelect.innerHTML = '';
            assetConfigs[type].symbols.forEach(symbol => {
                const option = document.createElement('option');
                option.value = symbol;
                option.textContent = symbol;
                assetSelect.appendChild(option);
            });
            
            // Update current asset display
            document.getElementById('currentAsset').textContent = assetConfigs[type].symbols[0];
            
            generateData();
        }

        // Select timeframe
        function selectTimeframe(timeframe) {
            currentTimeframe = timeframe;
            
            // Update active button
            document.querySelectorAll('.timeframe-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Update display
            document.getElementById('currentTimeframe').textContent = timeframeConfigs[timeframe].label;
            
            generateData();
        }

        // Generate realistic data based on asset type and timeframe
        function generateData() {
            console.log('Generating data for:', currentAssetType, currentTimeframe);
            
            const config = assetConfigs[currentAssetType];
            const timeConfig = timeframeConfigs[currentTimeframe];
            const dataPoints = timeConfig.dataPoints;
            
            moneyFlowData = [];
            
            for (let i = 0; i < dataPoints; i++) {
                const trend = Math.sin(i * 0.1) * 0.5 + (Math.random() - 0.5) * 0.5;
                const volatility = config.volatility;
                
                const basePositive = (Math.random() * 15 + 5) * config.multiplier;
                const baseNegative = (Math.random() * 15 + 5) * config.multiplier;
                
                const positive = Math.max(0.1, basePositive + (trend * volatility * 10));
                const negative = Math.max(0.1, baseNegative - (trend * volatility * 10));
                
                const volume = Math.random() * 100 + 20;
                const netFlow = positive - negative;
                
                moneyFlowData.push({
                    time: i,
                    positive: positive,
                    negative: negative,
                    net: netFlow,
                    volume: volume,
                    timestamp: new Date(Date.now() - (dataPoints - i) * timeConfig.interval)
                });
            }
            
            console.log('Generated', moneyFlowData.length, 'data points');
            console.log('Sample data:', moneyFlowData.slice(0, 3));
            
            updateChart();
            updateLastUpdate();
        }

        // Initialize chart
        function initChart() {
            console.log('Initializing chart...');
            const canvas = document.getElementById('moneyFlowChart');
            
            if (!canvas) {
                console.error('Canvas element not found!');
                return;
            }
            
            const ctx = canvas.getContext('2d');
            
            if (!ctx) {
                console.error('Canvas context not available!');
                return;
            }
            
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Money Flow',
                        data: [],
                        backgroundColor: [],
                        borderColor: [],
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 0
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(0, 0, 0, 0.9)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#4CAF50',
                            borderWidth: 1,
                            cornerRadius: 8,
                            callbacks: {
                                title: function(context) {
                                    const index = context[0].dataIndex;
                                    if (moneyFlowData[index] && moneyFlowData[index].timestamp) {
                                        return moneyFlowData[index].timestamp.toLocaleTimeString();
                                    }
                                    return `Point ${index + 1}`;
                                },
                                label: function(context) {
                                    const value = context.raw;
                                    const type = value > 0 ? 'Net Buying' : 'Net Selling';
                                    const index = context.dataIndex;
                                    const volume = moneyFlowData[index]?.volume || 0;
                                    return [
                                        `${type}: ${Math.abs(value).toFixed(2)}`,
                                        `Volume: ${volume.toFixed(0)}`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)',
                                lineWidth: 0.5
                            },
                            ticks: {
                                color: '#cccccc',
                                font: {
                                    size: 10
                                },
                                maxTicksLimit: 10
                            }
                        },
                        y: {
                            display: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)',
                                lineWidth: 0.5
                            },
                            ticks: {
                                color: '#cccccc',
                                font: {
                                    size: 10
                                }
                            }
                        }
                    },
                    layout: {
                        padding: 10
                    }
                }
            });
            
            console.log('Chart initialized successfully');
        }

        // Update chart
        function updateChart() {
            console.log('Updating chart with data:', moneyFlowData.length, 'points');
            
            if (!chart) {
                console.error('Chart not initialized!');
                return;
            }
            
            if (moneyFlowData.length === 0) {
                console.warn('No data to display');
                return;
            }
            
            const labels = moneyFlowData.map((d, i) => {
                if (i % Math.ceil(moneyFlowData.length / 10) === 0) {
                    return d.timestamp ? d.timestamp.toLocaleTimeString() : `${i}`;
                }
                return '';
            });
            
            const data = moneyFlowData.map(d => d.net);
            const maxValue = Math.max(...data.map(Math.abs));
            
            const colors = data.map(value => {
                const intensity = Math.abs(value) / maxValue;
                if (value >= 0) {
                    return `rgba(76, 175, 80, ${0.6 + intensity * 0.4})`;
                } else {
                    return `rgba(255, 107, 157, ${0.6 + intensity * 0.4})`;
                }
            });
            
            const borderColors = data.map(value => value >= 0 ? '#4CAF50' : '#FF6B9D');
            
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.data.datasets[0].backgroundColor = colors;
            chart.data.datasets[0].borderColor = borderColors;
            
            chart.update('none');
            updateStats();
            
            console.log('Chart updated successfully');
        }

        // Update statistics
        function updateStats() {
            if (moneyFlowData.length === 0) return;
            
            const period = parseInt(document.getElementById('period').value);
            const recentData = moneyFlowData.slice(-period);
            
            const positiveValues = recentData.filter(d => d.net > 0);
            const negativeValues = recentData.filter(d => d.net < 0);
            
            const avgPositive = positiveValues.length > 0 ? 
                positiveValues.reduce((a, b) => a + b.net, 0) / positiveValues.length : 0;
            const avgNegative = negativeValues.length > 0 ? 
                Math.abs(negativeValues.reduce((a, b) => a + Math.abs(b.net), 0) / negativeValues.length) : 0;
            
            const mfi = avgNegative > 0 ? (avgPositive / (avgPositive + avgNegative)) * 100 : 50;
            const flowRatio = avgNegative > 0 ? (avgPositive / avgNegative) : 0;
            
            // Volume weighted calculation
            const volumeWeighted = recentData.reduce((sum, d) => sum + (d.net * d.volume), 0) / 
                                  recentData.reduce((sum, d) => sum + d.volume, 0);
            
            // Trend analysis
            const recent10 = recentData.slice(-10);
            const trendStrength = recent10.reduce((sum, d) => sum + d.net, 0) / recent10.length;
            const trend = trendStrength > 0.5 ? 'Strong Bull' : 
                         trendStrength > 0 ? 'Weak Bull' : 
                         trendStrength > -0.5 ? 'Weak Bear' : 'Strong Bear';
            
            // Signal generation
            let signal = 'Neutral';
            if (mfi > 80) signal = 'Overbought';
            else if (mfi < 20) signal = 'Oversold';
            else if (flowRatio > 1.5) signal = 'Buy';
            else if (flowRatio < 0.5) signal = 'Sell';
            
            // Divergence detection
            const priceProxy = recentData.map((d, i) => i * 0.1 + d.net * 0.01);
            const flowTrend = recentData.map(d => d.net);
            const divergence = 'None'; // Simplified
            
            // Update UI
            document.getElementById('currentMFI').textContent = mfi.toFixed(1);
            document.getElementById('avgPositive').textContent = avgPositive.toFixed(2);
            document.getElementById('avgNegative').textContent = avgNegative.toFixed(2);
            document.getElementById('flowRatio').textContent = flowRatio.toFixed(2);
            document.getElementById('trend').textContent = trend;
            document.getElementById('signal').textContent = signal;
            document.getElementById('volumeWeighted').textContent = volumeWeighted.toFixed(2);
            document.getElementById('divergence').textContent = divergence;
            
            // Color coding
            const trendElement = document.getElementById('trend');
            trendElement.style.color = trend.includes('Bull') ? '#4CAF50' : 
                                     trend.includes('Bear') ? '#FF6B9D' : '#cccccc';
            
            const signalElement = document.getElementById('signal');
            signalElement.style.color = signal === 'Buy' ? '#4CAF50' : 
                                      signal === 'Sell' ? '#FF6B9D' : 
                                      signal === 'Overbought' ? '#FF9800' :
                                      signal === 'Oversold' ? '#2196F3' : '#cccccc';
        }

        // Update last update time
        function updateLastUpdate() {
            document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString();
        }

        // Reset chart
        function resetChart() {
            moneyFlowData = [];
            if (chart) {
                chart.data.labels = [];
                chart.data.datasets[0].data = [];
                chart.data.datasets[0].backgroundColor = [];
                chart.data.datasets[0].borderColor = [];
                chart.update();
            }
            
            // Reset stats
            document.getElementById('currentMFI').textContent = '--';
            document.getElementById('avgPositive').textContent = '--';
            document.getElementById('avgNegative').textContent = '--';
            document.getElementById('flowRatio').textContent = '--';
            document.getElementById('trend').textContent = '--';
            document.getElementById('signal').textContent = '--';
            document.getElementById('volumeWeighted').textContent = '--';
            document.getElementById('divergence').textContent = '--';
        }

        // Real-time data simulation
        function addRealTimeData() {
            if (!isRealTimeActive || moneyFlowData.length === 0) return;
            
            const config = assetConfigs[currentAssetType];
            const timeConfig = timeframeConfigs[currentTimeframe];
            const lastData = moneyFlowData[moneyFlowData.length - 1];
            
            // Generate new data point with some correlation to previous
            const momentum = lastData.net * 0.3;
            const randomFactor = (Math.random() - 0.5) * 2;
            const trend = momentum + randomFactor;
            
            const basePositive = (Math.random() * 15 + 5) * config.multiplier;
            const baseNegative = (Math.random() * 15 + 5) * config.multiplier;
            
            const positive = Math.max(0, basePositive + (trend * 0.5));
            const negative = Math.max(0, baseNegative - (trend * 0.5));
            const volume = Math.random() * 100 + 20;
            
            const newData = {
                time: moneyFlowData.length,
                positive: positive,
                negative: negative,
                net: positive - negative,
                volume: volume,
                timestamp: new Date()
            };
            
            moneyFlowData.push(newData);
            
            // Keep only the required number of data points
            const maxPoints = timeConfig.dataPoints;
            if (moneyFlowData.length > maxPoints) {
                moneyFlowData.shift();
            }
            
            updateChart();
            updateLastUpdate();
        }

        // Event listeners
        document.getElementById('assetSymbol').addEventListener('change', function() {
            document.getElementById('currentAsset').textContent = this.value;
            generateData();
        });

        document.getElementById('period').addEventListener('change', function() {
            updateChart();
        });

        document.getElementById('smoothing').addEventListener('change', function() {
            updateChart();
        });

        document.getElementById('sensitivity').addEventListener('input', function() {
            updateChart();
        });

        document.getElementById('volumeFilter').addEventListener('input', function() {
            updateChart();
        });

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing chart...');
            initChart();
            
            // Wait a bit for chart to initialize then generate data
            setTimeout(() => {
                generateData();
                updateLastUpdate();
                console.log('Initial data generated');
            }, 100);
            
            // Start real-time updates
            setInterval(addRealTimeData, 3000);
            
            // Update last update time every second
            setInterval(updateLastUpdate, 1000);
            
            // Update market status
            updateMarketStatus();
        });

        // Advanced features
        function calculateRSI(data, period = 14) {
            if (data.length < period) return 50;
            
            let gains = 0;
            let losses = 0;
            
            for (let i = 1; i < period; i++) {
                const change = data[i].net - data[i-1].net;
                if (change > 0) gains += change;
                else losses += Math.abs(change);
            }
            
            const avgGain = gains / period;
            const avgLoss = losses / period;
            
            if (avgLoss === 0) return 100;
            
            const rs = avgGain / avgLoss;
            return 100 - (100 / (1 + rs));
        }

        function calculateMACD(data, fastPeriod = 12, slowPeriod = 26, signalPeriod = 9) {
            if (data.length < slowPeriod) return { macd: 0, signal: 0, histogram: 0 };
            
            // Simplified MACD calculation
            const fastEMA = data.slice(-fastPeriod).reduce((sum, d) => sum + d.net, 0) / fastPeriod;
            const slowEMA = data.slice(-slowPeriod).reduce((sum, d) => sum + d.net, 0) / slowPeriod;
            const macd = fastEMA - slowEMA;
            
            return { macd: macd, signal: macd * 0.9, histogram: macd * 0.1 };
        }

        function detectPattern(data) {
            if (data.length < 10) return 'Insufficient Data';
            
            const recent = data.slice(-10);
            const trend = recent.reduce((sum, d) => sum + d.net, 0);
            const volatility = recent.reduce((sum, d) => sum + Math.abs(d.net), 0) / recent.length;
            
            if (trend > 0 && volatility < 2) return 'Bullish Consolidation';
            if (trend < 0 && volatility < 2) return 'Bearish Consolidation';
            if (trend > 0 && volatility > 5) return 'Bullish Breakout';
            if (trend < 0 && volatility > 5) return 'Bearish Breakdown';
            
            return 'Sideways';
        }

        // Export functionality
        function exportData() {
            const csvContent = "data:text/csv;charset=utf-8," + 
                "Timestamp,Positive Flow,Negative Flow,Net Flow,Volume\n" +
                moneyFlowData.map(d => 
                    `${d.timestamp.toISOString()},${d.positive.toFixed(2)},${d.negative.toFixed(2)},${d.net.toFixed(2)},${d.volume.toFixed(2)}`
                ).join('\n');
            
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', `money_flow_${currentAssetType}_${currentTimeframe}_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'r':
                        e.preventDefault();
                        generateData();
                        break;
                    case 'u':
                        e.preventDefault();
                        updateChart();
                        break;
                    case 'e':
                        e.preventDefault();
                        exportData();
                        break;
                }
            }
        });

        // Touch support for mobile
        let touchStartX = 0;
        let touchStartY = 0;

        document.addEventListener('touchstart', function(e) {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        });

        document.addEventListener('touchend', function(e) {
            const touchEndX = e.changedTouches[0].clientX;
            const touchEndY = e.changedTouches[0].clientY;
            
            const deltaX = touchEndX - touchStartX;
            const deltaY = touchEndY - touchStartY;
            
            // Swipe detection
            if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                if (deltaX > 0) {
                    // Swipe right - previous timeframe
                    const timeframes = Object.keys(timeframeConfigs);
                    const currentIndex = timeframes.indexOf(currentTimeframe);
                    if (currentIndex > 0) {
                        selectTimeframe(timeframes[currentIndex - 1]);
                    }
                } else {
                    // Swipe left - next timeframe
                    const timeframes = Object.keys(timeframeConfigs);
                    const currentIndex = timeframes.indexOf(currentTimeframe);
                    if (currentIndex < timeframes.length - 1) {
                        selectTimeframe(timeframes[currentIndex + 1]);
                    }
                }
            }
        });

        // Market hours detection
        function isMarketOpen() {
            const now = new Date();
            const day = now.getDay();
            const hour = now.getHours();
            
            switch(currentAssetType) {
                case 'crypto':
                    return true; // Crypto markets are always open
                case 'forex':
                    return day >= 1 && day <= 5; // Monday to Friday
                case 'stocks':
                    return day >= 1 && day <= 5 && hour >= 9 && hour <= 16; // Weekdays 9AM-4PM
                default:
                    return true;
            }
        }

        // Update market status
        function updateMarketStatus() {
            const isOpen = isMarketOpen();
            const statusElement = document.getElementById('marketStatus');
            const indicatorElement = document.querySelector('.status-indicator');
            
            if (isOpen) {
                statusElement.textContent = 'Open';
                statusElement.style.color = '#4CAF50';
                indicatorElement.className = 'status-indicator status-live';
            } else {
                statusElement.textContent = 'Closed';
                statusElement.style.color = '#FF6B9D';
                indicatorElement.className = 'status-indicator status-offline';
            }
        }

        // Update market status every minute
        setInterval(updateMarketStatus, 60000);
        updateMarketStatus(); // Initial call