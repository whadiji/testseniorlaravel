<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProfileResource
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $image
 * @property string $status
 */
class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'image' => asset($this->image),
            'status' => $this->status
        ];

        if (!auth("sanctum")->check()) {
            unset($data['status']);
        }
        return $data;
    }
}
