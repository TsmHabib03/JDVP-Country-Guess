<?php
include 'db.php';

$country = "";
$result = null;
$searched = false;
$countryData = null;
$searchedCity = null;
$searchType = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['country'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['country']);
    $country = $searchTerm;
    $searched = true;
    
    // First, try to find a country
    $query = "SELECT * FROM countries WHERE country_name LIKE '%$searchTerm%' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $countryData = mysqli_fetch_assoc($result);
        $searchType = 'country';
    } else {
        // If no country found, search for a city
        $cityQuery = "SELECT c.*, co.id as country_id, co.capital, co.flag 
                      FROM cities c 
                      JOIN countries co ON c.country_name COLLATE utf8mb4_general_ci = co.country_name COLLATE utf8mb4_general_ci 
                      WHERE c.city_name LIKE '%$searchTerm%' 
                      LIMIT 1";
        $cityResult = mysqli_query($conn, $cityQuery);
        
        if ($cityResult && mysqli_num_rows($cityResult) > 0) {
            $searchedCity = mysqli_fetch_assoc($cityResult);
            // Get the country data for this city
            $countryQuery = "SELECT * FROM countries WHERE country_name = '" . mysqli_real_escape_string($conn, $searchedCity['country_name']) . "'";
            $countryResult = mysqli_query($conn, $countryQuery);
            if ($countryResult && mysqli_num_rows($countryResult) > 0) {
                $countryData = mysqli_fetch_assoc($countryResult);
            }
            $searchType = 'city';
        }
    }
    
    // Fetch all cities for the found country
    if ($countryData) {
        $citiesQuery = "SELECT * FROM cities WHERE country_name = '" . mysqli_real_escape_string($conn, $countryData['country_name']) . "' ORDER BY is_capital DESC, population DESC";
        $citiesResult = mysqli_query($conn, $citiesQuery);
        $cities = [];
        if ($citiesResult) {
            while ($city = mysqli_fetch_assoc($citiesResult)) {
                $cities[] = $city;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUNTRY//INTEL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.css">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="header-left">
            <div class="status-indicator">
                <span class="status-dot"></span>
                <span>Online</span>
            </div>
            <div class="logo">Country<span>//</span>Intel</div>
        </div>
        <div class="header-right">
            <span id="utc-time">UTC <?php echo date('Y.m.d H:i'); ?></span>
        </div>
    </header>

    <!-- MAIN -->
    <main class="main-content">
        <!-- Dashboard Grid -->
        <div class="dashboard">
            <!-- Search Panel -->
            <div class="search-panel">
                <div class="panel-header">
                    <span class="panel-title">Target Search</span>
                    <span class="panel-badge">v2.1</span>
                </div>
                <form method="POST" class="search-form">
                    <div class="input-group">
                        <label class="input-label">Enter Location</label>
                        <input 
                            type="text" 
                            name="country" 
                            class="search-input" 
                            placeholder="> Search country or city..."
                            value="<?php echo htmlspecialchars($country); ?>"
                            autocomplete="off"
                        >
                    </div>
                    <button type="submit" class="search-btn">Initiate Scan</button>
                </form>
            </div>

            <!-- Tactical Map Panel - MW3 Style -->
            <div class="map-panel tactical-interface">
                <div class="tactical-overlay">
                    <div class="scan-line"></div>
                    <div class="grid-overlay"></div>
                    <div class="crosshair">
                        <div class="crosshair-h"></div>
                        <div class="crosshair-v"></div>
                        <div class="crosshair-circle"></div>
                    </div>
                </div>
                
                <!-- HUD Elements -->
                <div class="hud-corner hud-tl">
                    <span class="hud-label">SAT-7 KEYHOLE</span>
                    <span class="hud-value live-indicator"><span class="live-dot"></span> LIVE FEED</span>
                </div>
                <div class="hud-corner hud-tr">
                    <span class="hud-label">ALT</span>
                    <span class="hud-value">423 KM</span>
                </div>
                <div class="hud-corner hud-bl">
                    <span class="hud-label">RES</span>
                    <span class="hud-value">0.15M GSD</span>
                </div>
                <div class="hud-corner hud-br">
                    <div class="signal-bars">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                    <span class="hud-value">SIGNAL</span>
                </div>

                <!-- Asset Control Panel -->
                <div class="asset-control">
                    <button class="asset-btn" id="btn-thermal" data-asset="thermal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8z"/>
                            <path d="M12 10v6M9 13h6"/>
                        </svg>
                        <span>THERMAL</span>
                    </button>
                    <button class="asset-btn" id="btn-recon" data-asset="recon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="8"/>
                            <path d="M12 4v3M12 17v3M4 12h3M17 12h3"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        <span>RECON</span>
                    </button>
                    <button class="asset-btn danger" id="btn-nuclear" data-asset="nuclear">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M12 2v4M12 18v4M2 12h4M18 12h4"/>
                            <circle cx="12" cy="12" r="9" stroke-dasharray="4 2"/>
                        </svg>
                        <span>NUCLEAR</span>
                    </button>
                </div>

                <div class="map-header">
                    <span class="map-title">TACTICAL OVERVIEW</span>
                    <span class="map-coords" id="coords-display">---, ---</span>
                </div>
                <div class="map-container">
                    <?php if ($countryData): ?>
                        <div id="map"></div>
                        <div class="corner-tr"></div>
                        <div class="corner-bl"></div>
                        <!-- Deployment Markers Container -->
                        <div id="deployment-markers"></div>
                    <?php else: ?>
                        <div class="map-placeholder">
                            <svg class="placeholder-icon" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            <span>AWAITING TARGET ACQUISITION</span>
                            <span class="placeholder-sub">Enter coordinates to begin satellite uplink</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- MW3-Style Search Animation Overlay -->
                <div class="search-overlay" id="search-overlay">
                    <div class="scan-ring ring-1"></div>
                    <div class="scan-ring ring-2"></div>
                    <div class="scan-ring ring-3"></div>
                    <div class="acquisition-box"></div>
                    <div class="search-text">
                        <span class="search-status">ACQUIRING TARGET</span>
                        <span class="search-target" id="search-target-name"></span>
                    </div>
                    <div class="search-progress">
                        <div class="progress-bar"></div>
                    </div>
                    <div class="data-stream" id="data-stream"></div>
                    <div class="coord-display" id="coord-display">
                        <span class="coord-lat">LAT: ---.----</span>
                        <span class="coord-lng">LNG: ---.----</span>
                    </div>
                </div>

                <!-- Nuclear Strike Overlay -->
                <div class="nuclear-overlay" id="nuclear-overlay">
                    <div class="nuke-warning">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 22h20L12 2zm0 4l7.5 14h-15L12 6zm-1 5v4h2v-4h-2zm0 6v2h2v-2h-2z"/>
                        </svg>
                        <span>NUCLEAR LAUNCH DETECTED</span>
                    </div>
                    <div class="nuke-countdown" id="nuke-countdown">10</div>
                    <div class="nuke-flash"></div>
                </div>
            </div>
        </div>

        <!-- Results -->
        <?php if ($searched): ?>
            <?php if ($countryData): ?>
                <?php
                    $coords = getCountryCoordinates($countryData['country_name']);
                    $targetId = 'TGT-' . str_pad($countryData['id'], 4, '0', STR_PAD_LEFT);
                    $countryInfo = getCountryInfo($countryData['country_name']);
                ?>
                <div class="dossier-card">
                    <!-- Classification Header -->
                    <div class="dossier-classification-bar"></div>
                    
                    <div class="dossier-header">
                        <div class="dossier-header-left">
                            <span class="dossier-badge"><?php echo $searchType === 'city' ? '◉ City Located' : '● Target Acquired'; ?></span>
                            <span class="dossier-title">INTELLIGENCE DOSSIER</span>
                        </div>
                        <div class="dossier-header-right">
                            <span class="dossier-id"><?php echo $targetId; ?></span>
                            <span class="dossier-timestamp"><?php echo date('Y.m.d H:i:s'); ?> UTC</span>
                        </div>
                    </div>

                    <div class="dossier-body">
                        <!-- Primary Intel -->
                        <div class="dossier-primary">
                            <div class="dossier-flag">
                                <div class="flag-frame">
                                    <img src="<?php echo htmlspecialchars($countryData['flag']); ?>" alt="Flag">
                                </div>
                                <span class="flag-label">NATIONAL FLAG</span>
                            </div>
                            <div class="dossier-identity">
                                <div class="identity-row">
                                    <span class="identity-label">COUNTRY</span>
                                    <h2 class="identity-value country-name"><?php echo htmlspecialchars($countryData['country_name']); ?></h2>
                                </div>
                                <div class="identity-row">
                                    <span class="identity-label">CAPITAL</span>
                                    <p class="identity-value capital-name"><?php echo htmlspecialchars($countryData['capital']); ?></p>
                                </div>
                                <div class="identity-coords">
                                    <div class="coord-box">
                                        <span class="coord-label">LAT</span>
                                        <span class="coord-value"><?php echo number_format($coords['lat'], 4); ?>°</span>
                                    </div>
                                    <div class="coord-box">
                                        <span class="coord-label">LNG</span>
                                        <span class="coord-value"><?php echo number_format($coords['lng'], 4); ?>°</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Country Statistics -->
                        <div class="dossier-stats">
                            <div class="stats-header">
                                <span class="stats-title">NATIONAL STATISTICS</span>
                            </div>
                            <div class="stats-grid">
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                                        </svg>
                                    </div>
                                    <div class="stat-data">
                                        <span class="stat-label">POPULATION</span>
                                        <span class="stat-value"><?php echo htmlspecialchars($countryInfo['population']); ?></span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z"/>
                                        </svg>
                                    </div>
                                    <div class="stat-data">
                                        <span class="stat-label">LAND AREA</span>
                                        <span class="stat-value"><?php echo htmlspecialchars($countryInfo['area']); ?> km²</span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802"/>
                                        </svg>
                                    </div>
                                    <div class="stat-data">
                                        <span class="stat-label">LANGUAGE</span>
                                        <span class="stat-value"><?php echo htmlspecialchars($countryInfo['language']); ?></span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </div>
                                    <div class="stat-data">
                                        <span class="stat-label">CURRENCY</span>
                                        <span class="stat-value"><?php echo htmlspecialchars($countryInfo['currency']); ?></span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                                        </svg>
                                    </div>
                                    <div class="stat-data">
                                        <span class="stat-label">GDP</span>
                                        <span class="stat-value"><?php echo htmlspecialchars($countryInfo['gdp']); ?></span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 10c-2.59 0-5.134.202-7.5.588V21M3 21h18M12 6.75h.008v.008H12V6.75Z"/>
                                        </svg>
                                    </div>
                                    <div class="stat-data">
                                        <span class="stat-label">GOVERNMENT</span>
                                        <span class="stat-value"><?php echo htmlspecialchars($countryInfo['government']); ?></span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>
                                        </svg>
                                    </div>
                                    <div class="stat-data">
                                        <span class="stat-label">CONTINENT</span>
                                        <span class="stat-value"><?php echo htmlspecialchars($countryInfo['continent']); ?></span>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                        </svg>
                                    </div>
                                    <div class="stat-data">
                                        <span class="stat-label">CALLING CODE</span>
                                        <span class="stat-value"><?php echo htmlspecialchars($countryInfo['calling_code']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Major Cities -->
                        <?php if (!empty($cities)): ?>
                        <div class="dossier-cities">
                            <div class="cities-header">
                                <span class="cities-title">MAJOR URBAN CENTERS</span>
                                <span class="cities-count"><span id="showing-count"><?php echo min(12, count($cities)); ?></span> / <?php echo count($cities); ?> LOCATIONS</span>
                            </div>
                            <div class="cities-grid" id="cities-grid">
                                <?php foreach ($cities as $index => $city): ?>
                                <div class="city-item <?php echo $city['is_capital'] ? 'is-capital' : ''; ?> <?php echo ($searchedCity && $city['city_name'] === $searchedCity['city_name']) ? 'searched-city' : ''; ?>" data-index="<?php echo $index; ?>">
                                    <div class="city-marker"><?php echo $city['is_capital'] ? '★' : '●'; ?></div>
                                    <div class="city-info">
                                        <span class="city-name"><?php echo htmlspecialchars($city['city_name']); ?></span>
                                        <span class="city-pop">POP: <?php echo htmlspecialchars($city['population']); ?></span>
                                    </div>
                                    <?php if ($city['is_capital']): ?>
                                    <span class="capital-tag">CAPITAL</span>
                                    <?php elseif ($searchedCity && $city['city_name'] === $searchedCity['city_name']): ?>
                                    <span class="searched-tag">SEARCHED</span>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if (count($cities) > 12): ?>
                            <div class="cities-pagination">
                                <button class="pagination-btn" id="prev-page" disabled>
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                                    PREV
                                </button>
                                <div class="pagination-info">
                                    <span>PAGE <span id="current-page">1</span> / <span id="total-pages"><?php echo ceil(count($cities) / 12); ?></span></span>
                                </div>
                                <button class="pagination-btn" id="next-page">
                                    NEXT
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <!-- Intel Grid -->
                        <div class="dossier-intel-grid">
                            <div class="intel-cell">
                                <span class="intel-label">REGION</span>
                                <span class="intel-value"><?php echo getRegion($countryData['country_name']); ?></span>
                            </div>
                            <div class="intel-cell">
                                <span class="intel-label">CLASSIFICATION</span>
                                <span class="intel-value classification-public">PUBLIC</span>
                            </div>
                            <div class="intel-cell">
                                <span class="intel-label">STATUS</span>
                                <span class="intel-value status-active">● ACTIVE</span>
                            </div>
                            <div class="intel-cell">
                                <span class="intel-label">ENTITY TYPE</span>
                                <span class="intel-value">SOVEREIGN STATE</span>
                            </div>
                            <div class="intel-cell">
                                <span class="intel-label">DATA INTEGRITY</span>
                                <span class="intel-value">VERIFIED</span>
                            </div>
                            <div class="intel-cell">
                                <span class="intel-label">TARGET ID</span>
                                <span class="intel-value"><?php echo $targetId; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Classification Footer -->
                    <div class="dossier-footer">
                        <span class="footer-notice">COUNTRY//INTEL SYSTEM • UNCLASSIFIED • FOR OFFICIAL USE ONLY</span>
                    </div>
                    <div class="dossier-classification-bar"></div>
                </div>
            <?php else: ?>
                <div class="no-result">
                    <svg class="no-result-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
                    </svg>
                    <p class="no-result-text">No target found for "<?php echo htmlspecialchars($country); ?>"</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p class="footer-text">Country Intel System • Classification: Public • <?php echo date('Y'); ?></p>
    </footer>



    <?php if ($countryData): ?>
    <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
    <script>
        const coords = { lat: <?php echo $coords['lat']; ?>, lng: <?php echo $coords['lng']; ?> };
        const countryName = "<?php echo addslashes($countryData['country_name']); ?>";
        const capital = "<?php echo addslashes($countryData['capital']); ?>";
        <?php if ($searchedCity): ?>
        const searchedCityName = "<?php echo addslashes($searchedCity['city_name']); ?>";
        <?php else: ?>
        const searchedCityName = null;
        <?php endif; ?>

        document.getElementById('coords-display').textContent = 
            coords.lat.toFixed(2) + '°, ' + coords.lng.toFixed(2) + '°';

        const map = new maplibregl.Map({
            container: 'map',
            style: 'https://basemaps.cartocdn.com/gl/dark-matter-gl-style/style.json',
            center: [coords.lng, coords.lat],
            zoom: 5,
            pitch: 45,
            bearing: -17.6,
            attributionControl: false,
            antialias: true
        });

        map.addControl(new maplibregl.NavigationControl(), 'top-right');

        map.on('load', () => {
            // Add 3D terrain effect using hillshading
            map.addSource('hillshade', {
                type: 'raster-dem',
                url: 'https://demotiles.maplibre.org/terrain-tiles/tiles.json',
                tileSize: 256
            });

            map.setTerrain({ source: 'hillshade', exaggeration: 1.5 });

            // Add 3D buildings layer
            const layers = map.getStyle().layers;
            let labelLayerId;
            for (let i = 0; i < layers.length; i++) {
                if (layers[i].type === 'symbol' && layers[i].layout['text-field']) {
                    labelLayerId = layers[i].id;
                    break;
                }
            }

            // Add atmosphere/sky
            map.addLayer({
                'id': 'sky',
                'type': 'sky',
                'paint': {
                    'sky-type': 'atmosphere',
                    'sky-atmosphere-sun': [0.0, 90.0],
                    'sky-atmosphere-sun-intensity': 15
                }
            });

            // Custom marker
            const el = document.createElement('div');
            el.className = 'custom-marker';
            el.innerHTML = '<div class="marker-pulse"></div><div class="marker-dot"></div>';

            new maplibregl.Marker({ element: el })
                .setLngLat([coords.lng, coords.lat])
                .setPopup(new maplibregl.Popup({ offset: 25, className: 'intel-popup' })
                    .setHTML(`<div class="popup-content"><strong>${countryName}</strong><br><span class="popup-capital">${capital}</span>${searchedCityName ? '<br><span class="popup-searched">🔍 ' + searchedCityName + '</span>' : ''}</div>`))
                .addTo(map);

            // Rotate the map slowly for 3D effect
            let rotation = -17.6;
            function rotateCamera() {
                rotation += 0.02;
                map.rotateTo(rotation % 360, { duration: 0 });
                requestAnimationFrame(rotateCamera);
            }
            // Uncomment to enable auto-rotation:
            // rotateCamera();
        });

        // Enable mouse rotation
        map.dragRotate.enable();
        map.touchZoomRotate.enableRotation();
    </script>
    <?php endif; ?>

    <script>
        // Update UTC time
        setInterval(() => {
            const now = new Date();
            const y = now.getUTCFullYear();
            const m = String(now.getUTCMonth() + 1).padStart(2, '0');
            const d = String(now.getUTCDate()).padStart(2, '0');
            const h = String(now.getUTCHours()).padStart(2, '0');
            const min = String(now.getUTCMinutes()).padStart(2, '0');
            document.getElementById('utc-time').textContent = `UTC ${y}.${m}.${d} ${h}:${min}`;
        }, 1000);

        // Pagination for cities
        (function() {
            const citiesGrid = document.getElementById('cities-grid');
            if (!citiesGrid) return;

            const cities = citiesGrid.querySelectorAll('.city-item');
            const totalCities = cities.length;
            const perPage = 12;
            const totalPages = Math.ceil(totalCities / perPage);
            let currentPage = 1;

            const prevBtn = document.getElementById('prev-page');
            const nextBtn = document.getElementById('next-page');
            const currentPageEl = document.getElementById('current-page');
            const showingCountEl = document.getElementById('showing-count');

            // Find if there's a searched city and go to that page
            const searchedCity = citiesGrid.querySelector('.searched-city');
            if (searchedCity) {
                const searchedIndex = parseInt(searchedCity.dataset.index);
                currentPage = Math.floor(searchedIndex / perPage) + 1;
            }

            function showPage(page) {
                const start = (page - 1) * perPage;
                const end = start + perPage;

                cities.forEach((city, index) => {
                    if (index >= start && index < end) {
                        city.style.display = 'flex';
                    } else {
                        city.style.display = 'none';
                    }
                });

                if (currentPageEl) currentPageEl.textContent = page;
                if (showingCountEl) showingCountEl.textContent = Math.min(end, totalCities);
                if (prevBtn) prevBtn.disabled = page === 1;
                if (nextBtn) nextBtn.disabled = page === totalPages;
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        showPage(currentPage);
                    }
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        showPage(currentPage);
                    }
                });
            }

            // Initialize
            if (totalCities > perPage) {
                showPage(currentPage);
            }
        })();
    </script>

