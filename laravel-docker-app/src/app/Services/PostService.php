<?php

namespace App\Services;

use App\Repositories\PostRepository;

// ビジネスロジックを担当するクラス
class PostService
{
    // LaravelがPostRepositoryを自動で渡してくれる（依存性注入）
    public function __construct(
        private PostRepository $postRepository
    ) {
    }

    // 全件取得をRepositoryに依頼
    public function getAllPosts()
    {
        return $this->postRepository->getAll();
    }

    // 1件取得をRepositoryに依頼
    public function getPostById(int $id)
    {
        return $this->postRepository->findById($id);
    }

    // 作成をRepositoryに依頼
    public function createPost(array $data)
    {
        return $this->postRepository->create($data);
    }

    // 更新をRepositoryに依頼
    public function updatePost($post, array $data)
    {
        return $this->postRepository->update($post, $data);
    }

    // 削除をRepositoryに依頼
    public function deletePost($post)
    {
        return $this->postRepository->delete($post);
    }
}
