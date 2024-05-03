<?php

namespace App\Livewire;

use App\Models\Grade;
use App\Models\Major;
use App\Models\Presence;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class MakePresence extends Component
{
    use WithFileUploads;

    public $grades = [];
    public $students = [];

    public $major_id;
    public $grade_id;

    #[Validate('required')]
    public $student_id;

    #[Validate('required|image')]
    public $photo;

    public function store()
    {
        $check = Presence::where([
            ['student_id', '=', $this->student_id],
            ['presence_at', '=', date('Y-m-d')]
        ])->first();

        if ($check) {
            session()->flash('error', "Anda sudah melakukan presensi hari ini");
            $this->reset('major_id', 'grade_id', 'student_id', 'photo');
            return;
        }

        $validate = $this->validate();
        
        $name = $validate['student_id'] . Carbon::now()->timestamp.'.'. $this->photo->extension();

        $this->photo->storeAs('public\photos', $name);

        Presence::create([
            'student_id' => $validate['student_id'],
            'presence_at' => date('Y-m-d'),
            'status' => 'Hadir',
            'photo' => $name
        ]);

        $this->reset('major_id', 'grade_id', 'student_id', 'photo');
        session()->flash("success", "Berhasil melakukan presensi.....");
        $this->redirect('/sukses');
    }

    public function render()
    {
        if (!empty($this->major_id)) {
            $this->grades = Grade::where('major_id', $this->major_id)->get();
        }

        if (!empty($this->grade_id)) {
            $this->students = Student::where([
                ['major_id', '=', $this->major_id],
                ['grade_id', '=', $this->grade_id],
            ])->get();
        }

        return view('livewire.make-presence', [
            'majors' => Major::orderBy("name")->get()
        ]);
    }
}
