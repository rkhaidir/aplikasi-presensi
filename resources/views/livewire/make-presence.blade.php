<div class="card mb-3">

  <div class="card-body">

    <div class="pt-4 pb-2">
      <h5 class="card-title text-center pb-0 fs-4">Silahkan Lakukan Presensi</h5>
    </div>

    @if (session("success"))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if (session("error"))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

    <form class="row g-3" wire:submit.prevent="store">
      <div class="col-12">
        <label for="major_id" class="form-label">Jurusan</label>
          <select wire:model.live="major_id" id="major_id" class="form-control @error('major_id') is-invalid @enderror">
            <option value="">Pilih Jurusan</option>
            @foreach ($majors as $major)
              <option value="{{ $major->id }}">{{ $major->name }}</option>
            @endforeach
          </select>
          @error('major_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-12">
        <label for="grade_id" class="form-label">Kelas</label>
          <select wire:model.live="grade_id" id="grade_id" class="form-control @error('grade_id') is-invalid @enderror">
            <option value="">Pilih Kelas</option>
            @if (count($grades) > 0)
              @foreach ($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
              @endforeach
            @endif
          </select>
          @error('grade_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-12">
        <label for="student_id" class="form-label">Nama</label>
          <select wire:model="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror">
            <option value="">Pilih Nama</option>
            @if (count($students) > 0)
              @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->fullname }}</option>
              @endforeach
            @endif
          </select>
          @error('student_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>

      <div class="col-12 wrapper">
        <div class="file-upload">
          <input type="file" wire:model="photo" id="photo" accept="photo/*" capture="environment">
          <i class="bi bi-camera"></i>
        </div>
      </div>
      @error('photo')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
      <div class="d-flex justify-content-center">
        <div class="spinner-border" role="status" wire:loading wire:target="photo">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

      @if ($photo)
        <img src="{{ $photo->temporaryUrl() }}" width="100" alt="" class="mt-2">
      @endif

      <div class="col-12">
        <button class="btn btn-primary w-100" type="submit">Kirim</button>
      </div>
    </form>

  </div>
</div>