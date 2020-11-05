<div class="container mx-auto space-y-4 p-4 sm:p-0">
    <ul class="flex flex-col sm:flex-row sm:space-x-8 sm:items-center">
        <li>
            <input type="checkbox" value="new" wire:model="types"/>
            <span>new</span>
        </li>
        <li>
            <input type="checkbox" value="processing" wire:model="types"/>
            <span>Processing</span>
        </li>
        <li>
            <input type="checkbox" value="error" wire:model="types"/>
            <span>Error</span>
        </li>
        <li>
            <input type="checkbox" value="duplicate" wire:model="types"/>
            <span>Duplicate</span>
        </li>
        <li>
            <input type="checkbox" value="done" wire:model="types"/>
            <span>Done</span>
        </li>
    </ul>

    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="shadow rounded p-4 border bg-white flex-1" style="height: 32rem;">
            <livewire:livewire-column-chart
                key="{{ $columnChartModel->reactiveKey() }}"
                :column-chart-model="$columnChartModel"
            />
        </div>

        <div class="shadow rounded p-4 border bg-white flex-1" style="height: 32rem;">
            <livewire:livewire-pie-chart
                key="{{ $pieChartModel->reactiveKey() }}"
                :pie-chart-model="$pieChartModel"
            />
        </div>
    </div>

    <div class="shadow rounded p-4 border bg-white" style="height: 32rem;">
        <livewire:livewire-line-chart
            key="{{ $lineChartModel->reactiveKey() }}"
            :line-chart-model="$lineChartModel"
        />
    </div>

    <div class="shadow rounded p-4 border bg-white" style="height: 32rem;">
        <livewire:livewire-area-chart
            key="{{ $areaChartModel->reactiveKey() }}"
            :area-chart-model="$areaChartModel"
        />
    </div>
</div>
