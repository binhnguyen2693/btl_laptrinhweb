<?php

require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $category;

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
        return $this->category->add(
            $name,
            $slug,
            $description,
            $status
        );
    }

    // Sửa danh mục
    public function update($id, $name, $slug, $description, $status)
    {
        return $this->category->update(
            $id,
            $name,
            $slug,
            $description,
            $status
        );
    }

    // Xóa danh mục
    public function delete($id)
    {
        return $this->category->delete($id);
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