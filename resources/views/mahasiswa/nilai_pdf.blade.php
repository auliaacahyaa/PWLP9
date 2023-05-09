<html>
<head>
    <title>Laporan Penilaian Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div style="text-align:center">
                <h6>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h6><br>
                <h4>Kartu Hasil Studi (KHS)</h4>
            </div><br>
                <ul class="list-group list-group-flush">
                    <li class="list-group"><b>Nama  : </b>{{$Mahasiswa->Nama}}</li>
                    <li class="list-group"><b>Nim   : </b>{{$Mahasiswa->Nim}}</li>
                    <li class="list-group"><b>Kelas : </b>{{$Mahasiswa->kelas->nama_kelas}}</li>
                </ul><br>
                    <table class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Nilai</th>
                            </tr>
                            @foreach ($Mahasiswa->matakuliah as $matkul)
                            <tr>
                                <td>{{ $matkul->nama_matkul }}</td>
                                <td>{{ $matkul->sks }}</td>
                                <td>{{ $matkul->semester }}</td>
                                <td>{{ $matkul->pivot->nilai }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </table>
                </div>
            </div>
        </div>
</body>
</html>