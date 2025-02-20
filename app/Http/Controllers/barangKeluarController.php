<?php

namespace App\Http\Controllers;

use App\Models\barangKeluar;
use App\Models\pelanggan;
use App\Models\stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class barangKeluarController extends Controller
{
    public function index()
    {

        return view('Barang.BarangKeluar.Barang-keluar');
    }

    public function create()
    {
        $data = barangKeluar::all();

        $lastId = barangKeluar::max('id');
        $lastId = $lastId ? $lastId : 0; //ternary operator

        if ($data->isEmpty()) {
            $nextId = $lastId + 1;
            $date= now()->format('d/m/Y');
            $kode_transaksi = 'TRK'. $nextId . '/' . $date;

            $pelanggan = pelanggan::all();

            return view('Barang.BarangKeluar.add-barang-Keluar', compact(
                'data',
                'kode_transaksi',
                'pelanggan'
            ));
        }
        $latesitem = barangKeluar::latest()->first();
        $id = $latesitem->id;
        $date = $latesitem->created_at->format('d/m/Y');
        $kode_transaksi = 'TRK' . ($id+1) . '/' . $date;
        $pelanggan = pelanggan::all();


        return view('Barang.BarangKeluar.add-barang-Keluar',compact(
            'data',
            'kode_transaksi',
            'pelanggan',
        ));

    }

    public function store(Request $request)
    {
        $request->validate([

            'tgl_faktur' => 'required',
            'tgl_jatuh_tempo' => 'required',
            'pelanggan_id' => 'required',
            'jenis_pembayaran' => 'required'
        ], [

            'tgl_faktur.required' => 'data wajib diisi',
            'tgl_jatuh_tempo.required' => 'data wajib diisi',
            'pelanggan_id.required' => 'data wajib diisi',
            'jenis_pembayaran.required' => 'data wajib diisi',
        ]);

        $kode_transaksi = $request->kode_transaksi;
        $tgl_faktur = $request->tgl_faktur;
        $tgl_jatuh_tempo  = $request->tgl_jatuh_tempo;
        $pelanggan_id = $request->pelanggan_id;

        $getNamaPelanggan = pelanggan::find($pelanggan_id);
        $namaPelanggan = $getNamaPelanggan->nama_pelanggan;
        $jenis_pembayaran = $request->jenis_pembayaran;

        $getBarang = stok::all();

        return view('Transaksi.transaksi', compact(
            'kode_transaksi',
            'tgl_faktur',
            'tgl_jatuh_tempo',
            'pelanggan_id',
            'namaPelanggan',
            'jenis_pembayaran',
            'getBarang',
        ));
    }
    public function saveBarangKeluar(Request $request)
    {
        $request->validate([
            'ode_transaksi' => 'required',
            'tgl_faktur' => 'required',
            'tgl_jatuh_tempo' => 'required',
            'pelanggan_id' => 'required',
            'jenis_pembayaran' => 'required',
            'barang_id' => 'required',
            'jumlah_beli' => 'required',
            'harga_jual' => 'required',
        ]);
        $save = new barangKeluar();
        $save->kode_transaksi = $request->kode_transaksi;
        $save->tgl_faktur = $request->tgl_faktur;
        $save->tgl_jatuh_tempo = $request->tgl_jatuh_tempo;
        $save->pelanggan_id -> $request->pelanggan_id;
        $save->jenis_pembayran = $request->jenis_pembayran;
        $save->barang_id = $request->barang_id;
        $save->jumlah_beli = $request->jumlah_beli;
        $save->harga_jual = $request->harga_jual;

         $getStokData = stok::find($request->barang_id);
            $getJumlahStok = $getStokData->stok;
        $getStokData->stok = $getJumlahStok - $request->jumlah_beli;
         $getStokData->save();

         $diskon = $request->diskon;
            $nilaiDiskon = $diskon/100;
        
        if ($diskon) {
            $save->diskon = $request->diskon;
                $hitung = $request->jumlah_beli * $request->harga_jual;
                $totalDiskon = $hitung * $nilaiDiskon;
                $subTotal = $totalDiskon - $nilaiDiskon;
            $save->sub_total = $subTotal;
        } else {
            $hitung = $request->jumlah_beli * $request->harga_jual;
            $save->sub_total = $hitung;
        }

        $save->user_id = Auth::user()->id;
        $save->tgl_buat = $request->tgl_faktur;
        $save->save();

        return redirect('/barang-keluar')->with(
            'message',
            'Barang keluar add',
        );






    }


    }



    //kode_transaksi
    //tgl_faktur
    //tgl_jatuh_tempo
    //pelanggan_id
    //jenis_pembayaran
    //barang_id
    //jumlah_beli
    //harga_jual
    //diskon
    //sub_total
    //user_id
    //tgl_buat
