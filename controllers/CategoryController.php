<?php

require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $category;
    private string $message = '';

    public function error(): string
    {
        return $this->message ?: 'Không thể cập nhật danh mục. Vui lòng thử lại.';
    }

    private function validate($name, $slug, $status): bool
    {
        $this->message = '';
        if (trim($name) === '' || trim($slug) === '' || mb_strlen($name) > 120 || mb_strlen($slug) > 150) {
            $this->message = 'Tên và slug không được trống; tối đa 120 ký tự cho tên, 150 ký tự cho slug.';
        } elseif (!in_array($status, ['active', 'hidden'], true)) {
            $this->message = 'Trạng thái danh mục không hợp lệ.';
        }
        return $this->message === '';
    }

    private function write(callable $operation): bool
    {
        try {
            return (bool) $operation();
        } catch (PDOException $e) {
            $code = (int) ($e->errorInfo[1] ?? 0);
            $this->message = match ($code) {
                1062 => 'Tên danh mục hoặc slug đã tồn tại. Vui lòng chọn giá trị khác.',
                1451 => 'Không thể xóa danh mục đang có bài viết.',
                default => 'Không thể cập nhật danh mục. Vui lòng thử lại.',
            };
            return false;
        }
    }

    public function __construct()
    {
        $this->category = new Category();
    }

    // Danh sách danh mục
    public function index()
    {
        return $this->category->getAll();
    }

    // Lấy một danh mục
    public function getOne($id)
    {
        return $this->category->getById($id);
    }

    // Thêm danh mục
    public function add($name, $slug, $description, $status)
    {
        if (!$this->validate($name, $slug, $status)) return false;
        return $this->write(fn() => $this->category->add(
            $name,
            $slug,
            $description,
            $status
        ));
    }

    // Sửa danh mục
    public function update($id, $name, $slug, $description, $status)
    {
        if (!$this->validate($name, $slug, $status)) return false;
        return $this->write(fn() => $this->category->update(
            $id,
            $name,
            $slug,
            $description,
            $status
        ));
    }

    // Xóa danh mục
    public function delete($id)
    {
        return $this->write(fn() => $this->category->delete($id));
    }

    // Tìm kiếm danh mục
    public function search($keyword, $status = 'all')
    {
        return $this->category->search(
            $keyword,
            $status
        );
    }
}