<!-- MW3 Tactical Interface Controller -->
<script>
(function() {
    const searchOverlay = document.getElementById('search-overlay');
    const nuclearOverlay = document.getElementById('nuclear-overlay');
    const dataStream = document.getElementById('data-stream');
    const coordDisplay = document.getElementById('coord-display');
    const searchTargetName = document.getElementById('search-target-name');
    const deploymentMarkers = document.getElementById('deployment-markers');
    const mapContainer = document.querySelector('.map-container');
    
    const dataStrings = [
        'DECRYPTING SATELLITE FEED...',
        'RESOLVING COORDINATES...',
        'CROSS-REFERENCING DATABASE...',
        'VERIFYING TARGET SIGNATURE...',
        'ANALYZING TERRAIN DATA...',
        'CALCULATING APPROACH VECTORS...',
        'ESTABLISHING SECURE UPLINK...',
        'BANDWIDTH: 2.4 GBPS',
        'ENCRYPTION: AES-256',
        'ORBIT: GEOSYNCHRONOUS',
        'IMAGING MODE: MULTISPECTRAL',
        'THERMAL OVERLAY: ACTIVE',
    ];

    <?php if ($searched && $countryData): ?>
    window.addEventListener('load', function() {
        showSearchAnimation('<?php echo addslashes($country); ?>', {
            lat: <?php echo $coords['lat']; ?>,
            lng: <?php echo $coords['lng']; ?>
        });
    });
    <?php endif; ?>

    function showSearchAnimation(targetName, coords) {
        if (!searchOverlay) return;
        searchOverlay.classList.add('active');
        if (searchTargetName) searchTargetName.textContent = targetName.toUpperCase();
        animateCoordinates(coords);
        startDataStream();
        setTimeout(() => { searchOverlay.classList.remove('active'); }, 3000);
    }

    function animateCoordinates(coords) {
        if (!coordDisplay) return;
        const latEl = coordDisplay.querySelector('.coord-lat');
        const lngEl = coordDisplay.querySelector('.coord-lng');
        let frame = 0;
        const interval = setInterval(() => {
            if (frame >= 30) {
                clearInterval(interval);
                if (latEl) latEl.textContent = coords.lat.toFixed(4);
                if (lngEl) lngEl.textContent = coords.lng.toFixed(4);
                return;
            }
            if (latEl) latEl.textContent = (Math.random() * 180 - 90).toFixed(4);
            if (lngEl) lngEl.textContent = (Math.random() * 360 - 180).toFixed(4);
            frame++;
        }, 80);
    }

    function startDataStream() {
        if (!dataStream) return;
        dataStream.innerHTML = '';
        let lineIndex = 0;
        const interval = setInterval(() => {
            if (lineIndex >= dataStrings.length) { clearInterval(interval); return; }
            const line = document.createElement('div');
            line.textContent = '> ' + dataStrings[lineIndex];
            line.style.animation = 'fadeIn 0.3s ease-out';
            dataStream.appendChild(line);
            lineIndex++;
        }, 200);
    }

    // Asset deployment handlers
    const btnThermal = document.getElementById('btn-thermal');
    const btnRecon = document.getElementById('btn-recon');
    const btnNuclear = document.getElementById('btn-nuclear');
    let thermalActive = false;

    if (btnThermal) btnThermal.addEventListener('click', () => activateThermal());
    if (btnRecon) btnRecon.addEventListener('click', () => activateRecon());
    if (btnNuclear) btnNuclear.addEventListener('click', () => deployNuclear());

    function activateThermal() {
        thermalActive = !thermalActive;
        const btn = document.getElementById('btn-thermal');
        if (thermalActive) {
            if (mapContainer) mapContainer.classList.add('thermal-mode');
            if (btn) btn.classList.add('active');
            const scanEffect = document.createElement('div');
            scanEffect.className = 'thermal-scan-effect';
            if (mapContainer) mapContainer.appendChild(scanEffect);
            setTimeout(() => scanEffect.remove(), 2000);
        } else {
            if (mapContainer) mapContainer.classList.remove('thermal-mode');
            if (btn) btn.classList.remove('active');
        }
    }

    function activateRecon() {
        const btn = document.getElementById('btn-recon');
        if (btn) { btn.classList.add('active'); setTimeout(() => btn.classList.remove('active'), 15000); }
        
        // Military target database with proper icons
        const militaryTargets = [
            { id: 'TGT-001', type: 'fighter', name: 'F-22 RAPTOR', country: 'USA', status: 'friendly', dist: '12.4 KM', altitude: '35,000 FT', speed: '1,450 KPH', heading: '045°', icon: 'fighter' },
            { id: 'TGT-002', type: 'helicopter', name: 'AH-64 APACHE', country: 'USA', status: 'friendly', dist: '8.2 KM', altitude: '2,500 FT', speed: '280 KPH', heading: '120°', icon: 'helicopter' },
            { id: 'TGT-003', type: 'tank', name: 'M1A2 ABRAMS', country: 'USA', status: 'friendly', dist: '3.1 KM', altitude: 'GROUND', speed: '45 KPH', heading: '200°', icon: 'tank' },
            { id: 'TGT-004', type: 'fighter', name: 'SU-57 FELON', country: 'RUSSIA', status: 'hostile', dist: '28.7 KM', altitude: '42,000 FT', speed: '2,100 KPH', heading: '280°', icon: 'fighter' },
            { id: 'TGT-005', type: 'ship', name: 'USS ARLEIGH BURKE', country: 'USA', status: 'friendly', dist: '45.2 KM', altitude: 'SEA LEVEL', speed: '56 KPH', heading: '340°', icon: 'destroyer' },
            { id: 'TGT-006', type: 'fighter', name: 'J-20 MIGHTY DRAGON', country: 'CHINA', status: 'hostile', dist: '35.1 KM', altitude: '38,000 FT', speed: '1,900 KPH', heading: '095°', icon: 'fighter' },
            { id: 'TGT-007', type: 'bomber', name: 'TU-160 BLACKJACK', country: 'RUSSIA', status: 'hostile', dist: '52.3 KM', altitude: '45,000 FT', speed: '1,800 KPH', heading: '175°', icon: 'bomber' },
            { id: 'TGT-008', type: 'helicopter', name: 'KA-52 ALLIGATOR', country: 'RUSSIA', status: 'hostile', dist: '15.8 KM', altitude: '1,800 FT', speed: '310 KPH', heading: '220°', icon: 'helicopter' },
            { id: 'TGT-009', type: 'ship', name: 'TYPE 055 NANCHANG', country: 'CHINA', status: 'hostile', dist: '67.4 KM', altitude: 'SEA LEVEL', speed: '48 KPH', heading: '135°', icon: 'destroyer' },
            { id: 'TGT-010', type: 'drone', name: 'MQ-9 REAPER', country: 'USA', status: 'friendly', dist: '22.6 KM', altitude: '25,000 FT', speed: '370 KPH', heading: '310°', icon: 'drone' },
            { id: 'TGT-011', type: 'tank', name: 'T-14 ARMATA', country: 'RUSSIA', status: 'hostile', dist: '5.7 KM', altitude: 'GROUND', speed: '60 KPH', heading: '255°', icon: 'tank' },
            { id: 'TGT-012', type: 'sam', name: 'S-400 TRIUMF', country: 'RUSSIA', status: 'hostile', dist: '41.2 KM', altitude: 'GROUND', speed: '0 KPH', heading: 'N/A', icon: 'sam' }
        ];
        
        // SVG Icons for each military type - Realistic MW3 Style
        const iconSVGs = {
            fighter: `<svg viewBox="0 0 64 64" fill="currentColor">
                <!-- F-22 Style Fighter Jet -->
                <path d="M32 2L30 8V18L26 20V24L18 28L6 34V38L18 36L26 38V42L18 48V56L24 54L30 56V60L32 62L34 60V56L40 54L46 56V48L38 42V38L46 36L58 38V34L46 28L38 24V20L34 18V8L32 2Z"/>
                <path d="M28 22H36V26H28V22Z" fill-opacity="0.6"/>
                <circle cx="32" cy="14" r="2" fill-opacity="0.8"/>
            </svg>`,
            helicopter: `<svg viewBox="0 0 64 64" fill="currentColor">
                <!-- Apache Style Attack Helicopter -->
                <path d="M4 18H60V20H4V18Z"/>
                <path d="M30 20V24H28V20H30ZM36 20V24H34V20H36Z"/>
                <ellipse cx="32" cy="32" rx="14" ry="8"/>
                <path d="M18 32L10 36V40L18 38V32Z"/>
                <path d="M46 32L54 36V40L46 38V32Z"/>
                <path d="M44 30H56V34H44V30Z"/>
                <path d="M8 30H20V34H8V30Z"/>
                <path d="M26 40L22 56H28L30 40H26Z"/>
                <path d="M38 40L34 40L36 56H42L38 40Z"/>
                <circle cx="32" cy="30" r="4" fill-opacity="0.5"/>
                <path d="M32 24V20" stroke="currentColor" stroke-width="2"/>
            </svg>`,
            bomber: `<svg viewBox="0 0 64 64" fill="currentColor">
                <!-- B-2 Spirit Style Stealth Bomber -->
                <path d="M32 8L28 16V22L8 32L4 36V40L28 36V42L20 48V54L28 52L32 58L36 52L44 54V48L36 42V36L60 40V36L56 32L36 22V16L32 8Z"/>
                <path d="M24 28H40L44 32H20L24 28Z" fill-opacity="0.6"/>
                <circle cx="32" cy="20" r="2" fill-opacity="0.8"/>
                <path d="M30 32H34V36H30V32Z" fill-opacity="0.5"/>
            </svg>`,
            tank: `<svg viewBox="0 0 64 64" fill="currentColor">
                <!-- M1 Abrams Style Main Battle Tank -->
                <path d="M8 38H56V52H8V38Z"/>
                <path d="M12 42H52V48H12V42Z" fill-opacity="0.7"/>
                <ellipse cx="14" cy="50" rx="5" ry="4"/>
                <ellipse cx="26" cy="50" rx="5" ry="4"/>
                <ellipse cx="38" cy="50" rx="5" ry="4"/>
                <ellipse cx="50" cy="50" rx="5" ry="4"/>
                <path d="M18 26H46V38H18V26Z"/>
                <path d="M22 28H42V36H22V28Z" fill-opacity="0.6"/>
                <path d="M30 18H48V24H30V18Z"/>
                <path d="M48 20H58V22H48V20Z"/>
                <circle cx="36" cy="32" r="3" fill-opacity="0.5"/>
            </svg>`,
            destroyer: `<svg viewBox="0 0 64 64" fill="currentColor">
                <!-- Arleigh Burke Style Destroyer -->
                <path d="M4 38L10 32H54L60 38L56 44H8L4 38Z"/>
                <path d="M12 36H52V40L32 46L12 40V36Z"/>
                <path d="M24 28H40V36H24V28Z"/>
                <path d="M28 22H36V28H28V22Z"/>
                <path d="M30 16H34V22H30V16Z"/>
                <path d="M18 32H22V36H18V32Z" fill-opacity="0.6"/>
                <path d="M42 32H46V36H42V32Z" fill-opacity="0.6"/>
                <circle cx="32" cy="32" r="3" fill-opacity="0.5"/>
                <path d="M14 40L12 48H18L16 40H14Z"/>
                <path d="M50 40L48 40L50 48H54L50 40Z"/>
            </svg>`,
            drone: `<svg viewBox="0 0 64 64" fill="currentColor">
                <!-- MQ-9 Reaper Style UAV -->
                <path d="M32 10L30 14V24L28 26V30L20 34L8 38V42L20 40L28 42V48L22 52V58L28 56L32 60L36 56L42 58V52L36 48V42L44 40L56 42V38L44 34L36 30V26L34 24V14L32 10Z"/>
                <ellipse cx="32" cy="32" rx="6" ry="3" fill-opacity="0.6"/>
                <path d="M4 36H16V40H4V36Z"/>
                <path d="M48 36H60V40H48V36Z"/>
                <circle cx="32" cy="18" r="2" fill-opacity="0.8"/>
                <path d="M30 38H34V44H30V38Z" fill-opacity="0.5"/>
            </svg>`,
            sam: `<svg viewBox="0 0 64 64" fill="currentColor">
                <!-- S-400 Style SAM System -->
                <path d="M20 42H44V52H20V42Z"/>
                <ellipse cx="26" cy="50" rx="4" ry="3"/>
                <ellipse cx="38" cy="50" rx="4" ry="3"/>
                <path d="M24 34H40V42H24V34Z"/>
                <path d="M26 20L24 34H28L26 20Z"/>
                <path d="M32 16L30 34H34L32 16Z"/>
                <path d="M38 20L36 34H40L38 20Z"/>
                <path d="M22 18L26 10V6L28 4L26 6V14L22 18Z"/>
                <path d="M30 14L32 6V2L34 4V10L30 14Z"/>
                <path d="M38 18L42 10V6L40 4L42 6V14L38 18Z"/>
                <circle cx="26" cy="8" r="2"/>
                <circle cx="32" cy="4" r="2"/>
                <circle cx="38" cy="8" r="2"/>
            </svg>`
        };
        
        // Country flags
        const countryFlags = {
            'USA': '🇺🇸',
            'RUSSIA': '🇷🇺',
            'CHINA': '🇨🇳'
        };
        
        // Create horizontal radar scan overlay on map
        const mapScanOverlay = document.createElement('div');
        mapScanOverlay.className = 'map-radar-scan';
        mapScanOverlay.innerHTML = `
            <div class="horizontal-scan-line"></div>
        `;
        if (mapContainer) mapContainer.appendChild(mapScanOverlay);
        
        // Create target cards panel OUTSIDE the map (in main content area)
        const targetPanel = document.createElement('div');
        targetPanel.className = 'target-cards-panel';
        targetPanel.innerHTML = `
            <div class="panel-frame">
                <div class="panel-corner tl"></div>
                <div class="panel-corner tr"></div>
                <div class="panel-corner bl"></div>
                <div class="panel-corner br"></div>
            </div>
            <div class="panel-header">
                <div class="header-classification">
                    <span class="classification-badge">TOP SECRET</span>
                    <span class="classification-code">SCI//NOFORN</span>
                </div>
                <div class="panel-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/></svg>
                    <span>TARGET IDENTIFICATION</span>
                </div>
                <div class="scan-indicator">
                    <div class="scan-bars">
                        <span></span><span></span><span></span><span></span>
                    </div>
                    <span class="scan-text">SCANNING</span>
                </div>
            </div>
            <div class="panel-subheader">
                <span class="op-code">OP CODE: OVERLORD-7</span>
                <span class="timestamp" id="scan-timestamp">--:--:--</span>
            </div>
            <div class="target-cards-container"></div>
            <div class="panel-footer">
                <div class="threat-matrix">
                    <div class="matrix-item friendly-matrix">
                        <div class="matrix-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3zm-1 15l-4-4 1.41-1.41L11 14.17l6.59-6.59L19 9l-8 8z"/></svg>
                        </div>
                        <div class="matrix-data">
                            <span class="matrix-label">FRIENDLY</span>
                            <span class="matrix-count" id="friendly-total">0</span>
                        </div>
                    </div>
                    <div class="matrix-item hostile-matrix">
                        <div class="matrix-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                        </div>
                        <div class="matrix-data">
                            <span class="matrix-label">HOSTILE</span>
                            <span class="matrix-count hostile" id="hostile-total">0</span>
                        </div>
                    </div>
                </div>
                <div class="scan-progress-bar">
                    <div class="progress-fill"></div>
                    <span class="progress-text">ANALYZING...</span>
                </div>
                <div class="footer-classification">
                    <span>CLASSIFIED // EYES ONLY</span>
                </div>
            </div>
        `;
        // Append to body instead of map container
        document.body.appendChild(targetPanel);
        
        // Update timestamp
        const timestampEl = targetPanel.querySelector('#scan-timestamp');
        const updateTimestamp = () => {
            const now = new Date();
            timestampEl.textContent = now.toTimeString().split(' ')[0];
        };
        updateTimestamp();
        const tsInterval = setInterval(updateTimestamp, 1000);
        
        const cardsContainer = targetPanel.querySelector('.target-cards-container');
        const friendlyTotal = targetPanel.querySelector('#friendly-total');
        const hostileTotal = targetPanel.querySelector('#hostile-total');
        let friendlyCount = 0;
        let hostileCount = 0;
        
        // Reveal targets one by one with scan effect
        militaryTargets.forEach((target, index) => {
            setTimeout(() => {
                // Create target card
                const card = document.createElement('div');
                card.className = `target-card ${target.status} scan-reveal`;
                const threatLevel = target.status === 'hostile' ? 'HIGH' : 'NONE';
                card.innerHTML = `
                    <div class="card-threat-bar ${target.status}"></div>
                    <div class="card-header">
                        <div class="target-icon-large ${target.type}-icon">
                            ${iconSVGs[target.icon]}
                        </div>
                        <div class="target-main-info">
                            <div class="target-id-tag">${target.id}</div>
                            <div class="target-name">${target.name}</div>
                            <div class="target-country">
                                <span class="country-flag">${countryFlags[target.country]}</span>
                                <span class="country-name">${target.country}</span>
                            </div>
                        </div>
                        <div class="target-status-badge ${target.status}">
                            <div class="badge-indicator"></div>
                            <span>${target.status.toUpperCase()}</span>
                        </div>
                    </div>
                    <div class="card-details">
                        <div class="detail-grid">
                            <div class="detail-cell">
                                <span class="cell-label">RANGE</span>
                                <span class="cell-value">${target.dist}</span>
                            </div>
                            <div class="detail-cell">
                                <span class="cell-label">ALTITUDE</span>
                                <span class="cell-value">${target.altitude}</span>
                            </div>
                            <div class="detail-cell">
                                <span class="cell-label">SPEED</span>
                                <span class="cell-value">${target.speed}</span>
                            </div>
                            <div class="detail-cell">
                                <span class="cell-label">HEADING</span>
                                <span class="cell-value">${target.heading}</span>
                            </div>
                        </div>
                        <div class="threat-assessment">
                            <span class="threat-label">THREAT LEVEL:</span>
                            <span class="threat-value ${target.status}">${threatLevel}</span>
                        </div>
                    </div>
                    <div class="card-scan-line"></div>
                    <div class="card-corner-marks">
                        <span class="corner-mark tl"></span>
                        <span class="corner-mark tr"></span>
                        <span class="corner-mark bl"></span>
                        <span class="corner-mark br"></span>
                    </div>
                `;
                cardsContainer.appendChild(card);
                
                // Update counts
                if (target.status === 'friendly') {
                    friendlyCount++;
                    friendlyTotal.textContent = friendlyCount;
                } else {
                    hostileCount++;
                    hostileTotal.textContent = hostileCount;
                }
                
                // Trigger animation
                requestAnimationFrame(() => card.classList.add('revealed'));
                
                // Auto scroll to latest
                cardsContainer.scrollTop = cardsContainer.scrollHeight;
                
            }, 800 + (index * 700));
        });
        
        // Update scan indicator at end
        setTimeout(() => {
            const scanIndicator = targetPanel.querySelector('.scan-indicator');
            if (scanIndicator) {
                scanIndicator.innerHTML = `<div class="scan-complete-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div><span class="scan-text">COMPLETE</span>`;
                scanIndicator.classList.add('complete');
            }
            const progressText = targetPanel.querySelector('.progress-text');
            if (progressText) progressText.textContent = 'SCAN COMPLETE';
        }, 800 + (militaryTargets.length * 700));
        
        // Remove after animation
        setTimeout(() => { 
            clearInterval(tsInterval);
            mapScanOverlay.remove(); 
            targetPanel.remove(); 
        }, 15000);
    }

    function deployNuclear() {
        if (!nuclearOverlay) return;
        
        const btnNuke = document.getElementById('btn-nuclear');
        if (btnNuke) btnNuke.classList.add('active');

        // Screen shake
        document.body.classList.add('screen-shake');
        setTimeout(() => document.body.classList.remove('screen-shake'), 500);

        // Show nuclear overlay with countdown
        nuclearOverlay.classList.add('active');
        
        const countdownEl = document.getElementById('nuke-countdown');
        if (countdownEl) countdownEl.textContent = '5';
        let count = 5;
        
        nuclearOverlay.classList.add('warning-pulse');
        
        const countInterval = setInterval(() => {
            count--;
            if (countdownEl) {
                countdownEl.textContent = count;
                countdownEl.classList.add('countdown-pulse');
                setTimeout(() => countdownEl.classList.remove('countdown-pulse'), 200);
            }
            if (count <= 0) {
                clearInterval(countInterval);
                nuclearOverlay.classList.remove('warning-pulse');
                triggerNukeExplosion();
            }
        }, 1000);
    }

    function triggerNukeExplosion() {
        const flash = document.querySelector('.nuke-flash');
        if (flash) flash.classList.add('active');

        // Phase 1: Explosion on map
        setTimeout(() => {
            if (mapContainer) {
                const explosion = document.createElement('div');
                explosion.className = 'nuke-explosion';
                explosion.innerHTML = '<div class="explosion-core"></div><div class="shockwave"></div><div class="shockwave" style="animation-delay:0.2s;"></div><div class="shockwave" style="animation-delay:0.4s;"></div>';
                mapContainer.appendChild(explosion);
            }
        }, 300);

        // Phase 2: Static interference
        setTimeout(() => {
            if (mapContainer) mapContainer.classList.add('signal-interference');
        }, 800);

        // Phase 3: BLACKOUT - disconnect the map
        setTimeout(() => {
            if (mapContainer) {
                mapContainer.classList.add('blackout');
                mapContainer.classList.remove('signal-interference');
                
                // Hide the actual map
                const mapEl = document.getElementById('map');
                if (mapEl) mapEl.style.visibility = 'hidden';
                
                // Show SIGNAL LOST
                const signalLost = document.createElement('div');
                signalLost.className = 'signal-lost';
                signalLost.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:60px;height:60px;margin-bottom:15px;"><path d="M18.364 5.636a9 9 0 11-12.728 0"/><path d="M15.536 8.464a5 5 0 11-7.072 0"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="1" y1="1" x2="23" y2="23" stroke="#ef4444" stroke-width="2"/></svg><div class="lost-text">SIGNAL LOST</div><div class="lost-sub">SATELLITE UPLINK TERMINATED</div><div class="reconnect-text">ATTEMPTING RECONNECT...</div>';
                mapContainer.appendChild(signalLost);
            }
            
            nuclearOverlay.classList.remove('active');
            if (flash) flash.classList.remove('active');
        }, 1500);

        // Phase 4: Recovery after 6 seconds
        setTimeout(() => {
            if (mapContainer) {
                mapContainer.classList.remove('blackout');
                const mapEl = document.getElementById('map');
                if (mapEl) mapEl.style.visibility = 'visible';
                const signalLost = mapContainer.querySelector('.signal-lost');
                const explosion = mapContainer.querySelector('.nuke-explosion');
                if (signalLost) signalLost.remove();
                if (explosion) explosion.remove();
            }
            const btnNuke = document.getElementById('btn-nuclear');
            if (btnNuke) btnNuke.classList.remove('active');
            const countdownEl = document.getElementById('nuke-countdown');
            if (countdownEl) countdownEl.textContent = '5';
        }, 6000);
    }
})();
</script>
</body>
</html>

