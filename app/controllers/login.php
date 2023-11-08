<?php
class Login extends Controller
{
    public function index()
    {
        session_start(); // Mulai sesi di sini

        if (isset($_SESSION['user_id'])) {
            // Jika pengguna sudah login, alihkan ke halaman beranda atau halaman lain yang sesuai
            if ($_SESSION['level'] === 'superadmin') {
                header('Location: ' . BASEURL . '/Superadmin');
            } elseif ($_SESSION['level'] === 'admin') {
                header('Location: ' . BASEURL . '/admin');
            } else {
                header('Location: ' . BASEURL);
            }
            exit;
        }

        if (isset($_POST['login'])) {
            session_start(); // Mulai sesi di sini

            if (isset($_SESSION['user_id'])) {
                // Jika pengguna sudah login, alihkan ke halaman beranda atau halaman lain yang sesuai
                if ($_SESSION['level'] === 'superadmin') {
                    header('Location: ' . BASEURL . '/Superadmin');
                } elseif ($_SESSION['level'] === 'admin') {
                    header('Location: ' . BASEURL . '/admin');
                } else {
                    header('Location: ' . BASEURL);
                }
                exit;
            }

            $this->prosesLogin();
        } else {
            $data['judul'] = 'Login';
            $this->view('templates/header', $data);
            $this->view('login/login');
            $this->view('templates/admin-footer');
        }
    }

    public function registrasi()
    {
        $data['judul'] = 'Registrasi';
        $this->view('templates/header', $data);
        $this->view('login/registrasi');
        $this->view('templates/admin-footer');
    }

    public function tambah()
    {
        if ($this->model('Users_Model')->tambahDataUser($_POST) > 0) {
            header('Location:' . BASEURL . '/login');
            exit;
        }
    }

    public function Authuser()
    {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['level'] === 'admin') {
                header('Location: ' . BASEURL . '/admin'); // Pengguna dengan peran admin
            } elseif ($_SESSION['level'] === 'superadmin') {
                header('Location: ' . BASEURL . '/superadmin'); // Pengguna dengan peran super admin
            } else {
                header('Location: ' . BASEURL); // Pengguna lain
            }
            exit;
        }
    }

    public function prosesLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = $this->model('Users_Model');
            $user = $userModel->getUserByEmail($email);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    session_start(); // Mulai sesi di sini
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['level'] = $user['level'];

                    if ($user['level'] === 'admin') {
                        header('Location: ' . BASEURL . '/admin');
                    } else {
                        header('Location: ' . BASEURL);
                    }

                    exit;
                } else {
                    $pesan = 'Password salah.';
                    $this->tampilkanPesanError($pesan);
                }
            } else {
                $pesan = 'Email tidak ditemukan.';
                $this->tampilkanPesanError($pesan);
            }
        }
    }


    public function prosesLogout()
    {
        session_start();
        session_destroy();

        header('Location: ' . BASEURL . '/login');
        exit();
    }

    private function tampilkanPesanError($pesan)
    {
        $data['pesan'] = $pesan;
        $data['judul'] = 'Login';
        $this->view('templates/header', $data);
        $this->view('login/login', $data);
        $this->view('templates/footer');
    }
}
