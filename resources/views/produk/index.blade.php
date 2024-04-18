@extends('layouts.base')

@section('title')
    Daftar Produk
@endsection

@section('badge')
    @parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border pb-1">
                <div class="box">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Tambah Produk </button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus Produk </button>
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th width="5%">No</th>
                            <th>Kode Produk</th>
                            <th>Gudang</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Ukuran Produk</th>
                            <th width="10%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('produk.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_gudang'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merk'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'stok'},
                {data: 'ukuran_produk'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            console.log('Checkbox clicked');
            $(':checkbox').prop('checked', $(this).prop('checked'));
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_gudang]').val(response.id_gudang);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=diskon]').val(response.diskon);
                $('#modal-form [name=stok]').val(response.stok);
                $('#modal-form [name=ukuran_produk]').val(response.ukuran_produk);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus data terpilih?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Data produk berhasil dihapus.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                })
                .fail((errors) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menghapus data produk.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            }
        });
    }

    function deleteSelected(url) {
        Swal.fire({
            icon: 'question',
            title: 'Konfirmasi',
            text: 'Yakin ingin menghapus data terpilih?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, $('.form-produk').serialize())
                .done((response) => {
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Data produk berhasil dihapus.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                })
                .fail((errors) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat menghapus data produk.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
            }
        });
    }



    @if(session('status'))
        let status = "{{ session('status') }}";
        let message = "{{ session('message') }}";
        let judul = "{{ session('judul') }}";

        Swal.fire({
            icon: status,
            title: judul,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>
@endpush
