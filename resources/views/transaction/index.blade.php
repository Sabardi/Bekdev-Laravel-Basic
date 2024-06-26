@extends('layouts.admin')
@push('after-style')
    {{-- style css --}}
@endpush
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">

                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="javascript:void(0)" class="btn btn-md btn-success mb-3 add_data">ADD TRANSACTION</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Product</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaction as $item)
                                    <tr class="text-center">
                                        <td>{{ $item->product?->title }}</td>
                                        <td>{{ 'Rp ' . number_format($item->harga, 2, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ 'Rp ' . number_format($item->total, 2, ',', '.') }}</td>


                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="3">Data belum ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $transaction->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('transactions.store') }}" method="POST" id="form_transaction"
                        enctype="multipart/form-data">
                        {{-- action="{{ route('products.store') }}" --}}
                        @csrf



                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Product</label>
                            <select name="product_id" class="form-select" id="product_id">
                                <option value="">Pilih Product</option>
                                @foreach ($product as $item)
                                    <option value="{{ $item->id }}">{{ $item->title . ' - ' . $item->stock }}</option>
                                @endforeach
                            </select>


                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Harga</label>
                            <input type="text" class="form-control" readonly name="harga" id="">

                            <!-- error message untuk description -->

                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Quantity</label>
                            <input type="text" class="form-control" name="quantity" id="">

                            <!-- error message untuk description -->

                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Total Harga</label>
                            <input type="text" class="form-control" name="total_harga" id="">

                            <!-- error message untuk description -->

                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">User</label>
                            <select name="user_id" class="form-select" id="">
                                <option value="">Pilih User</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->name . ' - ' . $item->email }}</option>
                                @endforeach
                            </select>

                            <!-- error message untuk description -->

                        </div>



                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('after-script')
    {{-- after scripy --}}
    <script>
        $(document).on('click', '.add_data', function() {
            // LoadingShow();
            $('#staticBackdrop').modal('show');
            resetForm();
        });

        $('#product_id').on('change', function() {
            var product_id = $(this).val();
            var url = "/dashboard/product-detail/" + product_id;
            fetch(url)
                .then(response => response.json())
                .then(response => {
                    $('input[name="harga"]').val(response.data?.price);
                });
        });

        $(document).on('keyup', 'input[name="quantity"]', function() {
            var quantity = $(this).val();
            var harga = $('input[name="harga"]').val();
            var total = quantity * harga;
            $('input[name="total_harga"]').val(total);
        })

        function resetForm() {
            $('input[name="product_id"]').val('');
            $('input[name="title"]').val('');
            $('textarea[name="description"]').val('');
            $('input[name="price"]').val('');
            $('input[name="stock"]').val('');
            $('#staticBackdropLabel').html("Tambah Transaction")
            // $('#form_transaction').attr('action', '/dashboard/products');
        }

        $(document).on('click', '.edit_data', function() {

            var id = $(this).data('id');
            $('#product_id').val(id);
            var url = "/dashboard/products/" + id + "/edit";
            fetch(url)
                .then(response => response.json())
                .then(response => {
                    $('#staticBackdrop').modal('show');
                    $('#staticBackdropLabel').html("Edit Product")
                    $('#form_transaction').attr('action', '/dashboard/products/' + id);
                    $('input[name="title"]').val(response.data.title);
                    $('textarea[name="description"]').val(response.data.description);
                    $('input[name="price"]').val(response.data.price);
                    $('input[name="stock"]').val(response.data.stock);
                });

        });

        $(document).on('click', '.delete_data', function() {
            // LoadingShow();
            var id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //fetch to delete data
                    $.ajax({

                        url: `/dashboard/products/${id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            }).then(function() {
                                location.reload();
                            });

                            //remove post on table
                        },
                        error: function(error) {

                            //show error message
                            Swal.fire({
                                type: 'error',
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }

                    });


                }
            })

        })

        $('#form_transaction').submit(function(e) {
            e.preventDefault();

            // var form_data = $('#form_transaction').serialize();
            var form_data = new FormData(this);
            var formAction = $('#form_transaction').attr('action');
            var id = $('input[name="product_id"]').val();

            var method = "POST";
            let token = $("meta[name='csrf-token']").attr("content");
            LoadingShow();
            // ajax store
            $.ajax({
                url: formAction,
                method: method,
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(response) {
                    if (response.status == "success") {
                        // $('#form_transaction')[0].reset();
                        $('#staticBackdrop').modal('hide');

                        LoadingHide();
                        Swal.fire({
                            icon: "success",
                            title: "BERHASIL",
                            text: "Data berhasil disimpan",
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {
                            location.reload();
                        });

                    }
                },
                error: function(error) {
                    LoadingHide();
                    $('#staticBackdrop').modal('hide');

                    var message = '';
                    if (error.status == 422) {
                        $.each(error.responseJSON.errors, function(key, item) {
                            message += item[0] + '<br>';
                        })
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: message,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: error.responseJSON.message,
                            customClass: {
                                confirmButton: 'btn btn-danger'
                            }
                        });
                    }

                }
            });
        });
    </script>
@endpush
