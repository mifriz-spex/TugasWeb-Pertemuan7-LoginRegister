<?php
session_start();

// Jika sudah login, arahkan ke dashboard (proteksi)
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

// Inisialisasi variabel untuk pesan error & sukses yang jelas
$error = '';
$success = '';

// Menangani ketika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitasi input dengan htmlspecialchars()
    $nama = htmlspecialchars(trim($_POST['nama'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? ''; // Password tidak perlu disanitasi karena akan di-hash

    // Form registrasi dengan validasi (nama, email, password) tidak boleh kosong[cite: 1]
    if (empty($nama) || empty($email) || empty($password)) {
        $error = 'Semua kolom wajib diisi!';
    } 
    // Validasi email dengan filter_var()[cite: 1]
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid!';
    } 
    else {
        $file_json = 'data/users.json';
        $users = [];

        // Memastikan folder data ada
        if (!is_dir('data')) {
            mkdir('data', 0777, true);
        }

        // Membaca file JSON jika sudah ada
        if (file_exists($file_json)) {
            $json_data = file_get_contents($file_json);
            $users = json_decode($json_data, true) ?? [];
        }

        // Cek duplikasi email saat registrasi[cite: 1]
        $email_exist = false;
        foreach ($users as $user) {
            if (isset($user['email']) && $user['email'] === $email) {
                $email_exist = true;
                break;
            }
        }

        if ($email_exist) {
            $error = 'Email sudah terdaftar. Silakan gunakan email lain atau masuk.';
        } else {
            // Password di-hash dengan password_hash()[cite: 1]
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Data yang akan disimpan ke file JSON[cite: 1]
            $new_user = [
                'nama' => $nama,
                'email' => $email,
                'password' => $hashed_password
            ];

            $users[] = $new_user; // Tambahkan user baru ke array

            // Simpan kembali ke file JSON
            if (file_put_contents($file_json, json_encode($users, JSON_PRETTY_PRINT))) {
                $success = 'Registrasi berhasil! Silakan Masuk (Login).';
            } else {
                $error = 'Sistem gagal menyimpan data.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Tugas Rutin 7</title>
    <!-- Bonus: Tampilan CSS yang rapi[cite: 1] -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white h-screen flex items-center justify-center font-sans">
    
    <div class="bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700 w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Buat Akun</h2>

        <!-- Area Pesan Error & Sukses yang Jelas[cite: 1] -->
        <?php if ($error): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-400 p-3 rounded-lg mb-4 text-sm">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-500/20 border border-green-500 text-green-400 p-3 rounded-lg mb-4 text-sm">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="nama" class="block text-sm text-gray-400 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
            </div>

            <div>
                <label for="email" class="block text-sm text-gray-400 mb-1">Alamat Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div>
                <label for="password" class="block text-sm text-gray-400 mb-1">Kata Sandi</label>
                <input type="password" name="password" id="password" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 text-white">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200 mt-2">
                Daftar
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
            Sudah punya akun? <a href="login.php" class="text-blue-400 hover:underline">Masuk di sini</a>
        </p>
    </div>

</body>
</html>