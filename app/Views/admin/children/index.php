<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card-premium p-4 premium-shadow">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-main m-0"><i class="fa-solid fa-users text-primary me-2"></i> Kelola Data Balita</h4>
        <a href="<?= base_url('admin/children/create') ?>" class="btn btn-primary-premium"><i class="fa-solid fa-plus me-1"></i> Tambah Balita</a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success bg-success bg-opacity-10 text-success border-0 rounded-3 p-3 mb-4">
            <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Balita</th>
                    <th>Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Nama Ortu</th>
                    <th>Posisi (Lat, Lng)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($children)): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada data balita.</td>
                </tr>
                <?php else: ?>
                    <?php $no=1; foreach($children as $child): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-medium text-main"><?= esc($child['name']) ?></td>
                        <td>
                            <?php 
                                $bday = new DateTime($child['birth_date']); // Object
                                $today = new DateTime('today');
                                $age = $bday->diff($today);
                                echo $age->y . ' thn, ' . $age->m . ' bln';
                            ?>
                        </td>
                        <td><?= $child['gender'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <td><?= esc($child['parent_name']) ?></td>
                        <td><small class="text-muted"><i class="fa-solid fa-location-dot text-danger me-1"></i> <?= $child['latitude'] ? $child['latitude'].', '.$child['longitude'] : 'Belum diset' ?></small></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></button>
                            <button class="btn btn-sm btn-outline-warning"><i class="fa-solid fa-pen"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
