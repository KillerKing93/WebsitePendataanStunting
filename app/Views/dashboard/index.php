<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card-premium p-4 h-100 d-flex flex-column justify-content-center">
            <h5 class="text-muted mb-2"><i class="fa-solid fa-users text-primary me-2"></i> Total Balita</h5>
            <h2 class="display-5 fw-bold text-main mb-0">1,245</h2>
            <small class="text-success mt-2 fw-medium"><i class="fa-solid fa-arrow-trend-up"></i> +12% bulan ini</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card-premium p-4 h-100 d-flex flex-column justify-content-center">
            <h5 class="text-muted mb-2"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i> Berisiko Stunting</h5>
            <h2 class="display-5 fw-bold text-main mb-0">84</h2>
            <small class="text-danger mt-2 fw-medium"><i class="fa-solid fa-arrow-trend-up"></i> +3 kasus baru</small>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card-premium p-4 h-100 d-flex flex-column justify-content-center text-white" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;">
            <h5 class="text-white-50 mb-2"><i class="fa-solid fa-chart-line text-white me-2"></i> Prevalensi Stunting</h5>
            <h2 class="display-5 fw-bold text-white mb-0">6.7%</h2>
            <small class="text-white mt-2 fw-light"><i class="fa-solid fa-bullseye"></i> Target nasional < 14%</small>
        </div>
    </div>
</div>

<div class="card-premium p-0 overflow-hidden premium-shadow mb-5">
    <div class="p-4 border-bottom bg-white d-flex justify-content-between align-items-center flex-wrap gap-3">
        <h4 class="mb-0 fw-bold"><i class="fa-solid fa-map-location-dot text-primary me-2"></i> Peta Persebaran Balita</h4>
        <div class="d-flex gap-2">
            <select class="form-select border-0 bg-light" style="width: auto; font-weight: 500;">
                <option value="all">Semua Posyandu</option>
            </select>
            <select class="form-select border-0 bg-light" style="width: auto; font-weight: 500;">
                <option value="all">Semua Status</option>
                <option value="Normal">🟢 Normal</option>
                <option value="Berisiko">🟡 Berisiko</option>
                <option value="Stunting">🔴 Stunting</option>
            </select>
        </div>
    </div>
    <div class="position-relative">
        <div id="map" style="height: 600px; width: 100%; border-radius: 0 0 16px 16px; border: none; z-index: 1;"></div>
        
        <!-- Legend Overlay -->
        <div class="position-absolute bottom-0 start-0 m-3 p-3 bg-white rounded shadow-sm" style="z-index: 400; font-size: 0.85rem;">
            <h6 class="fw-bold mb-2 small">Keterangan</h6>
            <div class="d-flex align-items-center mb-1">
                <span class="d-inline-block rounded-circle me-2" style="width:12px; height:12px; background:#10B981;"></span> Normal
            </div>
            <div class="d-flex align-items-center mb-1">
                <span class="d-inline-block rounded-circle me-2" style="width:12px; height:12px; background:#F59E0B;"></span> Berisiko
            </div>
            <div class="d-flex align-items-center">
                <span class="d-inline-block rounded-circle me-2" style="width:12px; height:12px; background:#EF4444;"></span> Stunting
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Map
        // Default Center to Indonesia or specific area (example: Jakarta Pusat for now)
        var map = L.map('map').setView([-6.200000, 106.816666], 12);
        
        // Add OpenStreetMap tile layer (light/modern style)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Fetch dynamic marker data from API
        fetch('<?= base_url('api/stunting-map') ?>')
            .then(response => response.json())
            .then(data => {
                data.forEach(function(child) {
                    var customIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: `<div style='background-color:${child.color}; width:16px; height:16px; border-radius:50%; border:2px solid white; box-shadow:0 0 10px rgba(0,0,0,0.3); transition: transform 0.2s;'></div>`,
                        iconSize: [16, 16],
                        iconAnchor: [8, 8]
                    });

                    var marker = L.marker([child.lat, child.lng], {icon: customIcon})
                      .addTo(map)
                      .bindPopup(`
                        <div class="text-center p-1">
                            <h6 class="fw-bold mb-1">${child.name}</h6>
                            <span class="badge" style="background-color: ${child.color}">${child.status}</span>
                        </div>
                      `);
                });
            })
            .catch(err => console.error("Error fetching map data: ", err));
    });
</script>
<?= $this->endSection() ?>
