<?php

namespace App\Livewire\Departments;

use App\Exceptions\AppException;
use App\Services\DepartmentService;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentList extends Component
{
    use WithPagination;

    public array $data = [
        'name' => null,
        'description' => null,
    ];

    protected DepartmentService $departmentService;

    public function boot(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    #[Computed()]
    public function departments()
    {
        return $this->departmentService->getAll();
    }

    #[On('department-updated')]
    public function syncDepartments()
    {
        unset($this->departments);
    }

    public function save(string|int|null $id = null)
    {
        $this->validate([
            'data.name' => 'required|string|unique:departments,name,' . $id,
            'data.description' => 'nullable|string|max:1000',
        ], attributes: [
            'data.name' => 'nama jurusan',
            'data.description' => 'deskripsi jurusan'
        ]);

        $this->departmentService->save($this->data);
        $this->syncDepartments();

        if (!$id) {
            $this->reset(['data']);
        }
    }

    public function remove(string|int|null $id)
    {
        if (!$id) {
            notifyMe()->info('Tidak ada jurusan terhapus.');
            return true;
        }

        $deparment = $this->departments->find($id);

        if (!$deparment->delete()) {
            notifyMe()->error('Gagal menghapus jurusan');
            return false;
        }

        $this->syncDepartments();

        notifyMe()->info('Jurusan berhasil dihapus.');
        return true;
    }

    public function exception($e, $stopPropagation)
    {
        if ($e instanceof AppException) {
            notifyMe()->error($e->getUserMessage());
            report($e);

            $stopPropagation();
        }
    }

    public function render()
    {
        return view('livewire.departments.department-list');
    }
}
