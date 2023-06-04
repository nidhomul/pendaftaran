@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Profil</h6>
        </div>
        <div class="card-body">
            <form id="profile_form" method="post">
                @csrf
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                            <input class="form-control" id="name" name="name" type="text" required
                            value="{{ auth()->user()->name }}"
                            oninvalid="this.setCustomValidity('Nama Lengkap tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Email <span class="text-danger">*</span></label>
                            <input class="form-control" id="email" name="email" type="email" required
                            value="{{ auth()->user()->email }}"
                            oninvalid="this.setCustomValidity('Email tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Pangkalan/Gudep <span class="text-danger">*</span></label>
                            <input class="form-control" id="pangkalan_gudep" name="pangkalan_gudep" type="text" required
                            value="{{ $participants->pangkalan_gudep }}"
                            oninvalid="this.setCustomValidity('Pangkalan/Gudep tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Kwarran <span class="text-danger">*</span></label>
                            <select class="form-control" name="kwarran" required>
                                <option value="">- Pilih Kwarran -</option>
                                @foreach ($kwarran as $item)
                                    <option value="{{ $item->id }}" {{ $participants->kwarran_id == $item->id ? 'selected' : '' }}>{{ $item->kwarran }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="mb-2">Krida Saka Milenial <span class="text-danger">*</span></label>
                            <br>
                            @foreach ($krida_saka_milenial as $item)
                                <input name="krida_saka_milenial" type="radio" value="{{ $item->id }}" {{ $participants->krida_saka_milenial_id == $item->id ? 'checked' : '' }} />
                                &nbsp;
                                <label class="mb-1">{{ $item->krida_saka_milenial }}</label>
                                <br>
                            @endforeach
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Nomor Telepon <span class="text-danger">*</span></label>
                            <input class="form-control" id="phone_number" name="phone_number" type="number" required
                            value="{{ $participants->phone_number }}"
                            oninvalid="this.setCustomValidity('Nomor Telepon tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Password</label>
                            <input class="form-control mb-2" id="password" name="password" type="password" />
                            <span class="text-danger" style="font-size: 13px">* Kosongkan password apabila anda tidak ingin mengubah password</span>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success btn-icon-split btn-sm float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text">Simpan</span>
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>

    <script type="text/javascript">
        $("#profile_form").on("submit", function(event) {
            Swal.fire({
                title: 'Simpan Perubahan',
                text: "Apakah anda yakin?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'mr-2',
                    cancelButton: 'ml-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Menyimpan Data!',
                        html: 'Mohon menunggu',
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    })

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('profile.update_user') }}",
                        type: "POST",
                        data: new FormData($('#profile_form')[0]),
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            console.log(res);

                            Swal.close()

                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sukses',
                                    text: res.message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                }).then((result) => {
                                    location.reload();
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Maaf',
                                    text: res.message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                })
                            }
                        }
                    });
                }
            })
            event.preventDefault();
        });
    </script>

</div>
@endsection
