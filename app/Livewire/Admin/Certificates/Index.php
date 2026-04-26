<?php

namespace App\Livewire\Admin\Certificates;

use App\Models\Certificate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public int $perPage = 20;

    protected function queryString(): array
    {
        return [
            'perPage' => ['except' => 20],
        ];
    }

    public function render()
    {
        $certificates = Certificate::query()
            ->with(['user:id,name,email', 'course:id,title,slug'])
            ->latest('issued_at')
            ->paginate($this->perPage);

        return view('livewire.admin.certificates.index', [
            'certificates' => $certificates,
        ]);
    }
}
