<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        // Cek apakah akun admin sudah ada
        $admin = $userModel->where('username', 'admin')->first();

        if (!$admin) {
            $userModel->insert([
                'username' => 'admin',
                'password' => 'admin123', // In a real scenario, this should be password_hash('admin123', PASSWORD_DEFAULT)
                'name'     => 'Administrator Puskesmas',
                'role'     => 'admin'
            ]);
            
            echo "Berhasil membuat default User Admin (admin / admin123)\n";
        } else {
            echo "User Admin sudah ada.\n";
        }
        
        // Buat dummy kader posyandu juga
        $kader = $userModel->where('username', 'kader_melati')->first();
        if (!$kader) {
            $userModel->insert([
                'username' => 'kader_melati',
                'password' => 'kader123',
                'name'     => 'Bunda Melati (Kader)',
                'role'     => 'kader'
            ]);
        }
    }
}
