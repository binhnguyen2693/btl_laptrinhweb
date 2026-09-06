<?php

require_once __DIR__ . '/../models/ImpactBox.php';

class ImpactBoxController
{
    private $impactBox;


    /**
     * Khởi tạo Model ImpactBox
     */
    public function __construct()
    {
        $this->impactBox = new ImpactBox();
    }


    /**
     * Lấy toàn bộ bài viết
     * trong Impact Box của người dùng
     */
    public function index($userId)
    {
        return $this->impactBox->getByUser($userId);
    }


    /**
     * Kiểm tra bài viết đã được lưu
     * vào Impact Box hay chưa
     */
    public function checkExists($userId, $postId)
    {
        if ((int)$userId <= 0 || (int)$postId <= 0) {
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
    public function add($userId, $postId, $note = null)
    {
        if ((int)$userId <= 0 || (int)$postId <= 0) {
            return false;
        }

        /*
         * Không cho phép lưu trùng bài viết.
         */
        if ($this->impactBox->exists(
            $userId,
            $postId
        )) {
            return false;
        }

        /*
         * Chuẩn hóa ghi chú.
         */
        if ($note !== null) {
            $note = trim($note);

            if ($note === '') {
                $note = null;
            }
        }

        return $this->impactBox->add(
            $userId,
            $postId,
            $note
        );
    }


    /**
     * Xóa bài viết khỏi Impact Box
     */
    public function delete($userId, $postId)
    {
        if ((int)$userId <= 0 || (int)$postId <= 0) {
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
        $userId,
        $postId,
        $note
    ) {
        if ((int)$userId <= 0 || (int)$postId <= 0) {
            return false;
        }

        $note = trim($note);

        /*
         * Nếu người dùng xóa hết nội dung
         * thì lưu NULL.
         */
        if ($note === '') {
            $note = null;
        }

        /*
         * Giới hạn ghi chú theo giao diện
         * hiện tại là 200 ký tự.
         */
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
     * Xóa ghi chú nhưng vẫn giữ bài viết
     * trong Impact Box
     */
    public function clearNote($userId, $postId)
    {
        if ((int)$userId <= 0 || (int)$postId <= 0) {
            return false;
        }

        return $this->impactBox->clearNote(
            $userId,
            $postId
        );
    }


    /**
     * Lấy một bài viết cụ thể
     * trong Impact Box
     */
    public function getOne($userId, $postId)
    {
        if ((int)$userId <= 0 || (int)$postId <= 0) {
            return null;
        }

        return $this->impactBox->getOne(
            $userId,
            $postId
        );
    }
}