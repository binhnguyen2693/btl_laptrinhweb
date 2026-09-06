<?php
declare(strict_types=1);
require_once __DIR__ . '/app.php';

const PUBLIC_CATEGORIES = [
    'tin-khoa' => 'Tin khoa',
    'hoc-tap' => 'Học tập & Nghiên cứu',
    'co-hoi' => 'Cơ hội',
    'su-kien' => 'Sự kiện',
];

function publicQuery(string $key): string
{
    return isset($_GET[$key]) && is_string($_GET[$key]) ? trim($_GET[$key]) : '';
}

function publicPage(): int
{
    return max(1, (int) publicQuery('page'));
}

function publicPostImage(?string $thumbnail, string $base = ''): string
{
    $fallback = $base . 'assets/images/figma/home-card-1.png';
    $path = trim($thumbnail ?? '');
    if ($path === '') return $fallback;
    if (filter_var($path, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($path, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true)) return $path;
    $path = str_replace('\\', '/', $path);
    if (str_contains($path, '..') || str_contains($path, ':') || str_starts_with($path, '//')) return $fallback;
    $path = ltrim($path, '/');
    if (!str_contains($path, '/')) $path = 'assets/uploads/' . $path;
    if (!str_starts_with($path, 'assets/') && !str_starts_with($path, 'uploads/')) return $fallback;
    return is_file(__DIR__ . '/../' . $path) ? $base . $path : $fallback;
}

function publicPostDate(array $post): string
{
    return date('d/m/Y', strtotime($post['published_at'] ?: $post['created_at']));
}

function publicList(PDO $pdo, ?string $category, string $q, int $page): array
{
    $where = "p.status='published' AND c.status='active'";
    $args = [];
    if ($category !== null) {
        $where .= ' AND c.slug=?';
        $args[] = $category;
    }
    if ($q !== '') {
        $where .= ' AND (p.title LIKE ? OR p.summary LIKE ? OR p.content LIKE ? OR c.name LIKE ? OR u.full_name LIKE ?)';
        $args = array_merge($args, array_fill(0, 5, '%' . $q . '%'));
    }
    $joins = ' FROM posts p JOIN categories c ON c.id=p.category_id JOIN users u ON u.id=p.author_id ';
    $count = $pdo->prepare('SELECT COUNT(*)' . $joins . 'WHERE ' . $where);
    $count->execute($args);
    $total = (int) $count->fetchColumn();
    $pages = max(1, (int) ceil($total / 6));
    $page = max(1, min($page, $pages));
    $stmt = $pdo->prepare('SELECT p.id,p.title,p.summary,p.thumbnail,p.published_at,p.created_at,c.name AS category_name,c.slug AS category_slug,u.full_name AS author_name' . $joins . 'WHERE ' . $where . ' ORDER BY COALESCE(p.published_at,p.created_at) DESC,p.id DESC LIMIT ? OFFSET ?');
    foreach ($args as $i => $arg) $stmt->bindValue($i + 1, $arg, PDO::PARAM_STR);
    $stmt->bindValue(count($args) + 1, 6, PDO::PARAM_INT);
    $stmt->bindValue(count($args) + 2, ($page - 1) * 6, PDO::PARAM_INT);
    $stmt->execute();
    return ['posts' => $stmt->fetchAll(), 'total' => $total, 'pages' => $pages, 'page' => $page];
}

function publicContext(): array
{
    $from = publicQuery('from');
    if (!isset(PUBLIC_CATEGORIES[$from]) && $from !== 'tim-kiem') return [];
    return ['from' => $from, 'q' => publicQuery('q'), 'page' => publicPage()];
}

function publicDetailUrl(int $id, array $context = [], string $base = ''): string
{
    return $base . 'bai-viet.php?' . http_build_query(['id' => $id] + $context);
}

function publicBackUrl(array $context): string
{
    if (!$context) return 'index.php#articles';
    return 'pages/' . $context['from'] . '.php?' . http_build_query(['q' => $context['q'], 'page' => $context['page']]);
}
