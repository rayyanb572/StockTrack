<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Gudang;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');
        $gudang = Gudang::all()->pluck('nama_gudang', 'id_gudang');

        return view('produk.index', compact('kategori', 'gudang'));
    }

    public function data()
    {
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            ->leftJoin('gudang', 'gudang.id_gudang', 'produk.id_gudang')
            ->select('produk.*', 'nama_kategori', 'nama_gudang')
            ->orderBy('kode_produk', 'desc')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="badge bg-info">'. $produk->kode_produk .'</span>';

            })
            ->addColumn('harga_beli', function ($produk) {
                return 'Rp'. uang_indonesia($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return 'Rp'. uang_indonesia($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                return uang_indonesia($produk->stok);
            })
            ->addColumn('ukuran_produk', function ($produk) {
                return $produk->ukuran_produk .' m³';
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $produk = Produk::latest()->first() ?? new Produk();
        $request['kode_produk'] = tambah_nol_didepan((int)$produk->id_gudang, (int)$produk->id_kategori, (int)$produk->id_produk);
        $produk = Produk::create($request->all());
        $ukuran_total_produk = $produk->stok * $produk->ukuran_produk;
        $gudang = Gudang::find($produk->id_gudang);
        if($gudang->ukuran_gudang < $ukuran_total_produk) {
            $produk->delete();
            return redirect()->route('produk.index')->with([
                'status'=> 'error',
                'judul'=> 'Gagal',
                'message'=> 'Ukuran gudang tidak mencukupi'
            ]);
        } else {
            $gudang->ukuran_gudang -= $ukuran_total_produk;
            $gudang->save();
            return redirect()->route('produk.index')->with([
                'status'=> 'success',
                'judul'=> 'Berhasil',
                'message'=> 'Data produk berhasil ditambahkan'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $gudangLama = Gudang::find($produk->id_gudang);
        $stokLama = $produk->stok;
        $ukuranProduk = $produk->ukuran_produk;
        $produk->update($request->all());

        $gudangBaru = Gudang::find($produk->id_gudang);
        $selisihStok = $produk->stok - $stokLama;
        $ukuranBaru = $produk->ukuran_produk;
        $ukuranTotalBaru = $produk->stok * $ukuranBaru;
        $ukuranTotalLama = $stokLama * $ukuranProduk;
        $selisihUkuranTotal = $ukuranTotalBaru - $ukuranTotalLama;

        if($gudangLama->id_gudang == $gudangBaru->id_gudang) {
            if ($selisihUkuranTotal > 0) {
                $gudang = Gudang::find($produk->id_gudang);
                if($gudang->ukuran_gudang < $selisihUkuranTotal) {
                    $produk->stok = $stokLama;
                    $produk->ukuran_produk = $ukuranProduk;
                    $produk->save();
                    return redirect()->route('produk.index')->with([
                        'status'=> 'error',
                        'judul'=> 'Gagal',
                        'message'=> 'Ukuran gudang tidak mencukupi'
                    ]);
                } else {
                    $gudang->ukuran_gudang -= $selisihUkuranTotal;
                    $gudang->save();
                }
            } elseif ($selisihUkuranTotal < 0) {
                $gudang = Gudang::find($produk->id_gudang);
                $gudang->ukuran_gudang -= $selisihUkuranTotal;
                $gudang->save();
            }

            return redirect()->route('produk.index')->with([
                'status'=> 'success',
                'judul'=> 'Berhasil',
                'message'=> 'Data produk berhasil diubah'
            ]);
        } else {
            $gudangLama->ukuran_gudang += $ukuranTotalLama;
            $gudangLama->save();
            $gudangBaru->ukuran_gudang -= $ukuranTotalBaru;
            $gudangBaru->save();
            return redirect()->route('produk.index')->with([
                'status'=> 'success',
                'judul'=> 'Berhasil',
                'message'=> 'Data produk berhasil diubah'
            ]);
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $ukuran_total_produk = $produk->stok * $produk->ukuran_produk;
        $gudang = Gudang::find($produk->id_gudang);
        $gudang->ukuran_gudang += $ukuran_total_produk;
        $gudang->save();
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }
}
