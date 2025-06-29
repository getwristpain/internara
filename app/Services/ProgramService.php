<?php

namespace App\Services;

use App\Models\Program;
use App\Services\Service;
use App\Services\StatusService;

/**
 * @property StatusService $statusService
 */
class ProgramService extends Service
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        parent::__construct(new Program());
        $this->useServices(
            [
                StatusService::class
            ]
        );
    }

    public function latest(string $status = 'active'): ?Program
    {
        $statusId = $this->statusService->get($status, 'program')->id;

        return $this->model()
            ->query()
            ->latest('created_at')
            ->limit(1)
            ->where('status_id', $statusId)
            ->where('start_date', '<=', now())
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->first();
    }
}
