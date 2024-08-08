@extends('layouts.index2')
@section('content')
    <div class="row">
    <div class="col">
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('sukses'))
            <div class="alert alert-success alert-dismissible fade show col-md" role="alert">
            {{$message}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            @endif
            @if ($message = Session::get('gagal'))
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>{{ $message }}</p>
            </div>
            @endif
            <form action="{{ route('presensipulang.store') }}" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @method('POST')
            <!-- id -->
            <div class="form-group mb-3">
                <label for="">ID Guru</label>
                <input type="text" class="form-control" placeholder="Masukkan ID Guru disini..." name="id_dataguru" value="{{ old('id_dataguru') }}" id="id_dataguru">
                @error('id_dataguru') <small class="text-danger"> {{ $message }} </small> @enderror
            </div>
            <!-- akhir id -->

            <!-- preview -->
            <div class="form-group">
                <video id="preview" class="col-md-4"></video><br>
                <p class="text-info">Posisikan QR Code Anda didalam Kotak</p>
            </div>
            <!-- akhir preview -->
        </div>
        <div class="card-footer">
            <!-- <button type="submit" class="btn btn-dark btn-sm">Save</button> -->
            <a href="{{route('presensipulang.index')}}" class="btn btn-warning btn-sm" >Data Presensi Pulang</a>
            </form>
        </div>
        </div>
    </div>
    </div>

    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- script instacamera -->
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
          video: document.getElementById('preview')
        });
        scanner.addListener('scan', function(content) {
          console.log(content);
        });
        Instascan.Camera.getCameras().then(function(cameras) {
          if (cameras.length > 0) {
            scanner.start(cameras[0]);
          } else {
            console.error('No cameras found.');
          }
        }).catch(function(e) {
          console.error(e);
        });
        scanner.addListener('scan', function(c) {
          document.getElementById('id_dataguru').value = c;
          document.getElementById('form').submit();
        })
    </script>
@endsection