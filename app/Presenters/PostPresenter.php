<?php

namespace App\Presenters;

use AdditionApps\FlexiblePresenter\FlexiblePresenter;

class PostPresenter extends FlexiblePresenter
{
    public function values(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'thumbnail' => $this->thumbnial,
            'visits' => $this->visits,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_ago' => $this->created_at->diffForHumans(),
            'published' => $this->published,
        ];
    }
}
