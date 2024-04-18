<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\Gudang;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.index');
    }

    public function data()
    {
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();

        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_item', function ($penjualan) {
                return uang_indonesia($penjualan->total_item);
            })
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp. '. uang_indonesia($penjualan->total_harga);
            })
            ->addColumn('bayar', function ($penjualan) {
                return 'Rp. '. uang_indonesia($penjualan->bayar);
            })
            ->addColumn('tanggal', function ($penjualan) {
                return tanggal_indonesia($penjualan->created_at, false);
            })
            ->editColumn('diskon', function ($penjualan) {
                return $penjualan->diskon . '%';
            })
            ->editColumn('kasir', function ($penjualan) {
                return $penjualan->user->name ?? '';
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('penjualan.show', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('penjualan.destroy', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'id_penjualan'])
            ->make(true);
    }

    public function create()
    {
        $penjualan = new Penjualan();
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = auth()->id();
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);
        return redirect()->route('transaksi.index');
    }

    public function store(Request $request)
    {
        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        $penjualan->total_item = $request->total_item;
        $penjualan->total_harga = $request->total;
        $penjualan->diskon = $request->diskon;
        $penjualan->bayar = $request->bayar;
        $penjualan->diterima = $request->diterima;
        $penjualan->update();

        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();

        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $gudang = Gudang::find($produk->id_gudang);
            $selisih_jumlah = $item->jumlah_awal - $item->jumlah ;

            if ($selisih_jumlah > 0) {
                $tambahan_stok = $selisih_jumlah + 1;
                $produk->stok += $tambahan_stok;
                $produk->update();

                $ukuran_tambahan_gudang = $tambahan_stok * $produk->ukuran_produk;
                $gudang->ukuran_gudang -= $ukuran_tambahan_gudang;
                $gudang->update();
            } elseif ($selisih_jumlah < 0) {
                $pengurangan_stok = abs($selisih_jumlah);
                $produk->stok -= $pengurangan_stok;
                $produk->update();

                $ukuran_pengurangan_gudang = $pengurangan_stok * $produk->ukuran_produk;
                $gudang->ukuran_gudang += $ukuran_pengurangan_gudang;
                $gudang->update();
            }

            if ($produk->stok < 0 || $gudang->ukuran_gudang < 0) {
                $penjualan->delete();
                return redirect()->route('penjualan_detail.index')
                    ->with('error', 'Jumlah stok produk atau ukuran gudang tidak mencukupi. Silakan ubah jumlah item yang diinginkan.');
            }

            $item->jumlah_awal = 0;
            $item->update();
        }

        return redirect()->route('transaksi.selesai');
    }


    public function show($id)
    {
        $detail = PenjualanDetail::with('produk')->where('id_penjualan', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">'. $detail->produk->kode_produk .'</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. '. uang_indonesia($detail->harga_jual);
            })
            ->addColumn('jumlah', function ($detail) {
                return uang_indonesia($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. uang_indonesia($detail->subtotal);
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $detail    = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $gudang = Gudang::find($produk->id_gudang);
            $ukuran_total_produk = $item->jumlah * $produk->ukuran_produk;
            $gudang->ukuran_gudang -= $ukuran_total_produk;
            $gudang->update();
            if ($produk) {
                $produk->stok += $item->jumlah;
                $produk->update();
            }

            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }

    public function selesai()
    {
        $setting = Setting::first();

        return view('penjualan.selesai', compact('setting'));
    }

    public function notaKecil()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        return view('penjualan.nota_kecil', compact('setting', 'penjualan', 'detail'));
    }

}
