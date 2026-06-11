<?php
// Initialize session to store user settings (theme, language)
session_start();

// Set language preference
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'en' ? 'en' : 'id';
}
$lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'id';

// Localization array
$locales = [
    'id' => [
        'title' => 'Jadwal Penerbangan',
        'subtitle' => 'Data jadwal penerbangan terintegrasi dari Maskapai AA, BB, dan CC.',
        'col_id' => 'ID Penerbangan',
        'col_from' => 'Asal',
        'col_to' => 'Tujuan',
        'col_depart' => 'Keberangkatan',
        'col_arrive' => 'Kedatangan',
        'col_price' => 'Harga',
        'btn_export' => 'Ekspor Data JSON',
        'empty_title' => 'Data Belum Di-ekspor',
        'empty_desc' => 'File JSON penerbangan tidak ditemukan atau kosong. Silakan ekspor data terlebih dahulu.',
        'btn_do_export' => 'Ekspor Sekarang',
        'theme_toggle' => 'Ganti Tema',
        'lang_label' => 'Bahasa'
    ],
    'en' => [
        'title' => 'Flight Schedules',
        'subtitle' => 'Integrated flight schedule data from Maskapai AA, BB, and CC.',
        'col_id' => 'Flight ID',
        'col_from' => 'From',
        'col_to' => 'To',
        'col_depart' => 'Departure',
        'col_arrive' => 'Arrival',
        'col_price' => 'Price',
        'btn_export' => 'Export JSON Data',
        'empty_title' => 'Data Not Exported',
        'empty_desc' => 'The flight JSON file was not found or is empty. Please export the data first.',
        'btn_do_export' => 'Export Now',
        'theme_toggle' => 'Toggle Theme',
        'lang_label' => 'Language'
    ]
];

$t = $locales[$lang];

// Check if flights.json exists and read it
$jsonFile = 'flights.json';
$flights = [];
$hasData = false;

if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $data = json_decode($jsonContent, true);
    if (isset($data['flight']) && is_array($data['flight'])) {
        $flights = $data['flight'];
        $hasData = count($flights) > 0;
    }
}

// Format currency
function formatRupiah($val) {
    return 'Rp ' . number_format((float)$val, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($t['title']); ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-title">
                <h1><?php echo htmlspecialchars($t['title']); ?></h1>
                <p><?php echo htmlspecialchars($t['subtitle']); ?></p>
            </div>
            <div class="controls">
                <!-- Language Selector -->
                <select onchange="changeLanguage(this.value)" class="lang-select" aria-label="<?php echo $t['lang_label']; ?>">
                    <option value="id" <?php echo $lang === 'id' ? 'selected' : ''; ?>>Bahasa Indonesia</option>
                    <option value="en" <?php echo $lang === 'en' ? 'selected' : ''; ?>>English</option>
                </select>

                <!-- Theme Toggle Button -->
                <button onclick="toggleTheme()" class="btn-icon" id="theme-btn" title="<?php echo htmlspecialchars($t['theme_toggle']); ?>">
                    <i class="fa-solid fa-moon"></i>
                </button>
            </div>
        </header>

        <main class="card">
            <?php if ($hasData): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th><?php echo htmlspecialchars($t['col_id']); ?></th>
                                <th><?php echo htmlspecialchars($t['col_from']); ?></th>
                                <th><?php echo htmlspecialchars($t['col_to']); ?></th>
                                <th><?php echo htmlspecialchars($t['col_depart']); ?></th>
                                <th><?php echo htmlspecialchars($t['col_arrive']); ?></th>
                                <th><?php echo htmlspecialchars($t['col_price']); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($flights as $flight): ?>
                                <tr>
                                    <td><span class="flight-id"><?php echo htmlspecialchars($flight['ID']); ?></span></td>
                                    <td><?php echo htmlspecialchars($flight['from']); ?></td>
                                    <td><?php echo htmlspecialchars($flight['to']); ?></td>
                                    <td><strong><?php echo htmlspecialchars($flight['depart']); ?></strong></td>
                                    <td><strong><?php echo htmlspecialchars($flight['arrive']); ?></strong></td>
                                    <td><span class="price-tag"><?php echo formatRupiah($flight['price']); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="action-buttons">
                    <a href="export.php" class="btn btn-primary">
                        <i class="fa-solid fa-file-export"></i> <?php echo htmlspecialchars($t['btn_export']); ?>
                    </a>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fa-solid fa-plane-slash" style="font-size: 3.5rem; color: var(--error); margin-bottom: 1.5rem;"></i>
                    <h2><?php echo htmlspecialchars($t['empty_title']); ?></h2>
                    <p><?php echo htmlspecialchars($t['empty_desc']); ?></p>
                    <a href="export.php" class="btn btn-primary">
                        <i class="fa-solid fa-database"></i> <?php echo htmlspecialchars($t['btn_do_export']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        // Check for saved theme preference, otherwise use system preference
        const savedTheme = localStorage.getItem('theme');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
            document.documentElement.setAttribute('data-theme', 'dark');
            updateThemeIcon(true);
        } else {
            document.documentElement.setAttribute('data-theme', 'light');
            updateThemeIcon(false);
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            let newTheme = 'light';
            
            if (currentTheme === 'light') {
                newTheme = 'dark';
            }
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme === 'dark');
        }

        function updateThemeIcon(isDark) {
            const themeBtn = document.getElementById('theme-btn');
            if (themeBtn) {
                if (isDark) {
                    themeBtn.innerHTML = '<i class="fa-solid fa-sun"></i>';
                } else {
                    themeBtn.innerHTML = '<i class="fa-solid fa-moon"></i>';
                }
            }
        }

        function changeLanguage(langVal) {
            const url = new URL(window.location.href);
            url.searchParams.set('lang', langVal);
            window.location.href = url.toString();
        }
    </script>
</body>
</html>
