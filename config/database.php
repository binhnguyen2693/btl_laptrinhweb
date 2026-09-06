<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $localFile = __DIR__ . '/config.local.php';
    $local = is_file($localFile) ? require $localFile : [];
    $local = is_array($local) ? $local : [];

    $value = static function (string $environmentName, string $localName, string $default) use ($local): string {
        $environmentValue = getenv($environmentName);
        if ($environmentValue !== false) {
            return $environmentValue;
        }
        return isset($local[$localName]) ? (string) $local[$localName] : $default;
    };

    $host = $value('DB_HOST', 'host', '127.0.0.1');
    $port = $value('DB_PORT', 'port', '3306');
    $name = $value('DB_NAME', 'name', 'nhip_khoa');
    $user = $value('DB_USER', 'user', 'root');
    $password = $value('DB_PASSWORD', 'password', '');

    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}
