<?php
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Country Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <!-- MapLibre GL (the library behind mapcn) -->
    <link href="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.css" rel="stylesheet" />
    <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
</head>
<body>
<div class="bg-image"></div>
<div class="bg-overlay"></div>

<div class="container">
    <h2>Country Explorer</h2>

    <form method="POST">
        <div class="search-box">
             <input type="text" name="country" placeholder="Search country or city..." required>
             <button type="submit">Explore</button>
        </div>
    </form>

    <?php if (isset($_POST['country'])): ?>
        <?php
        $search = $_POST['country'];
        $query = "SELECT * FROM countries WHERE country_name LIKE '%$search%' OR capital LIKE '%$search%'";
        $result = mysqli_query($conn, $query);
        $foundCountry = null;

        if (mysqli_num_rows($result) > 0) {
            $foundCountry = mysqli_fetch_assoc($result);
        }
        ?>
        
        <?php if ($foundCountry): ?>
        <!-- MapLibre Map Container -->
        <div class="map-container">
            <div id="map"></div>
        </div>
        
        <div class="result">
            <div class='passport-entry'>
                <div class='info-group'>
                    <span class='label'>Destination</span>
                    <h3 class='country-name'><?= htmlspecialchars($foundCountry['country_name']) ?></h3>
                    <span class='label'>Capital City</span>
                    <h4 class='capital-name'><?= htmlspecialchars($foundCountry['capital']) ?></h4>
                </div>
                <div class='flag-container'>
                    <img src='<?= htmlspecialchars($foundCountry['flag']) ?>' alt='Flag of <?= htmlspecialchars($foundCountry['country_name']) ?>'>
                </div>
            </div>
            
            <!-- More Info Button -->
            <button class="more-info-btn" onclick="openModal()">
                <span>More Info</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </button>
        </div>

        <!-- Country Info Modal -->
        <div id="countryModal" class="modal-overlay" onclick="closeModalOutside(event)">
            <div class="modal-content">
                <button class="modal-close" onclick="closeModal()">&times;</button>
                
                <div class="modal-header">
                    <img src='<?= htmlspecialchars($foundCountry['flag']) ?>' alt='Flag' class="modal-flag">
                    <div>
                        <h3><?= htmlspecialchars($foundCountry['country_name']) ?></h3>
                        <p><?= htmlspecialchars($foundCountry['capital']) ?></p>
                    </div>
                </div>
                
                <div class="modal-grid">
                    <div class="modal-item">
                        <div class="modal-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <div>
                            <span class="modal-label">Population</span>
                            <span class="modal-value">
                                <?= isset($foundCountry['population']) && $foundCountry['population'] ? number_format($foundCountry['population']) : 'N/A' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="modal-item">
                        <div class="modal-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <path d="M3 9h18"/>
                                <path d="M9 21V9"/>
                            </svg>
                        </div>
                        <div>
                            <span class="modal-label">Land Area</span>
                            <span class="modal-value">
                                <?= isset($foundCountry['area_km2']) && $foundCountry['area_km2'] ? number_format($foundCountry['area_km2']) . ' km²' : 'N/A' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="modal-item">
                        <div class="modal-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M2 12h20"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="modal-label">Continent</span>
                            <span class="modal-value">
                                <?= isset($foundCountry['continent']) && $foundCountry['continent'] ? htmlspecialchars($foundCountry['continent']) : 'N/A' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="modal-item">
                        <div class="modal-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
                                <path d="M12 18V6"/>
                            </svg>
                        </div>
                        <div>
                            <span class="modal-label">Currency</span>
                            <span class="modal-value">
                                <?= isset($foundCountry['currency']) && $foundCountry['currency'] ? htmlspecialchars($foundCountry['currency']) : 'N/A' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="modal-item">
                        <div class="modal-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                <path d="M8 10h8"/>
                                <path d="M8 14h4"/>
                            </svg>
                        </div>
                        <div>
                            <span class="modal-label">Language</span>
                            <span class="modal-value">
                                <?= isset($foundCountry['language']) && $foundCountry['language'] ? htmlspecialchars($foundCountry['language']) : 'N/A' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="modal-item">
                        <div class="modal-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <div>
                            <span class="modal-label">Timezone</span>
                            <span class="modal-value">
                                <?= isset($foundCountry['timezone']) && $foundCountry['timezone'] ? htmlspecialchars($foundCountry['timezone']) : 'N/A' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Country name to coordinates mapping
        const countryCoords = {
            'Afghanistan': [67.71, 33.93],
            'Albania': [20.17, 41.15],
            'Algeria': [1.66, 28.03],
            'Argentina': [-63.62, -38.42],
            'Australia': [133.78, -25.27],
            'Austria': [14.55, 47.52],
            'Bangladesh': [90.36, 23.68],
            'Belgium': [4.47, 50.50],
            'Brazil': [-51.93, -14.24],
            'Cambodia': [104.99, 12.57],
            'Canada': [-106.35, 56.13],
            'Chile': [-71.54, -35.68],
            'China': [104.20, 35.86],
            'Colombia': [-74.30, 4.57],
            'Cuba': [-77.78, 21.52],
            'Denmark': [9.50, 56.26],
            'Egypt': [30.80, 26.82],
            'Ethiopia': [40.49, 9.15],
            'Finland': [25.75, 61.92],
            'France': [2.21, 46.23],
            'Germany': [10.45, 51.17],
            'Greece': [21.82, 39.07],
            'India': [78.96, 20.59],
            'Indonesia': [113.92, -0.79],
            'Iran': [53.69, 32.43],
            'Iraq': [43.68, 33.22],
            'Ireland': [-7.69, 53.14],
            'Israel': [34.85, 31.05],
            'Italy': [12.57, 41.87],
            'Japan': [138.25, 36.20],
            'Kenya': [37.91, -0.02],
            'Malaysia': [101.98, 4.21],
            'Mexico': [-102.55, 23.63],
            'Morocco': [-7.09, 31.79],
            'Netherlands': [5.29, 52.13],
            'New Zealand': [174.89, -40.90],
            'Nigeria': [8.68, 9.08],
            'Norway': [8.47, 60.47],
            'Pakistan': [69.35, 30.38],
            'Peru': [-75.02, -9.19],
            'Philippines': [121.77, 12.88],
            'Poland': [19.15, 51.92],
            'Portugal': [-8.22, 39.40],
            'Romania': [24.97, 45.94],
            'Russia': [105.32, 61.52],
            'Saudi Arabia': [45.08, 23.89],
            'Singapore': [103.82, 1.35],
            'South Africa': [22.94, -30.56],
            'South Korea': [127.77, 35.91],
            'Spain': [-3.75, 40.46],
            'Sweden': [18.64, 60.13],
            'Switzerland': [8.23, 46.82],
            'Taiwan': [121.00, 23.70],
            'Thailand': [100.99, 15.87],
            'Turkey': [35.24, 38.96],
            'Ukraine': [31.17, 48.38],
            'United Arab Emirates': [53.85, 23.42],
            'United Kingdom': [-3.44, 55.38],
            'United States': [-95.71, 37.09],
            'Venezuela': [-66.59, 6.42],
            'Vietnam': [108.28, 14.06]
        };

        const searchedCountry = "<?= addslashes($foundCountry['country_name']) ?>";
        
        // Find coordinates (with fallback fuzzy match)
        let targetCoords = countryCoords[searchedCountry];
        if (!targetCoords) {
            for (const [name, coords] of Object.entries(countryCoords)) {
                if (name.toLowerCase().includes(searchedCountry.toLowerCase()) || 
                    searchedCountry.toLowerCase().includes(name.toLowerCase())) {
                    targetCoords = coords;
                    break;
                }
            }
        }
        // Default to center if not found
        if (!targetCoords) targetCoords = [0, 20];

        // Initialize MapLibre Map (same library that powers mapcn)
        const map = new maplibregl.Map({
            container: 'map',
            style: 'https://basemaps.cartocdn.com/gl/dark-matter-gl-style/style.json',
            center: targetCoords,
            zoom: 4,
            pitch: 45,
            bearing: -10,
            antialias: true
        });

        // Add navigation controls
        map.addControl(new maplibregl.NavigationControl(), 'top-right');

        // Add marker for the country
        const markerEl = document.createElement('div');
        markerEl.className = 'custom-marker';
        markerEl.innerHTML = `
            <div class="marker-pulse"></div>
            <div class="marker-dot"></div>
        `;

        new maplibregl.Marker({ element: markerEl })
            .setLngLat(targetCoords)
            .setPopup(new maplibregl.Popup({ offset: 25 })
                .setHTML('<strong><?= addslashes($foundCountry['country_name']) ?></strong><br><?= addslashes($foundCountry['capital']) ?>'))
            .addTo(map);

        // Fly to location with animation
        map.on('load', () => {
            map.flyTo({
                center: targetCoords,
                zoom: 5,
                pitch: 50,
                bearing: 0,
                duration: 2000,
                essential: true
            });
        });

        // Modal functions
        function openModal() {
            document.getElementById('countryModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('countryModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function closeModalOutside(event) {
            if (event.target.classList.contains('modal-overlay')) {
                closeModal();
            }
        }

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });
        </script>
        <?php else: ?>
        <div class="result">
            <p class='no-result'>No destinations found in our archives.</p>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
