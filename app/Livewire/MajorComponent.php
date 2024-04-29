<?php

namespace App\Livewire;

use App\Models\Major;
use Exception;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class MajorComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $isModal = false;

    #[Validate('required|min:3')]
    public $name;
    public $majorId;
    public $search;

    public function create()
    {
        $this->openModal();
    }

    public function store()
    {
        $validated = $this->validateOnly('name');

        Major::create($validated);

        session()->flash("success", "Berhasil ditambahkan!");
        $this->reset('name');
        $this->closeModal();
        $this->resetPage();
    }

    public function edit($id)
    {
        $major = Major::findOrFail($id);

        $this->majorId = $major->id;
        $this->name = $major->name;

        $this->openModal();
    }

    public function update()
    {
        $this->validateOnly('name');

        $major = Major::find($this->majorId)->update([
            'name' => $this->name
        ]);

        session()->flash("success", "Berhasil diubah!");
        $this->reset('name');
        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            $major = Major::findOrFail($id);
            $major->delete();
            session()->flash("success", "Berhasil dihapus!");
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus jurusan!');
            return;
        }
        
    }

    public function openModal()
    {
        $this->isModal = true;
    }

    public function closeModal()
    {
        $this->name = "";
        $this->majorId = "";
        $this->isModal = false;
    }

    public function render()
    {
        return view('livewire.major-component', [
            'majors' => Major::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)
        ]);
    }
}
