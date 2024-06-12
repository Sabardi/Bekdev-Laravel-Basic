@extends('layouts.home')
@push('after-style')
    {{-- style css --}}
@endpush
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Tutorial Laravel 11 untuk Pemula</h3>
                    <h5 class="text-center"><a href="https://santrikoding.com">www.santrikoding.com</a></h5>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <a href="javascript:void(0)" class="btn btn-md btn-success mb-3 add_data">ADD PRODUCT</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">IMAGE</th>
                                    <th scope="col">TITLE</th>
                                    <th scope="col">PRICE</th>
                                    <th scope="col">STOCK</th>
                                    <th scope="col" style="width: 20%">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage/products/' . $product->image) }}" class="rounded"
                                                style="width: 150px">
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ 'Rp ' . number_format($product->price, 2, ',', '.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td class="text-center">

                                            <a href="{{ route('products.show', $product->id) }}"
                                                class="btn btn-sm btn-dark">SHOW</a>
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary edit_data"
                                                data-id="{{ $product->id }}">EDIT</a>
                                            {{-- onclick="Edit(this.id)" id="{{ $product->id }}" --}}
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete_data"
                                                data-id="{{ $product->id }}">HAPUS</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="5">Data belum ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $products->links() }}
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
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.store') }}" method="POST" id="form_product"
                        enctype="multipart/form-data">
                        {{-- action="{{ route('products.store') }}" --}}
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">IMAGE</label>
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">


                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">TITLE</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}" placeholder="Masukkan Judul Product">

                            <!-- error message untuk title -->
                            @error('title')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">DESCRIPTION</label>
                            <textarea class="form-control " name="description" rows="5" placeholder="Masukkan Description Product">{{ old('description') }}</textarea>

                            <!-- error message untuk description -->

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">PRICE</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        name="price" value="{{ old('price') }}" placeholder="Masukkan Harga Product">


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">STOCK</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                        name="stock" value="{{ old('stock') }}" placeholder="Masukkan Stock Product">


                                </div>
                            </div>
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
        })

        function resetForm() {
            $('input[name="product_id"]').val('');
            $('input[name="title"]').val('');
            $('textarea[name="description"]').val('');
            $('input[name="price"]').val('');
            $('input[name="stock"]').val('');
            $('#staticBackdropLabel').html("Tambah Product")
            $('#form_product').attr('action', '/products');
        }

        $(document).on('click', '.edit_data', function() {

            var id = $(this).data('id');
            $('#product_id').val(id);
            var url = "/products/" + id + "/edit";
            fetch(url)
                .then(response => response.json())
                .then(response => {
                    $('#staticBackdrop').modal('show');
                    $('#staticBackdropLabel').html("Edit Product")
                    $('#form_product').attr('action', '/products/' + id);
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

                        url: `/products/${id}`,
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

        $('#form_product').submit(function(e) {
            e.preventDefault();

            // var form_data = $('#form_product').serialize();
            var form_data = new FormData(this);
            var formAction = $('#form_product').attr('action');
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
                        // $('#form_product')[0].reset();
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
