<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Mahasiswa_MataKuliah;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user();
        $mahasiswa = Mahasiswa::paginate(5);
        return view('mahasiswa.index', compact('mahasiswa'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create',['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('image')) {
            $image_name = $request->file('image')->store('images', 'public');
        }
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Tanggal_Lahir' => 'required',
            'kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
        ]);
        
        //fungsi eloquent untuk menambah data
        $mahasiswa= new Mahasiswa;
        $mahasiswa->Nim=$request->get('Nim');
        $mahasiswa->Nama=$request->get('Nama');
        $mahasiswa->Foto=$image_name;
        $mahasiswa->Tanggal_Lahir=$request->get('Tanggal_Lahir');
        $mahasiswa->Jurusan=$request->get('Jurusan');
        $mahasiswa->No_Handphone=$request->get('No_Handphone');
        $mahasiswa->Email=$request->get('Email');
        // $mahasiswa->save();
        
        //fungsi eloquent untuk menambah data dengan relasi belongs to
        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::find($Nim);
        $kelas = Kelas::all();
        return view('mahasiswa.edit', compact('Mahasiswa','kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
            $request->validate([
                'Nim' => 'required',
                'Nama' => 'required',
                'Tanggal_Lahir' => 'required',
                'kelas' => 'required',
                'Jurusan' => 'required',
                'No_Handphone' => 'required',
                'Email' => 'required',
            ]);
   
        //fungsi eloquent untuk mengupdate data inputan kita
        $mahasiswa=Mahasiswa::with('kelas')->where('Nim',$Nim)->first();

        if ($mahasiswa->Foto && file_exists(storage_path('app/public/' .$mahasiswa->Foto))) {
            \Storage::delete('public/' . $mahasiswa->Foto);
        }
        $image_name = $request->file('image')->store('images', 'public');
        $mahasiswa->Foto = $image_name;

        $mahasiswa->Nim=$request->get('Nim');
        $mahasiswa->Nama=$request->get('Nama');
        $mahasiswa->Foto=$image_name;
        $mahasiswa->Tanggal_Lahir=$request->get('Tanggal_Lahir');
        $mahasiswa->Jurusan=$request->get('Jurusan');
        $mahasiswa->No_Handphone=$request->get('No_Handphone');
        $mahasiswa->Email=$request->get('Email');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');
            
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
   
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
            Mahasiswa::find($Nim)->delete();
            return redirect()->route('mahasiswa.index')-> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function nilai($Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswa.nilai', compact('Mahasiswa'));
    }

    public function cetak_pdf($Nim){
        $Mahasiswa = Mahasiswa::find($Nim);
        $Matakuliah = Matakuliah::all();
        $MahasiswaMataKuliah = Mahasiswa_MataKuliah::where('mahasiswa_id','=',$Nim)->get();
        $pdf = PDF::loadview('mahasiswa.nilai_pdf', compact('Mahasiswa','MahasiswaMataKuliah'));
        return $pdf->stream();
    }
}