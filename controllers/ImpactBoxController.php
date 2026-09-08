<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/ImpactBox.php';

class ImpactBoxController
{
    private ImpactBox $impactBox;


    /**
     * Khởi tạo Model
     */
    public function __construct()
    {
        $this->impactBox = new ImpactBox();
    }


    /**
     * Lấy danh sách Impact Box
     */
    public function index(int $userId): array
    {
        return $this->impactBox->getByUser($userId);
    }


    /**
     * Kiểm tra bài viết đã được lưu chưa
     */
    public function checkExists(
        int $userId,
        int $postId
    ): bool {

        if ($userId <= 0 || $postId <= 0) {
            return false;
        }

        return $this->impactBox->exists(
            $userId,
            $postId
        );
    }


    /**
     * Thêm bài viết vào Impact Box
     */
    public function add(
        int $userId,
        int $postId,
        ?string $note = null
    ): bool {

        if ($userId <= 0 || $postId <= 0) {
            return false;
        }


        // Không cho lưu trùng
        if ($this->impactBox->exists(
            $userId,
            $postId
        )) {
            return false;
        }


        // Chuẩn hóa ghi chú
        if ($note !== null) {

            $note = trim($note);

            if ($note === '') {
                $note = null;
            }
        }


        // Giới hạn 200 ký tự
        if ($note !== null) {

            $note = mb_substr(
                $note,
                0,
                200
            );
        }


        return $this->impactBox->add(
            $userId,
            $postId,
            $note
        );
    }


    /**
     * Xóa bài viết
     */
    public function delete(
        int $userId,
        int $postId
    ): bool {

        if ($userId <= 0 || $postId <= 0) {
            return false;
        }

        return $this->impactBox->delete(
            $userId,
            $postId
        );
    }


    /**
     * Thêm hoặc sửa ghi chú
     */
    public function updateNote(
        int $userId,
        int $postId,
        ?string $note
    ): bool {

        if ($userId <= 0 || $postId <= 0) {
            return false;
        }


        $note = trim($note ?? '');


        if ($note === '') {
            $note = null;
        }


        if ($note !== null) {

            $note = mb_substr(
                $note,
                0,
                200
            );
        }


        return $this->impactBox->updateNote(
            $userId,
            $postId,
            $note
        );
    }


    /**
     * Xóa ghi chú
     */
    public function clearNote(
        int $userId,
        int $postId
    ): bool {

        if ($userId <= 0 || $postId <= 0) {
            return false;
        }

        return $this->impactBox->clearNote(
            $userId,
            $postId
        );
    }


    /**
     * Lấy một bài viết
     */
    public function getOne(
        int $userId,
        int $postId
    ): ?array {

        if ($userId <= 0 || $postId <= 0) {
            return null;
        }

        return $this->impactBox->getOne(
            $userId,
            $postId
        );
    }
}