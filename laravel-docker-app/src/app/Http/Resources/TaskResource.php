<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,        // タイトル
            'body'         => $this->body,          // 本文
            'is_completed' => $this->is_completed,  // 完了フラグ
            'created_at'   => $this->created_at->toDateString(), // 作成日
        ];
    }
}
