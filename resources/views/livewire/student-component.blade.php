<div>
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

  <button wire:click="create" type="button" class="btn btn-primary mb-3">Tambah Data</button>

  <div class="d-flex justify-content-end mb-3">
    <div class="col-md-3">
      <input wire:model.live.debounce.500ms="search" type="text" class="form-control" placeholder="Cari">
    </div>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Nama Siswa</th>
        <th>Kelas</th>
        <th>No. Telepon</th>
        <th>#</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($students as $student)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $student->fullname }}</td>
          <td>{{ $student->grade->name. " " .$student->major->name }}</td>
          <td>{{ $student->phone }}</td>
          <td>
            <button wire:click="edit({{ $student->id }})" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
            <button wire:click="delete({{ $student->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus ini?') || event.stopImmediatePropagation()"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      @empty
        <p>Tidak Ada Data Siswa</p>
      @endforelse
    </tbody>
  </table>

  <div class="mt-3">
    {{ $students->links() }}
  </div>

  @if ($isModal)
    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;">
      <div class="modal-dialog">
        <form wire:submit="{{ $editStudentId ? 'update' : 'store' }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Siswa</h5>
              <button wire:click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="major_id" class="form-label">Jurusan</label>
                <select wire:model.live="major_id" id="major_id" class="form-control @error('major_id') is-invalid @enderror">
                  <option value="">Pilih Jurusan</option>
                  @foreach ($majors as $major)
                    <option value="{{ $major->id }}">{{ $major->name }}</option>
                  @endforeach
                </select>
                @error('major_id')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="grade_id" class="form-label">Kelas</label>
                <select wire:model="grade_id" id="grade_id" class="form-control @error('grade_id') is-invalid @enderror">
                  <option value="">Pilih Kelas</option>
                  @if (count($grades) > 0)
                    @foreach ($grades as $grade)
                      <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endforeach
                  @endif
                </select>
                @error('grade_id')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="fullname" class="form-label">Nama Siswa</label>
                <input wire:model="fullname" type="text" id="fullname" class="form-control @error('fullname') is-invalid @enderror">
                @error('fullname')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">No. Telepon</label>
                <input wire:model="phone" type="text" id="phone" class="form-control @error('phone') is-invalid @enderror">
                @error('phone')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

            </div>

            <div class="modal-footer">
              <button wire:click="closeModal" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="modal-backdrop fade show"></div>
  @endif
</div>
