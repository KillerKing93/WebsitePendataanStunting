<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row align-items-center mb-5" style="min-height: 50vh;">
    <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
        <span class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill fw-bold">Sistem Informasi Publik</span>
        <h1 class="display-4 fw-bold text-main mb-3">Bersama Cegah <span class="text-primary">Stunting</span> Demi Masa Depan.</h1>
        <p class="lead text-muted mb-4">Pantau persebaran dan statistik titik rawan gizi buruk dan stunting di daerah ini secara transparan dan terintegrasi melalui peta spasial.</p>
        <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
            <a href="#public-map" class="btn btn-primary-premium"><i class="fa-solid fa-map-location-dot me-2"></i>Lihat Persebaran</a>
            <a href="<?= base_url('login') ?>" class="btn btn-outline-secondary rounded-pill px-4 fw-medium"><i class="fa-solid fa-right-to-bracket me-2"></i>Login Kader</a>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="position-relative">
            <div class="bg-primary rounded-circle position-absolute top-50 start-50 translate-middle" style="width: 300px; height: 300px; opacity: 0.1; filter: blur(40px);"></div>
            <img src="https://images.unsplash.com/photo-1519689680058-324335c77eba?auto=format&fit=crop&q=80&w=600&h=400" alt="Family and Kids" class="img-fluid rounded-4 premium-shadow position-relative z-1" style="object-fit: cover; border: 4px solid white;">
            
            <div class="card-premium position-absolute bottom-0 start-0 translate-middle-y ms-minus-3 z-2 p-3 d-flex align-items-center gap-3 animate-float" style="width: max-content;">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-arrow-trend-down"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">12%</h6>
                    <small class="text-muted">Penurunan kasus</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="public-map-section" class="mb-5">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-main">Peta Persebaran Publik</h3>
        <p class="text-muted">Data ini dienkripsi demi menjaga kerahasiaan identitas balita.</p>
    </div>
    <div class="card-premium p-0 overflow-hidden premium-shadow position-relative">
        <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center position-absolute top-0 start-0 w-100" style="z-index: 500;">
            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-map-location-dot text-primary me-2"></i> Peta Publik</h6>
            <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm d-flex align-items-center" id="btnMyLocation">
                <i class="fa-solid fa-street-view me-2"></i> Ketahui Posisi Saya
            </button>
        </div>
        <!-- Peta Publik Tanpa Identitas Detail -->
        <div id="public-map" style="height: 600px; width: 100%; border-radius: 14px; margin-top: 60px; z-index: 1;"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .ms-minus-3 { margin-left: -3rem; }
    .animate-float { animation: float 6s ease-in-out infinite; }
    @keyframes float {
        0% { transform: translateY(0px) translateX(-50%); }
        50% { transform: translateY(-10px) translateX(-50%); }
        100% { transform: translateY(0px) translateX(-50%); }
    }
    @media (max-width: 991px) { .ms-minus-3 { margin-left: 0; left: 50%; bottom: -20px; } }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('public-map', {
            zoomControl: false
        }).setView([-6.200000, 106.816666], 12);
        
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);
        
        // Add Geocoder Search Control
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: true,
            placeholder: "Cari desa / rute jalan terdekat...",
            position: 'topleft'
        }).addTo(map);

        // Styling search bar
        document.querySelector('.leaflet-control-geocoder').style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        document.querySelector('.leaflet-control-geocoder').style.border = 'none';
        document.querySelector('.leaflet-control-geocoder').style.borderRadius = '8px';

        // HTML5 Geolocation (My Location Feature)
        document.getElementById('btnMyLocation').addEventListener('click', function() {
            var btn = this;
            var originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i>Mencari...';
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        
                        map.setView([lat, lng], 14, {animate: true});
                        // Opsional: tambah marker lokasi saya
                        L.marker([lat, lng]).addTo(map).bindPopup("Lokasi Saya saat ini").openPopup();

                        btn.innerHTML = '<i class="fa-solid fa-check text-success me-2"></i>Ditemukan';
                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        }, 2500);
                    },
                    function(error) {
                        alert("Gagal mendapatkan lokasi. Pastikan izin lokasi browser Anda aktif.");
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            } else {
                alert("Browser Anda tidak mendukung fitur Geolocation.");
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });

        // Fetch dynamic marker data from API (Blurred / Abstracted for public)
        fetch('<?= base_url('api/stunting-map') ?>')
            .then(response => response.json())
            .then(data => {
                data.forEach(function(point) {
                    L.circle([point.lat, point.lng], {
                        color: point.color,
                        fillColor: point.color,
                        fillOpacity: 0.5,
                        radius: 250 // Blur / abstract location by showing generic 250m radius
                    }).addTo(map).bindPopup("<div class='text-center'>Area Terdata</div>");
                });
            })
            .catch(err => console.error("Error fetching map data: ", err));
    });
</script>
<?= $this->endSection() ?>
