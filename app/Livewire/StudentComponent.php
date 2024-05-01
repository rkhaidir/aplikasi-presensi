<?php

namespace App\Livewire;

use App\Models\Grade;
use App\Models\Major;
use App\Models\Student;
use Exception;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class StudentComponent extends Component
{
    use WithPagination;

    public $isModal = false;
    public $grades = [];

    #[Validate('required')]
    public $major_id;

    #[Validate('required')]
    public $grade_id;

    #[Validate('required|min:3')]
    public $fullname;

    #[Validate('required|min:10')]
    public $phone;

    public $editStudentId;
    public $search;

    public function create()
    {
        $this->openModal();
    }

    public function store()
    {
        $validated = $this->validate();

        Student::create($validated);

        session()->flash("success", "Berhasil ditambahkan!");
        $this->reset('fullname', 'phone', 'major_id', 'grade_id');
        $this->closeModal();
        $this->resetPage();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);

        $this->editStudentId = $student->id;
        $this->major_id = $student->major_id;
        $this->grade_id = $student->grade_id;
        $this->fullname = $student->fullname;
        $this->phone = $student->phone;

        $this->openModal();
    }

    public function update()
    {
        $this->validate();

        Student::find($this->editStudentId)->update([
            'fullname' => $this->fullname,
            'phone' => $this->phone,
            'major_id' => $this->major_id,
            'grade_id' => $this->grade_id,
        ]);

        session()->flash("success", "Berhasil diubah!");
        $this->reset('fullname', 'phone', 'major_id', 'grade_id');
        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
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
        $this->major_id = "";
        $this->grade_id = "";
        $this->fullname = "";
        $this->phone = "";
        $this->isModal = false;
    }
    public function render()
    {
        if (!empty($this->major_id)) {
            $this->grades = Grade::where('major_id', $this->major_id)->get();
        }

        return view('livewire.student-component', [
            'majors' => Major::orderBy('name')->get(),
            'students' => Student::latest()->with('major', 'grade')->search($this->search)->paginate(10)
        ]);
    }
}