<?php
function getCountryCoordinates($name) {
    $coords = [
        'Afghanistan' => ['lat' => 33.93, 'lng' => 67.71],
        'Albania' => ['lat' => 41.15, 'lng' => 20.17],
        'Algeria' => ['lat' => 28.03, 'lng' => 1.66],
        'Argentina' => ['lat' => -38.42, 'lng' => -63.62],
        'Australia' => ['lat' => -25.27, 'lng' => 133.78],
        'Austria' => ['lat' => 47.52, 'lng' => 14.55],
        'Bangladesh' => ['lat' => 23.68, 'lng' => 90.36],
        'Belgium' => ['lat' => 50.50, 'lng' => 4.47],
        'Brazil' => ['lat' => -14.24, 'lng' => -51.93],
        'Canada' => ['lat' => 56.13, 'lng' => -106.35],
        'Chile' => ['lat' => -35.68, 'lng' => -71.54],
        'China' => ['lat' => 35.86, 'lng' => 104.20],
        'Colombia' => ['lat' => 4.57, 'lng' => -74.30],
        'Croatia' => ['lat' => 45.10, 'lng' => 15.20],
        'Cuba' => ['lat' => 21.52, 'lng' => -77.78],
        'Czech Republic' => ['lat' => 49.82, 'lng' => 15.47],
        'Denmark' => ['lat' => 56.26, 'lng' => 9.50],
        'Egypt' => ['lat' => 26.82, 'lng' => 30.80],
        'Ethiopia' => ['lat' => 9.15, 'lng' => 40.49],
        'Finland' => ['lat' => 61.92, 'lng' => 25.75],
        'France' => ['lat' => 46.23, 'lng' => 2.21],
        'Germany' => ['lat' => 51.17, 'lng' => 10.45],
        'Greece' => ['lat' => 39.07, 'lng' => 21.82],
        'Hungary' => ['lat' => 47.16, 'lng' => 19.50],
        'India' => ['lat' => 20.59, 'lng' => 78.96],
        'Indonesia' => ['lat' => -0.79, 'lng' => 113.92],
        'Iran' => ['lat' => 32.43, 'lng' => 53.69],
        'Iraq' => ['lat' => 33.22, 'lng' => 43.68],
        'Ireland' => ['lat' => 53.14, 'lng' => -7.69],
        'Israel' => ['lat' => 31.05, 'lng' => 34.85],
        'Italy' => ['lat' => 41.87, 'lng' => 12.57],
        'Japan' => ['lat' => 36.20, 'lng' => 138.25],
        'Kenya' => ['lat' => -0.02, 'lng' => 37.91],
        'Malaysia' => ['lat' => 4.21, 'lng' => 101.98],
        'Mexico' => ['lat' => 23.63, 'lng' => -102.55],
        'Morocco' => ['lat' => 31.79, 'lng' => -7.09],
        'Netherlands' => ['lat' => 52.13, 'lng' => 5.29],
        'New Zealand' => ['lat' => -40.90, 'lng' => 174.89],
        'Nigeria' => ['lat' => 9.08, 'lng' => 8.68],
        'North Korea' => ['lat' => 40.34, 'lng' => 127.51],
        'Norway' => ['lat' => 60.47, 'lng' => 8.47],
        'Pakistan' => ['lat' => 30.38, 'lng' => 69.35],
        'Peru' => ['lat' => -9.19, 'lng' => -75.02],
        'Philippines' => ['lat' => 12.88, 'lng' => 121.77],
        'Poland' => ['lat' => 51.92, 'lng' => 19.15],
        'Portugal' => ['lat' => 39.40, 'lng' => -8.22],
        'Romania' => ['lat' => 45.94, 'lng' => 24.97],
        'Russia' => ['lat' => 61.52, 'lng' => 105.32],
        'Saudi Arabia' => ['lat' => 23.89, 'lng' => 45.08],
        'Singapore' => ['lat' => 1.35, 'lng' => 103.82],
        'South Africa' => ['lat' => -30.56, 'lng' => 22.94],
        'South Korea' => ['lat' => 35.91, 'lng' => 127.77],
        'Spain' => ['lat' => 40.46, 'lng' => -3.75],
        'Sweden' => ['lat' => 60.13, 'lng' => 18.64],
        'Switzerland' => ['lat' => 46.82, 'lng' => 8.23],
        'Taiwan' => ['lat' => 23.70, 'lng' => 120.96],
        'Thailand' => ['lat' => 15.87, 'lng' => 100.99],
        'Turkey' => ['lat' => 38.96, 'lng' => 35.24],
        'Ukraine' => ['lat' => 48.38, 'lng' => 31.17],
        'United Arab Emirates' => ['lat' => 23.42, 'lng' => 53.85],
        'United Kingdom' => ['lat' => 55.38, 'lng' => -3.44],
        'United States' => ['lat' => 37.09, 'lng' => -95.71],
        'Venezuela' => ['lat' => 6.42, 'lng' => -66.59],
        'Vietnam' => ['lat' => 14.06, 'lng' => 108.28]
    ];
    return $coords[$name] ?? ['lat' => 0, 'lng' => 0];
}

