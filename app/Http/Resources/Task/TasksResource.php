<?php

namespace App\Http\Resources\Task;

use App\Traits\Resources\ListResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TasksResource extends ResourceCollection
{
    use ListResource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function toArray($request)
    {
        $result = [];

        foreach ($this->collection as &$item) {
            $result[] = [
                'id' => (integer) $item->id,
                'title' => (string) $item->title,
                'description' => (string) $item->description,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        }

        return $this->getListResult($result);
    }
}
