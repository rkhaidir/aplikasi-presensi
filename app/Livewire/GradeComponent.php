<?php

namespace App\Livewire;

use App\Models\Grade;
use App\Models\Major;
use Exception;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class GradeComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $isModal = false;

    #[Validate('required')]
    public $major_id;
    #[Validate('required|min:1')]
    public $name;

    public $editGradeId;

    public function create()
    {
        $this->openModal();
    }

    public function store()
    {
        $validated = $this->validate();

        Grade::create($validated);

        session()->flash("success", "Berhasil ditambahkan!");
        $this->reset('major_id', 'name');
        $this->closeModal();
        $this->resetPage();
    }

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);

        $this->editGradeId = $grade->id;
        $this->major_id = $grade->major_id;
        $this->name = $grade->name;

        $this->openModal();
    }

    public function update()
    {
        $this->validate();

        Grade::find($this->editGradeId)->update([
            'major_id' => $this->major_id,
            'name' => $this->name
        ]);

        session()->flash("success", "Berhasil diubah!");
        $this->reset('name', 'major_id');
        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            $grade = Grade::findOrFail($id);
            $grade->delete();
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
        $this->major_id = '';
        $this->name = '';
        $this->isModal = false;
    }
    public function render()
    {
        return view('livewire.grade-component', [
            'majors' => Major::all(),
            'grades' => Grade::latest()->with('major')->paginate(5)
        ]);
    }
}
