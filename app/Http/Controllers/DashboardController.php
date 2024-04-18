<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Gudang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
        $gudang = Gudang::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');

            $pendapatan = $total_penjualan - $total_pembelian;
            $data_pendapatan[] = $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        $tanggal_awal = date('Y-m-01');

        $data_gudang = array();
        $data_kepenuhan = array();

        $gudangs = Gudang::all();

        foreach ($gudangs as $gudang1) {
            $data_gudang[] = $gudang1->nama_gudang;

            $ukuran_gudang = $gudang1->ukuran_gudang;
            $ukuran_awal = $gudang1->ukuran_awal;

            $tingkat_kepenuhan = abs((($ukuran_gudang / $ukuran_awal) * 100)-100);
            $tingkat_kepenuhan = round($tingkat_kepenuhan, 2);
            $data_kepenuhan[] = $tingkat_kepenuhan;
        }

        if (auth()->user()->level == 0) {
            return view('admin.dashboard', compact('kategori', 'produk', 'supplier', 'gudang', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan', 'data_gudang', 'data_kepenuhan'));
        } else {
            return view('kasir.dashboard');
        }
    }
}
