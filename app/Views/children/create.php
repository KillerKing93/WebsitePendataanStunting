<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row g-4 mb-5">
    <div class="col-12 col-xl-5">
        <div class="card-premium p-4 h-100">
            <h4 class="fw-bold mb-4 text-main"><i class="fa-solid fa-child-reaching text-primary me-2"></i> Tambah Data Balita</h4>
            
            <form action="<?= base_url('admin/children/store') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label fw-medium text-muted">Nama Balita</label>
                    <input type="text" name="name" class="form-control form-control-lg bg-light border-0" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium text-muted">NIK</label>
                        <input type="text" name="nik" class="form-control bg-light border-0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium text-muted">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control bg-light border-0" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium text-muted">Jenis Kelamin</label>
                        <select name="gender" class="form-select bg-light border-0" required>
                            <option value="">Pilih...</option>
                            <option value="L">Laki-laki (L)</option>
                            <option value="P">Perempuan (P)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium text-muted">Nama Orang Tua</label>
                        <input type="text" name="parent_name" class="form-control bg-light border-0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-medium text-muted">Alamat Lengkap</label>
                    <textarea name="address" rows="2" class="form-control bg-light border-0"></textarea>
                </div>

                <hr class="my-4 text-muted" style="opacity: 0.1;">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3">
                        <i class="fa-solid fa-location-crosshairs text-primary fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-0 text-main">Titik Koordinat Rumah</h6>
                        <small class="text-danger"><i class="fa-solid fa-circle-info"></i> Tentukan lokasi pada peta di samping.</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label small text-muted">Latitude</label>
                        <input type="text" name="latitude" id="lat" class="form-control bg-light border-0" readonly required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label small text-muted">Longitude</label>
                        <input type="text" name="longitude" id="lng" class="form-control bg-light border-0" readonly required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-premium w-100 py-3"><i class="fa-solid fa-floppy-disk me-2"></i> Simpan Data Balita</button>
            </form>
        </div>
    </div>
    
    <div class="col-12 col-xl-7">
        <div class="card-premium p-0 h-100 d-flex flex-column position-relative overflow-hidden premium-shadow border position-relative">
            <div class="p-3 bg-white border-bottom d-flex justify-content-between align-items-center z-3 position-absolute top-0 start-0 w-100" style="z-index: 500;">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-map text-primary me-2"></i> Area Pemetaan</h6>
                <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm d-flex align-items-center" id="btnMyLocation">
                    <i class="fa-solid fa-street-view me-2"></i> Gunakan Lokasi Saya
                </button>
            </div>
            
            <!-- Leaflet Map Container -->
            <div class="flex-grow-1 w-100" style="min-height: 600px; padding-top: 60px;">
                <div id="create-map" class="h-100 w-100" style="z-index: 1;"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Default Center Location (e.g., Jakarta Pusat / Indonesia)
        var initialLat = -6.200000;
        var initialLng = 106.816666;

        // Initialize Map
        var map = L.map('create-map', {
            zoomControl: false // move zoom control later
        }).setView([initialLat, initialLng], 13);

        // Add back zoom control at bottom right to avoid overlap with search/header
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Add TileLayer (Modern / Light Theme CartoDB)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // Add Geocoder Search Control (Leaflet Control Geocoder)
        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Cari desa / alamat...",
            errorMessage: "Tidak ditemukan.",
            position: 'topleft' // placing it under the header
        }).on('markgeocode', function(e) {
            var latlng = e.geocode.center;
            map.setView(latlng, 17);
            updateMarker(latlng.lat, latlng.lng);
        }).addTo(map);
        
        // Push geocoder down a bit to prevent overlapping with our custom header
        document.querySelector('.leaflet-control-geocoder').style.marginTop = '60px';
        document.querySelector('.leaflet-control-geocoder').style.marginLeft = '15px';
        document.querySelector('.leaflet-control-geocoder').style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        document.querySelector('.leaflet-control-geocoder').style.border = 'none';
        document.querySelector('.leaflet-control-geocoder').style.borderRadius = '8px';

        // Custom marker icon using FontAwesome
        var customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: `<div class="d-flex align-items-center justify-content-center" style="color:var(--primary-color); text-shadow: 0 5px 15px rgba(79, 70, 229, 0.4); font-size: 38px; transform: translateY(-50%);"><i class="fa-solid fa-location-dot"></i></div>`,
            iconSize: [38, 38],
            iconAnchor: [19, 19] // Center bottom
        });

        // Initialize marker
        var marker = L.marker([initialLat, initialLng], {
            icon: customIcon,
            draggable: true
        }).addTo(map);

        // Define initial value (can be left blank until user interacts)
        // document.getElementById('lat').value = initialLat.toFixed(8);
        // document.getElementById('lng').value = initialLng.toFixed(8);

        // Function to update inputs and marker
        function updateMarker(lat, lng) {
            marker.setLatLng([lat, lng]);
            document.getElementById('lat').value = lat.toFixed(8);
            document.getElementById('lng').value = lng.toFixed(8);
            
            // Add a subtle bounce animation class temporarily
            var iconDiv = marker.getElement().querySelector('div');
            iconDiv.style.transform = 'translateY(-60%) scale(1.1)';
            setTimeout(() => {
                iconDiv.style.transform = 'translateY(-50%) scale(1)';
            }, 200);
        }

        // Dragging event
        marker.on('dragend', function (event) {
            var position = marker.getLatLng();
            updateMarker(position.lat, position.lng);
        });

        // Clicking on map
        map.on('click', function(e) {
            updateMarker(e.latlng.lat, e.latlng.lng);
        });

        // Native Browser Geolocation API
        const btnMyLocation = document.getElementById('btnMyLocation');
        btnMyLocation.addEventListener('click', function() {
            var btn = this;
            var originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i>Mencari...';
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        
                        map.setView([lat, lng], 18, {animate: true, duration: 1});
                        updateMarker(lat, lng);

                        btn.innerHTML = '<i class="fa-solid fa-check text-success me-2"></i>Ditemukan';
                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        }, 2500);
                    },
                    function(error) {
                        console.error(error);
                        alert("Gagal mendapatkan lokasi. Pastikan izin lokasi aktif di browser Anda.");
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                alert("Browser Anda tidak mendukung fitur Geolocation.");
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    });
</script>
<?= $this->endSection() ?>