function getRegion($name) {
    $regions = [
        'Afghanistan' => 'Asia', 'Albania' => 'Europe', 'Algeria' => 'Africa',
        'Argentina' => 'S. America', 'Australia' => 'Oceania', 'Austria' => 'Europe',
        'Bangladesh' => 'Asia', 'Belgium' => 'Europe', 'Brazil' => 'S. America',
        'Canada' => 'N. America', 'Chile' => 'S. America', 'China' => 'Asia',
        'Colombia' => 'S. America', 'Croatia' => 'Europe', 'Cuba' => 'Caribbean',
        'Czech Republic' => 'Europe', 'Denmark' => 'Europe', 'Egypt' => 'Africa',
        'Ethiopia' => 'Africa', 'Finland' => 'Europe', 'France' => 'Europe',
        'Germany' => 'Europe', 'Greece' => 'Europe', 'Hungary' => 'Europe',
        'India' => 'Asia', 'Indonesia' => 'Asia', 'Iran' => 'Asia',
        'Iraq' => 'Asia', 'Ireland' => 'Europe', 'Israel' => 'Asia',
        'Italy' => 'Europe', 'Japan' => 'Asia', 'Kenya' => 'Africa',
        'Malaysia' => 'Asia', 'Mexico' => 'N. America', 'Morocco' => 'Africa',
        'Netherlands' => 'Europe', 'New Zealand' => 'Oceania', 'Nigeria' => 'Africa',
        'North Korea' => 'Asia', 'Norway' => 'Europe', 'Pakistan' => 'Asia',
        'Peru' => 'S. America', 'Philippines' => 'Asia', 'Poland' => 'Europe',
        'Portugal' => 'Europe', 'Romania' => 'Europe', 'Russia' => 'Eurasia',
        'Saudi Arabia' => 'Asia', 'Singapore' => 'Asia', 'South Africa' => 'Africa',
        'South Korea' => 'Asia', 'Spain' => 'Europe', 'Sweden' => 'Europe',
        'Switzerland' => 'Europe', 'Taiwan' => 'Asia', 'Thailand' => 'Asia',
        'Turkey' => 'Eurasia', 'Ukraine' => 'Europe', 'United Arab Emirates' => 'Asia',
        'United Kingdom' => 'Europe', 'United States' => 'N. America',
        'Venezuela' => 'S. America', 'Vietnam' => 'Asia'
    ];
    return $regions[$name] ?? 'Unknown';
}

