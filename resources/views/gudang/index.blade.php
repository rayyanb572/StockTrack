@extends('layouts.base')

@section('title')
    Daftar Gudang
@endsection

@section('badge')
    @parent
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">

                <div class="box-header with-border pb-2">
                    <button onclick="addForm('{{ route('gudang.store') }}')" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i>
                        Tambah Gudang</button>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-stiped table-bordered table-gudang">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Ukuran</th>
                            <th width="10%">Status</th>
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @includeIf('gudang.form')
    @includeIf('gudang.detail')
@endsection

@push('scripts')
<script>
    let table, table_detail;

    $(function () {
        table = $('.table-gudang').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('gudang.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_gudang'},
                {data: 'alamat_gudang'},
                {data: 'ukuran_gudang'},
                {data: 'ukuran_awal'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('.table-produk').DataTable();
        table_detail = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'nama_kategori'},
                {data: 'merk'},
                {data: 'harga_beli'},
                {data: 'harga_jual'},
                {data: 'stok'},
                {data: 'ukuran_produk'},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data gudang berhasil disimpan.',
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
                            text: 'Tidak dapat menyimpan data gudang.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    });
            }
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah gudang');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_gudang]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit gudang');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_gudang]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_gudang]').val(response.nama_gudang);
                $('#modal-form [name=alamat_gudang]').val(response.alamat_gudang);
                $('#modal-form [name=ukuran_gudang]').val(response.ukuran_gudang);
            })
            .fail((errors) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tidak dapat menampilkan data gudang.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                return;
            });
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');
        table_detail.ajax.url(url);
        table_detail.ajax.reload();
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
                        text: 'Data gudang berhasil dihapus.',
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
                        text: 'Tidak dapat menghapus data gudang.',
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
