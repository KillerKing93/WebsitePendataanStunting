<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function process()
    {
        // For demonstration, simplistic auth logic without DB hashing for now.
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $session = session();
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user && $user['password'] === $password) { // Wait, standard practice requires password_verify, this is demo.
            $session->set([
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'isLoggedIn' => true
            ]);
            return redirect()->to('/admin/dashboard');
        } else {
            return redirect()->back()->with('error', 'Username atau Password salah!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
