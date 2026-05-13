<?php



namespace App\Modules\Customer\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'assigned_to' => $this->assigned_to,
            'assigned_agent_name' => $this->assignedAgent?->name,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}