function getCountryInfo($name) {
    $info = [
        'Afghanistan' => ['population' => '41.1M', 'area' => '652,230', 'language' => 'Pashto, Dari', 'currency' => 'Afghani (AFN)', 'gdp' => '$14.6B', 'continent' => 'Asia', 'government' => 'Islamic Emirate', 'calling_code' => '+93'],
        'Albania' => ['population' => '2.8M', 'area' => '28,748', 'language' => 'Albanian', 'currency' => 'Lek (ALL)', 'gdp' => '$18.9B', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+355'],
        'Algeria' => ['population' => '45.6M', 'area' => '2,381,741', 'language' => 'Arabic, Berber', 'currency' => 'Dinar (DZD)', 'gdp' => '$191.9B', 'continent' => 'Africa', 'government' => 'Presidential Republic', 'calling_code' => '+213'],
        'Argentina' => ['population' => '46.2M', 'area' => '2,780,400', 'language' => 'Spanish', 'currency' => 'Peso (ARS)', 'gdp' => '$641.1B', 'continent' => 'South America', 'government' => 'Federal Republic', 'calling_code' => '+54'],
        'Australia' => ['population' => '26.4M', 'area' => '7,692,024', 'language' => 'English', 'currency' => 'Dollar (AUD)', 'gdp' => '$1.7T', 'continent' => 'Oceania', 'government' => 'Federal Parliamentary', 'calling_code' => '+61'],
        'Austria' => ['population' => '9.1M', 'area' => '83,871', 'language' => 'German', 'currency' => 'Euro (EUR)', 'gdp' => '$471.4B', 'continent' => 'Europe', 'government' => 'Federal Republic', 'calling_code' => '+43'],
        'Bangladesh' => ['population' => '172.9M', 'area' => '147,570', 'language' => 'Bengali', 'currency' => 'Taka (BDT)', 'gdp' => '$460.2B', 'continent' => 'Asia', 'government' => 'Parliamentary Republic', 'calling_code' => '+880'],
        'Belgium' => ['population' => '11.7M', 'area' => '30,528', 'language' => 'Dutch, French, German', 'currency' => 'Euro (EUR)', 'gdp' => '$578.6B', 'continent' => 'Europe', 'government' => 'Federal Parliamentary', 'calling_code' => '+32'],
        'Brazil' => ['population' => '216.4M', 'area' => '8,515,767', 'language' => 'Portuguese', 'currency' => 'Real (BRL)', 'gdp' => '$2.1T', 'continent' => 'South America', 'government' => 'Federal Republic', 'calling_code' => '+55'],
        'Canada' => ['population' => '40.1M', 'area' => '9,984,670', 'language' => 'English, French', 'currency' => 'Dollar (CAD)', 'gdp' => '$2.1T', 'continent' => 'North America', 'government' => 'Federal Parliamentary', 'calling_code' => '+1'],
        'Chile' => ['population' => '19.6M', 'area' => '756,102', 'language' => 'Spanish', 'currency' => 'Peso (CLP)', 'gdp' => '$301.0B', 'continent' => 'South America', 'government' => 'Presidential Republic', 'calling_code' => '+56'],
        'China' => ['population' => '1.41B', 'area' => '9,596,960', 'language' => 'Mandarin Chinese', 'currency' => 'Yuan (CNY)', 'gdp' => '$17.7T', 'continent' => 'Asia', 'government' => 'Socialist Republic', 'calling_code' => '+86'],
        'Colombia' => ['population' => '52.2M', 'area' => '1,141,748', 'language' => 'Spanish', 'currency' => 'Peso (COP)', 'gdp' => '$343.9B', 'continent' => 'South America', 'government' => 'Presidential Republic', 'calling_code' => '+57'],
        'Croatia' => ['population' => '3.9M', 'area' => '56,594', 'language' => 'Croatian', 'currency' => 'Euro (EUR)', 'gdp' => '$70.9B', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+385'],
        'Cuba' => ['population' => '11.1M', 'area' => '109,884', 'language' => 'Spanish', 'currency' => 'Peso (CUP)', 'gdp' => '$107.4B', 'continent' => 'North America', 'government' => 'Socialist Republic', 'calling_code' => '+53'],
        'Czech Republic' => ['population' => '10.5M', 'area' => '78,867', 'language' => 'Czech', 'currency' => 'Koruna (CZK)', 'gdp' => '$290.9B', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+420'],
        'Denmark' => ['population' => '5.9M', 'area' => '43,094', 'language' => 'Danish', 'currency' => 'Krone (DKK)', 'gdp' => '$395.4B', 'continent' => 'Europe', 'government' => 'Constitutional Monarchy', 'calling_code' => '+45'],
        'Egypt' => ['population' => '109.3M', 'area' => '1,001,450', 'language' => 'Arabic', 'currency' => 'Pound (EGP)', 'gdp' => '$476.7B', 'continent' => 'Africa', 'government' => 'Presidential Republic', 'calling_code' => '+20'],
        'Ethiopia' => ['population' => '126.5M', 'area' => '1,104,300', 'language' => 'Amharic', 'currency' => 'Birr (ETB)', 'gdp' => '$126.8B', 'continent' => 'Africa', 'government' => 'Federal Republic', 'calling_code' => '+251'],
        'Finland' => ['population' => '5.5M', 'area' => '338,424', 'language' => 'Finnish, Swedish', 'currency' => 'Euro (EUR)', 'gdp' => '$297.3B', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+358'],
        'France' => ['population' => '68.0M', 'area' => '643,801', 'language' => 'French', 'currency' => 'Euro (EUR)', 'gdp' => '$2.9T', 'continent' => 'Europe', 'government' => 'Semi-Presidential', 'calling_code' => '+33'],
        'Germany' => ['population' => '84.4M', 'area' => '357,022', 'language' => 'German', 'currency' => 'Euro (EUR)', 'gdp' => '$4.2T', 'continent' => 'Europe', 'government' => 'Federal Republic', 'calling_code' => '+49'],
        'Greece' => ['population' => '10.3M', 'area' => '131,957', 'language' => 'Greek', 'currency' => 'Euro (EUR)', 'gdp' => '$218.8B', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+30'],
        'Hungary' => ['population' => '9.6M', 'area' => '93,028', 'language' => 'Hungarian', 'currency' => 'Forint (HUF)', 'gdp' => '$188.5B', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+36'],
        'India' => ['population' => '1.43B', 'area' => '3,287,263', 'language' => 'Hindi, English', 'currency' => 'Rupee (INR)', 'gdp' => '$3.7T', 'continent' => 'Asia', 'government' => 'Federal Republic', 'calling_code' => '+91'],
        'Indonesia' => ['population' => '277.5M', 'area' => '1,904,569', 'language' => 'Indonesian', 'currency' => 'Rupiah (IDR)', 'gdp' => '$1.4T', 'continent' => 'Asia', 'government' => 'Presidential Republic', 'calling_code' => '+62'],
        'Iran' => ['population' => '89.2M', 'area' => '1,648,195', 'language' => 'Persian (Farsi)', 'currency' => 'Rial (IRR)', 'gdp' => '$388.5B', 'continent' => 'Asia', 'government' => 'Islamic Republic', 'calling_code' => '+98'],
        'Iraq' => ['population' => '44.5M', 'area' => '438,317', 'language' => 'Arabic, Kurdish', 'currency' => 'Dinar (IQD)', 'gdp' => '$267.9B', 'continent' => 'Asia', 'government' => 'Federal Republic', 'calling_code' => '+964'],
        'Ireland' => ['population' => '5.1M', 'area' => '70,273', 'language' => 'English, Irish', 'currency' => 'Euro (EUR)', 'gdp' => '$533.4B', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+353'],
        'Israel' => ['population' => '9.8M', 'area' => '20,770', 'language' => 'Hebrew, Arabic', 'currency' => 'Shekel (ILS)', 'gdp' => '$525.0B', 'continent' => 'Asia', 'government' => 'Parliamentary Republic', 'calling_code' => '+972'],
        'Italy' => ['population' => '58.9M', 'area' => '301,340', 'language' => 'Italian', 'currency' => 'Euro (EUR)', 'gdp' => '$2.2T', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+39'],
        'Japan' => ['population' => '124.5M', 'area' => '377,975', 'language' => 'Japanese', 'currency' => 'Yen (JPY)', 'gdp' => '$4.2T', 'continent' => 'Asia', 'government' => 'Constitutional Monarchy', 'calling_code' => '+81'],
        'Kenya' => ['population' => '55.1M', 'area' => '580,367', 'language' => 'Swahili, English', 'currency' => 'Shilling (KES)', 'gdp' => '$113.4B', 'continent' => 'Africa', 'government' => 'Presidential Republic', 'calling_code' => '+254'],
        'Malaysia' => ['population' => '34.3M', 'area' => '329,847', 'language' => 'Malay', 'currency' => 'Ringgit (MYR)', 'gdp' => '$407.0B', 'continent' => 'Asia', 'government' => 'Federal Constitutional Monarchy', 'calling_code' => '+60'],
        'Mexico' => ['population' => '129.4M', 'area' => '1,964,375', 'language' => 'Spanish', 'currency' => 'Peso (MXN)', 'gdp' => '$1.3T', 'continent' => 'North America', 'government' => 'Federal Republic', 'calling_code' => '+52'],
        'Morocco' => ['population' => '37.5M', 'area' => '446,550', 'language' => 'Arabic, Berber', 'currency' => 'Dirham (MAD)', 'gdp' => '$142.9B', 'continent' => 'Africa', 'government' => 'Constitutional Monarchy', 'calling_code' => '+212'],
        'Netherlands' => ['population' => '17.8M', 'area' => '41,543', 'language' => 'Dutch', 'currency' => 'Euro (EUR)', 'gdp' => '$1.0T', 'continent' => 'Europe', 'government' => 'Constitutional Monarchy', 'calling_code' => '+31'],
        'New Zealand' => ['population' => '5.2M', 'area' => '268,838', 'language' => 'English, Māori', 'currency' => 'Dollar (NZD)', 'gdp' => '$247.2B', 'continent' => 'Oceania', 'government' => 'Parliamentary Monarchy', 'calling_code' => '+64'],
        'Nigeria' => ['population' => '223.8M', 'area' => '923,768', 'language' => 'English', 'currency' => 'Naira (NGN)', 'gdp' => '$477.4B', 'continent' => 'Africa', 'government' => 'Federal Republic', 'calling_code' => '+234'],
        'North Korea' => ['population' => '26.1M', 'area' => '120,538', 'language' => 'Korean', 'currency' => 'Won (KPW)', 'gdp' => '$18.0B', 'continent' => 'Asia', 'government' => 'Socialist Republic', 'calling_code' => '+850'],
        'Norway' => ['population' => '5.5M', 'area' => '323,802', 'language' => 'Norwegian', 'currency' => 'Krone (NOK)', 'gdp' => '$579.3B', 'continent' => 'Europe', 'government' => 'Constitutional Monarchy', 'calling_code' => '+47'],
        'Pakistan' => ['population' => '235.8M', 'area' => '881,913', 'language' => 'Urdu, English', 'currency' => 'Rupee (PKR)', 'gdp' => '$376.5B', 'continent' => 'Asia', 'government' => 'Federal Republic', 'calling_code' => '+92'],
        'Peru' => ['population' => '34.0M', 'area' => '1,285,216', 'language' => 'Spanish', 'currency' => 'Sol (PEN)', 'gdp' => '$242.6B', 'continent' => 'South America', 'government' => 'Presidential Republic', 'calling_code' => '+51'],
        'Philippines' => ['population' => '117.3M', 'area' => '300,000', 'language' => 'Filipino, English', 'currency' => 'Peso (PHP)', 'gdp' => '$404.3B', 'continent' => 'Asia', 'government' => 'Presidential Republic', 'calling_code' => '+63'],
        'Poland' => ['population' => '36.8M', 'area' => '312,696', 'language' => 'Polish', 'currency' => 'Złoty (PLN)', 'gdp' => '$688.2B', 'continent' => 'Europe', 'government' => 'Parliamentary Republic', 'calling_code' => '+48'],
        'Portugal' => ['population' => '10.4M', 'area' => '92,212', 'language' => 'Portuguese', 'currency' => 'Euro (EUR)', 'gdp' => '$255.9B', 'continent' => 'Europe', 'government' => 'Semi-Presidential', 'calling_code' => '+351'],
        'Romania' => ['population' => '19.0M', 'area' => '238,391', 'language' => 'Romanian', 'currency' => 'Leu (RON)', 'gdp' => '$301.3B', 'continent' => 'Europe', 'government' => 'Semi-Presidential', 'calling_code' => '+40'],
        'Russia' => ['population' => '144.2M', 'area' => '17,098,242', 'language' => 'Russian', 'currency' => 'Ruble (RUB)', 'gdp' => '$1.9T', 'continent' => 'Eurasia', 'government' => 'Federal Republic', 'calling_code' => '+7'],
        'Saudi Arabia' => ['population' => '36.4M', 'area' => '2,149,690', 'language' => 'Arabic', 'currency' => 'Riyal (SAR)', 'gdp' => '$1.1T', 'continent' => 'Asia', 'government' => 'Absolute Monarchy', 'calling_code' => '+966'],
        'Singapore' => ['population' => '6.0M', 'area' => '733', 'language' => 'English, Malay, Chinese, Tamil', 'currency' => 'Dollar (SGD)', 'gdp' => '$501.4B', 'continent' => 'Asia', 'government' => 'Parliamentary Republic', 'calling_code' => '+65'],
        'South Africa' => ['population' => '60.4M', 'area' => '1,221,037', 'language' => 'Zulu, Xhosa, Afrikaans, English', 'currency' => 'Rand (ZAR)', 'gdp' => '$405.9B', 'continent' => 'Africa', 'government' => 'Parliamentary Republic', 'calling_code' => '+27'],
        'South Korea' => ['population' => '51.7M', 'area' => '100,210', 'language' => 'Korean', 'currency' => 'Won (KRW)', 'gdp' => '$1.7T', 'continent' => 'Asia', 'government' => 'Presidential Republic', 'calling_code' => '+82'],
        'Spain' => ['population' => '48.0M', 'area' => '505,990', 'language' => 'Spanish', 'currency' => 'Euro (EUR)', 'gdp' => '$1.4T', 'continent' => 'Europe', 'government' => 'Parliamentary Monarchy', 'calling_code' => '+34'],
        'Sweden' => ['population' => '10.6M', 'area' => '450,295', 'language' => 'Swedish', 'currency' => 'Krona (SEK)', 'gdp' => '$593.3B', 'continent' => 'Europe', 'government' => 'Constitutional Monarchy', 'calling_code' => '+46'],
        'Switzerland' => ['population' => '8.8M', 'area' => '41,277', 'language' => 'German, French, Italian', 'currency' => 'Franc (CHF)', 'gdp' => '$807.7B', 'continent' => 'Europe', 'government' => 'Federal Republic', 'calling_code' => '+41'],
        'Taiwan' => ['population' => '23.9M', 'area' => '36,193', 'language' => 'Mandarin Chinese', 'currency' => 'Dollar (TWD)', 'gdp' => '$790.7B', 'continent' => 'Asia', 'government' => 'Semi-Presidential', 'calling_code' => '+886'],
        'Thailand' => ['population' => '71.8M', 'area' => '513,120', 'language' => 'Thai', 'currency' => 'Baht (THB)', 'gdp' => '$495.3B', 'continent' => 'Asia', 'government' => 'Constitutional Monarchy', 'calling_code' => '+66'],
        'Turkey' => ['population' => '85.8M', 'area' => '783,562', 'language' => 'Turkish', 'currency' => 'Lira (TRY)', 'gdp' => '$905.5B', 'continent' => 'Eurasia', 'government' => 'Presidential Republic', 'calling_code' => '+90'],
        'Ukraine' => ['population' => '37.0M', 'area' => '603,550', 'language' => 'Ukrainian', 'currency' => 'Hryvnia (UAH)', 'gdp' => '$160.5B', 'continent' => 'Europe', 'government' => 'Semi-Presidential', 'calling_code' => '+380'],
        'United Arab Emirates' => ['population' => '9.5M', 'area' => '83,600', 'language' => 'Arabic', 'currency' => 'Dirham (AED)', 'gdp' => '$507.5B', 'continent' => 'Asia', 'government' => 'Federal Monarchy', 'calling_code' => '+971'],
        'United Kingdom' => ['population' => '67.7M', 'area' => '243,610', 'language' => 'English', 'currency' => 'Pound (GBP)', 'gdp' => '$3.1T', 'continent' => 'Europe', 'government' => 'Constitutional Monarchy', 'calling_code' => '+44'],
        'United States' => ['population' => '339.9M', 'area' => '9,833,517', 'language' => 'English', 'currency' => 'Dollar (USD)', 'gdp' => '$25.5T', 'continent' => 'North America', 'government' => 'Federal Republic', 'calling_code' => '+1'],
        'Venezuela' => ['population' => '28.4M', 'area' => '916,445', 'language' => 'Spanish', 'currency' => 'Bolívar (VES)', 'gdp' => '$92.4B', 'continent' => 'South America', 'government' => 'Federal Republic', 'calling_code' => '+58'],
        'Vietnam' => ['population' => '100.3M', 'area' => '331,212', 'language' => 'Vietnamese', 'currency' => 'Đồng (VND)', 'gdp' => '$449.1B', 'continent' => 'Asia', 'government' => 'Socialist Republic', 'calling_code' => '+84']
    ];
    return $info[$name] ?? [
        'population' => 'N/A', 'area' => 'N/A', 'language' => 'N/A', 
        'currency' => 'N/A', 'gdp' => 'N/A', 'continent' => 'N/A',
        'government' => 'N/A', 'calling_code' => 'N/A'
    ];

}
?>
