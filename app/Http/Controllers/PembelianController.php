<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Gudang;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('nama')->get();

        return view('pembelian.index', compact('supplier'));
    }

    public function data()
    {
        $pembelian = Pembelian::orderBy('id_pembelian', 'desc')->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_item', function ($pembelian) {
                return uang_indonesia($pembelian->total_item);
            })
            ->addColumn('total_harga', function ($pembelian) {
                return 'Rp. '. uang_indonesia($pembelian->total_harga);
            })
            ->addColumn('bayar', function ($pembelian) {
                return 'Rp. '. uang_indonesia($pembelian->bayar);
            })
            ->addColumn('tanggal', function ($pembelian) {
                return tanggal_indonesia($pembelian->created_at, false);
            })
            ->addColumn('supplier', function ($pembelian) {
                return $pembelian->supplier->nama;
            })
            ->editColumn('diskon', function ($pembelian) {
                return $pembelian->diskon . '%';
            })
            ->addColumn('aksi', function ($pembelian) {
                return '
                <div class="btn-group">
                    <button onclick="showDetail(`'. route('pembelian.show', $pembelian->id_pembelian) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`'. route('pembelian.destroy', $pembelian->id_pembelian) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create($id)
    {
        $pembelian = new Pembelian();
        $pembelian->id_supplier = $id;
        $pembelian->total_item  = 0;
        $pembelian->total_harga = 0;
        $pembelian->diskon      = 0;
        $pembelian->bayar       = 0;
        $pembelian->save();

        session(['id_pembelian' => $pembelian->id_pembelian]);
        session(['id_supplier' => $pembelian->id_supplier]);

        return redirect()->route('pembelian_detail.index');
    }

    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->id_pembelian);
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->diskon = $request->diskon;
        $pembelian->bayar = $request->bayar;
        $pembelian->update();

        $detail = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        $ukuranGudangCukup = true;

        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $gudang = Gudang::find($produk->id_gudang);
            $selisih_jumlah =  $item->jumlah - $item->jumlah_awal;

            if ($selisih_jumlah > 0) {
                $tambahan_stok = $selisih_jumlah + 1;
                $produk->stok += $tambahan_stok;
                $produk->update();

                $ukuran_tambahan_gudang = $tambahan_stok * $produk->ukuran_produk;
                if ($gudang->ukuran_gudang < $ukuran_tambahan_gudang) {
                    $ukuranGudangCukup = false;
                    $produk->stok -= $tambahan_stok;
                    $produk->update();
                    break;
                } else {
                    $gudang->ukuran_gudang -= $ukuran_tambahan_gudang;
                    $gudang->update();
                }
            } elseif ($selisih_jumlah < 0) {
                $pengurangan_stok = abs($selisih_jumlah);
                $produk->stok -= $pengurangan_stok;
                $produk->update();

                $ukuran_pengurangan_gudang = $pengurangan_stok * $produk->ukuran_produk;
                $gudang->ukuran_gudang += $ukuran_pengurangan_gudang;
                $gudang->update();
            }
            $item->jumlah_awal = 0;
            $item->update();
        }
        if (!$ukuranGudangCukup) {
            PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->delete();
            $pembelian->delete();
            return redirect()->route('pembelian_detail.index')
                ->with('error', 'Ukuran gudang tidak mencukupi. Silakan masukkan kembali jumlah item yang diinginkan.');
        }

        return redirect()->route('pembelian.index')->with('success', 'Data berhasil ditambahkan');
    }


    public function show($id)
    {
        $detail = PembelianDetail::with('produk')->where('id_pembelian', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">'. $detail->produk->kode_produk .'</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_beli', function ($detail) {
                return 'Rp. '. uang_indonesia($detail->harga_beli);
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
        $pembelian = Pembelian::find($id);
        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $gudang = Gudang::find($produk->id_gudang);
            $ukuran_total_produk = $item->jumlah * $produk->ukuran_produk;
            $gudang->ukuran_gudang += $ukuran_total_produk;
            $gudang->update();
            if ($produk) {
                $produk->stok -= $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }

        $pembelian->delete();

        return response(null, 204);
    }
}
