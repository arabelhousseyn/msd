<?php

namespace App\Support;

use App\Enums\FolderStatus;
use App\Models\Company;
use App\Models\Document;
use App\Models\Folder;
use App\Models\User;

class PerformanceBuilder
{
    public function __construct(private readonly string $type)
    {
    }

    public function init(): array
    {
        return match ($this->type) {
            'cards' => $this->buildCards(),
            'bar' => $this->buildBarChart(),
            default => [],
        };

    }

    private function buildCards(): array
    {
        return [
            [
                'icon' => 'mdi mdi-account-group',
                'title' => __('global.total_users'),
                'value' => User::where('is_admin' , false)->count()
            ],
            [
                'icon' => 'mdi mdi-domain',
                'title' => __('global.total_companies'),
                'value' => Company::where('is_external', true)->count()
            ],
            [
                'icon' => 'mdi mdi-folder',
                'title' => __('global.total_folders'),
                'value' => Folder::count()
            ],
            [
                'icon' => 'mdi mdi-file-account-outline',
                'title' => __('global.total_documents'),
                'value' => Document::count()
            ],
        ];
    }

    private function buildBarChart(): array
    {
        $data = [];
        $months = [1,2,3,4,5,6,7,8,9,10,11,12];
        foreach ($months as $month) {
            $data[] = Folder::whereMonth('created_at',$month)
                ->where('status', FolderStatus::TERMINATED)
                ->count();
        }

        return [
            [
                'label' => __('global.title'),
                'backgroundColor' => '#f87979',
                'data' => $data,
            ]
        ];
    }
}
