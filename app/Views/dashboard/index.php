<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card-premium p-4 h-100 d-flex flex-column justify-content-center">
            <h5 class="text-muted mb-2"><i class="fa-solid fa-users text-primary me-2"></i> Total Balita Terdata</h5>
            <h2 class="display-5 fw-bold text-main mb-0" id="admin-stat-total"><i class="fa-solid fa-spinner fa-spin fa-xs"></i></h2>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card-premium p-4 h-100 d-flex flex-column justify-content-center">
            <h5 class="text-muted mb-2"><i class="fa-solid fa-seedling text-success me-2"></i> Tumbuh Normal</h5>
            <h2 class="display-5 fw-bold text-main mb-0" id="admin-stat-normal"><i class="fa-solid fa-spinner fa-spin fa-xs"></i></h2>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card-premium p-4 h-100 d-flex flex-column justify-content-center text-white" style="background: linear-gradient(135deg, #EF4444, #B91C1C) !important;">
            <h5 class="text-white-50 mb-2"><i class="fa-solid fa-triangle-exclamation text-white me-2"></i> Kasus Stunting / Berisiko</h5>
            <h2 class="display-5 fw-bold text-white mb-0" id="admin-stat-stunting"><i class="fa-solid fa-spinner fa-spin fa-xs"></i></h2>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Chart Section -->
    <div class="col-12 col-xl-5">
        <div class="card-premium p-4 h-100 premium-shadow">
            <h5 class="fw-bold mb-4 text-main"><i class="fa-solid fa-chart-pie text-primary me-2"></i> Statistik Per Posyandu</h5>
            <div style="position: relative; height:450px; width:100%;">
                <canvas id="posyanduChart"></canvas>
            </div>
            
            <div class="mt-4 table-responsive">
                <table class="table table-sm table-hover align-middle mb-0" id="admin-stat-table">
                    <thead class="table-light">
                        <tr>
                            <th>Posyandu</th>
                            <th class="text-center text-success">Normal</th>
                            <th class="text-center text-danger">Brsiko/Stnting</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="3" class="text-center text-muted">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="col-12 col-xl-7">

        <div class="card-premium p-0 overflow-hidden premium-shadow h-100">
            <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-map-location-dot text-primary me-2"></i> Peta Persebaran</h5>
            </div>
            <div class="position-relative flex-grow-1" style="min-height: 500px;">
                <div id="map" class="h-100 w-100 position-absolute" style="z-index: 1;"></div>
                
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

        // Fetch Statistics Data
        fetch('<?= base_url('api/statistics') ?>')
            .then(response => response.json())
            .then(stats => {
                // Populate Top Cards
                document.getElementById('admin-stat-total').innerText = stats.overall.total_children;
                document.getElementById('admin-stat-normal').innerText = stats.overall.total_normal;
                var bad = stats.overall.total_berisiko + stats.overall.total_stunting;
                document.getElementById('admin-stat-stunting').innerText = bad;

                // Populate Table and Chart Data
                var labels = [];
                var dataNormal = [];
                var dataBad = [];
                var tbody = "";

                if (stats.posyandu_breakdown && stats.posyandu_breakdown.length > 0) {
                    stats.posyandu_breakdown.forEach(function(p) {
                        labels.push(p.posyandu_name);
                        dataNormal.push(p.normal);
                        var badp = p.berisiko + p.stunting;
                        dataBad.push(badp);

                        tbody += `
                        <tr>
                            <td class="fw-medium">${p.posyandu_name}</td>
                            <td class="text-center text-success">${p.normal}</td>
                            <td class="text-center text-danger">${badp}</td>
                        </tr>`;
                    });
                    document.querySelector('#admin-stat-table tbody').innerHTML = tbody;
                } else {
                    document.querySelector('#admin-stat-table tbody').innerHTML = `<tr><td colspan="3" class="text-center text-muted">Belum ada data posyandu aktif.</td></tr>`;
                }

                // Render Chart.js
                var ctx = document.getElementById('posyanduChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Tumbuh Normal',
                                data: dataNormal,
                                backgroundColor: '#10B981',
                                borderRadius: 4
                            },
                            {
                                label: 'Berisiko / Stunting',
                                data: dataBad,
                                backgroundColor: '#EF4444',
                                borderRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        plugins: {
                            legend: { position: 'bottom' }
                        },
                        scales: {
                            y: { beginAtZero: true, stacked: true },
                            x: { stacked: true }
                        }
                    }
                });

            })
            .catch(err => console.error("Error fetching statistics: ", err));
    });
</script>
<?= $this->endSection() ?>
