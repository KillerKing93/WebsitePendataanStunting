<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StuntingGIS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border: 1px solid rgba(255,255,255,0.5);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }

        .login-left {
            background: linear-gradient(135deg, #4F46E5, #818CF8);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right {
            padding: 4rem 3rem;
        }

        .form-control-premium {
            background-color: #F9FAFB;
            border: 1px solid #E5E7EB;
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .form-control-premium:focus {
            background-color: white;
            border-color: #4F46E5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-login {
            background: #4F46E5;
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(79, 70, 229, 0.3);
            background: #4338CA;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row g-0 login-card">
        <div class="col-md-5 d-none d-md-flex login-left position-relative">
            <!-- Decorative circle -->
            <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden" style="z-index: 0;">
                <div class="bg-white rounded-circle position-absolute" style="width: 300px; height: 300px; top: -100px; left: -100px; opacity: 0.1;"></div>
                <div class="bg-white rounded-circle position-absolute" style="width: 200px; height: 200px; bottom: -50px; right: -50px; opacity: 0.1;"></div>
            </div>
            
            <div class="position-relative z-1 text-center">
                <i class="fa-solid fa-baby mb-4" style="font-size: 4rem;"></i>
                <h3 class="fw-bold mb-3">StuntingGIS</h3>
                <p class="text-white-50">Portal pendataan dan pengawasan gizi balita terpadu dengan pemetaan spasial.</p>
            </div>
            
            <a href="<?= base_url() ?>" class="text-white mt-auto position-relative z-1 text-decoration-none small">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
        
        <div class="col-md-7 login-right bg-white">
            <h4 class="fw-bold mb-1 text-dark">Selamat Datang</h4>
            <p class="text-muted mb-4">Silakan masuk dengan akun petugas atau admin pengelola.</p>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger bg-danger bg-opacity-10 text-danger border-0 rounded-3 p-3 mb-4">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/process') ?>" method="post">
                <div class="mb-4">
                    <label class="form-label fw-medium text-secondary small text-uppercase letter-spacing-1">Username / NIP</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 border" style="border-radius: 12px 0 0 12px;"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control form-control-premium border-start-0 ps-0" placeholder="Masukkan username" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium text-secondary small text-uppercase letter-spacing-1">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 border" style="border-radius: 12px 0 0 12px;"><i class="fa-solid fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control form-control-premium border-start-0 ps-0" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label small text-muted" for="rememberMe">Ingat saya</label>
                    </div>
                    <!-- Ignore for now -->
                </div>

                <button type="submit" class="btn btn-login w-100">
                    Masuk ke Sistem <i class="fa-solid fa-arrow-right ms-2"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
