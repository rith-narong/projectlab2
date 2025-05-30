<?php
$pdo = new PDO("mysql:host=127.0.0.1;dbname=your_db_name;charset=utf8", "your_user", "your_password");

// Fetch all users
$stmt = $pdo->query("SELECT id, password FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    // Hash password if not already hashed
    if (!password_get_info($user['password'])['algo']) {
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $update->execute([
            ':password' => $hashedPassword,
            ':id' => $user['id']
        ]);
    }
}

echo "✅ Passwords updated successfully!";
?>
