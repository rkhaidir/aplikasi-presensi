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

  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Nama Kelas</th>
        <th>Jurusan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($grades as $grade)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $grade->name }}</td>
          <td>{{ $grade->major->name }}</td>
          <td>
            <button wire:click="edit({{ $grade->id }})" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
            <button wire:click="delete({{ $grade->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus ini?') || event.stopImmediatePropagation()"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-3">
    {{ $grades->links() }}
  </div>

  @if ($isModal)
    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;">
      <div class="modal-dialog">
        <form wire:submit="{{ $editGradeId ? 'update' : 'store' }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Kelas</h5>
              <button wire:click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="major_id" class="form-label">Jurusan</label>
                <select wire:model="major_id" id="major_id" class="form-control @error('major_id') is-invalid @enderror">
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
                <label for="name" class="form-label">Nama Kelas</label>
                <input wire:model="name" type="text" id="name" class="form-control @error('name') is-invalid @enderror">
                @error('name')
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
