@extends('layouts.presence')

@section('content')
  <div class="card">
    <div class="card-body text-center py-5 px-4">
      <img src="{{ asset('assets/img/logo.png') }}" alt="" class="my-3">

      @if (session('success'))
        <h3 class="text-success fw-bold">Sukses</h3>
        <p>{{ session('success') }}</p>
      @endif

      <div class="mt-3">
        <a href="{{ route('presensi') }}" class="btn btn-success">Kembali</a>
      </div>
    </div>
  </div>
@endsection
