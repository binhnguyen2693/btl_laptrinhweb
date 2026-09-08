<?php
declare(strict_types=1);
// Unit checks only: never connects to MySQL or loads config.local.php.
require_once __DIR__ . '/../controllers/CategoryController.php';

class CategoryTestDouble extends Category
{
    public int $failure = 0;
    public int $writes = 0;
    public function __construct() {}
    private function result(): bool
    {
        $this->writes++;
        if ($this->failure) {
            $error = new PDOException('Sensitive SQL must not be displayed');
            $error->errorInfo = ['23000', $this->failure, 'private diagnostic'];
            throw $error;
        }
        return true;
    }
    public function add($name, $slug, $description, $status) { return $this->result(); }
    public function update($id, $name, $slug, $description, $status) { return $this->result(); }
    public function delete($id) { return $this->result(); }
}

$reflection = new ReflectionClass(CategoryController::class);
$controller = $reflection->newInstanceWithoutConstructor();
$model = new CategoryTestDouble();
$reflection->getProperty('category')->setValue($controller, $model);
$count = 0;
function check(bool $condition): void {
    global $count;
    if (!$condition) throw new RuntimeException('Failed check ' . ($count + 1));
    $count++;
}
check($controller->add('Sự kiện', 'su-kien', '', 'active'));
check($controller->update(1, 'Sự kiện', 'su-kien', '', 'hidden'));
foreach (['', 'pending', 'ACTIVE'] as $status) {
    $before = $model->writes;
    check(!$controller->add('Sự kiện', 'su-kien', '', $status));
    check($model->writes === $before);
}
check(!$controller->add(str_repeat('a', 121), 'test', '', 'active'));
check(!$controller->add('Test', '', '', 'active'));
$model->failure = 1062;
check(!$controller->add('Sự kiện', 'other', '', 'active'));
check(str_contains($controller->error(), 'đã tồn tại'));
check(!$controller->update(1, 'Other', 'su-kien', '', 'active'));
$model->failure = 1451;
check(!$controller->delete(1));
check(str_contains($controller->error(), 'đang có bài viết'));
$model->failure = 2002;
check(!$controller->add('Test', 'test', '', 'active'));
check(!str_contains($controller->error(), 'Sensitive'));
echo "Category unit checks passed: $count\n";
