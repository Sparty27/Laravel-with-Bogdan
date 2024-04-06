<?php

namespace App\Jobs\NovaPoshta;

use App\Services\NovaPoshtaService\NovaPoshtaWarehouseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateWarehouseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(NovaPoshtaWarehouseService $service): void
    {
        ini_set('memory_limit', '-1');
        $service->update();
    }
}
