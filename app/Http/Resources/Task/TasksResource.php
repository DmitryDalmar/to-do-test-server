<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TasksResource extends ResourceCollection
{
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
                'user_id' => $item->user_id
            ];
        }

        return [
            'data' => $result,
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage()
            ]
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);

        unset($jsonResponse['links'],$jsonResponse['meta']);

        $response->setContent(json_encode($jsonResponse));
    }
}
