@extends('layouts.index')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 float-right">
                            <a class="btn btn-md btn-success float-right" href="{{route('presensihadir.create')}}">Presensi Hadir</a>
                        </div>
                        <div class="col-lg-6">
                            <a class="btn btn-md btn-warning" href="{{route('presensipulang.create')}}">Presensi Pulang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection