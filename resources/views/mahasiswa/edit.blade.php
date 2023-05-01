@extends('mahasiswa.layout')

@section('content')

<div class="container mt-5">

    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 24rem;">
            <div class="card-header">
                Edit Mahasiswa
            </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div> 
        @endif
        <form method="post" action="{{ route('mahasiswa.update', $Mahasiswa->Nim) }}" id="myForm">
        
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="Nim">Nim</label>
            <input type="text" name="Nim" class="formcontrol" id="Nim" aria-describedby="Nim" >
        </div>
        <div class="form-group">
            <label for="Nama">Nama</label>
            <input type="Nama" name="Nama" class="formcontrol" id="Nama" aria-describedby="Nama" >
        </div>
        <div class="form-group">
            <label for="Tanggal_Lahir">Tanggal Lahir</label>
            <input type="date" name="Tanggal_Lahir" class="formcontrol" id="Tanggal_Lahir" aria-describedby="Tanggal_Lahir" >
        </div>
        <!-- <div class="form-group">
            <label for="Kelas">Kelas</label>
            <input type="Kelas" name="Kelas" class="formcontrol" id="Kelas" aria-describedby="password" >
        </div> -->
        <div class="form-group">
            <label for="kelas">Kelas</label>
            <select name ="kelas" class="form-control">
                @foreach ($kelas as $Kelas)
                <option value="{{$Kelas->id}}">{{$Kelas->nama_kelas}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="Jurusan">Jurusan</label>
            <input type="Jurusan" name="Jurusan" class="formcontrol" id="Jurusan" aria-describedby="Jurusan" >
        </div>
        <div class="form-group">
            <label for="No_Handphone">No_Handphone</label>
            <input type="No_Handphone" name="No_Handphone" class="formcontrol" id="No_Handphone" aria-describedby="No_Handphone" >
        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="Email" name="Email" class="formcontrol" id="Email" aria-describedby="Email" >
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
    </div>
 </div>
</div>
@endsection