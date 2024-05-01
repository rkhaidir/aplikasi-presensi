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
        <th>Nama Jurusan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($majors as $major)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $major->name }}</td>
          <td>
            <button wire:click="edit({{ $major->id }})" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
            <button wire:click="delete({{ $major->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus ini?') || event.stopImmediatePropagation()"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      @empty
        <p>Tidak ada data</p>
      @endforelse
    </tbody>
  </table>

  <div class="mt-3">
    {{ $majors->links() }}
  </div>

  @if ($isModal)
    <div class="modal fade show" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;">
      <div class="modal-dialog">
        <form wire:submit="{{ $majorId ? 'update' : 'store' }}">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Jurusan</h5>
              <button wire:click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="name" class="form-label">Nama Jurusan</label>
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
