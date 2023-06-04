@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Formulir</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <a href="{{ route('form') }}" class="btn btn-secondary btn-icon-split btn-sm mb-4">
        <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
    </a>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Formulir</h6>
        </div>
        <div class="card-body">
            <div>
                <b>Status Pendaftaran : 
                @if ($participants->trParticipantsRegistrationStatus)
                    @if ($participants->trParticipantsRegistrationStatus->status == 1)
                        <span class="text-success">Diterima</span>
                    @else
                        <span class="text-danger">Ditolak</span>
                    @endif
                @else
                    <span class="text-warning">Belum Diverifikasi</span>
                @endif
                </b>
            </div>
            <br>
            <form id="participant_form" method="post">
                @csrf
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                            <input class="form-control" id="full_name" name="full_name" type="text" required
                            value="{{ $participants->full_name }}"
                            oninvalid="this.setCustomValidity('Nama Lengkap tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Email <span class="text-danger">*</span></label>
                            <input class="form-control" id="email" name="email" type="email" required
                            value="{{ $participants->email }}"
                            oninvalid="this.setCustomValidity('Email tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Jenis Kelamin <span class="text-danger">*</span></label>
                            <br>
                            <input name="gender" type="radio" value="1" required {{ $participants->gender == 1 ? 'checked' : '' }} />
                            &nbsp;
                            <label>Laki-laki</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name="gender" type="radio" value="0" required {{ $participants->gender == 0 ? 'checked' : '' }} />
                            &nbsp;
                            <label>Perempuan</label>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Tempat Lahir <span class="text-danger">*</span></label>
                            <input class="form-control" id="birth_place" name="birth_place" type="text" required
                            value="{{ $participants->birth_place }}"
                            oninvalid="this.setCustomValidity('Tempat Lahir tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input class="form-control" id="birth_date" name="birth_date" type="date" required
                            value="{{ $participants->birth_date }}"
                            oninvalid="this.setCustomValidity('Tanggal Lahir tidak boleh kosong')"
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
                            {{-- <input class="form-control" id="kwarran" name="kwarran" type="text" required
                            value="{{ $participants->mstrKwarran->kwarran }}"
                            oninvalid="this.setCustomValidity('Kwarran tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" /> --}}
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">NIK</label>
                            <input class="form-control" id="nik" name="nik" type="number" value="{{ $participants->nik }}" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">NTA Pramuka/NIS/NIM <span class="text-danger">*</span></label>
                            <input class="form-control" id="nta_pramuka_nis_nim" name="nta_pramuka_nis_nim" type="text" required
                            value="{{ $participants->nta_pramuka_nis_nim }}"
                            oninvalid="this.setCustomValidity('NTA Pramuka/NIS/NIM tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Tingkatan Pramuka <span class="text-danger">*</span></label>
                            <select class="form-control" name="scout_level" required>
                                <option value="">- Pilih Tingkatan Pramuka -</option>
                                @foreach ($scout_level as $item)
                                    <option value="{{ $item->id }}" {{ $participants->scout_level_id == $item->id ? 'selected' : '' }}>{{ $item->scout_level }}</option>
                                @endforeach
                            </select>
                            {{-- <input class="form-control" id="scout_level" name="scout_level" type="text" required
                            value="{{ $participants->mstrScoutLevel->scout_level }}"
                            oninvalid="this.setCustomValidity('Tingkatan Pramuka tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" /> --}}
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Krida Saka Milenial <span class="text-danger">*</span></label>
                            <br>
                            @foreach ($krida_saka_milenial as $item)
                                <input name="krida_saka_milenial" type="radio" value="{{ $item->id }}" {{ $participants->krida_saka_milenial_id == $item->id ? 'checked' : '' }} />
                                &nbsp;
                                <label class="mb-1">{{ $item->krida_saka_milenial }}</label>
                                <br>
                            @endforeach
                            {{-- <input class="form-control" id="krida_saka_milenial" name="krida_saka_milenial" type="text" required
                            value="{{ $participants->mstrKridaSakaMilenial->krida_saka_milenial }}"
                            oninvalid="this.setCustomValidity('Krida Saka Milenial tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" /> --}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="mb-2">Alamat Tempat Tinggal <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" rows="2" required
                            oninvalid="this.setCustomValidity('Alamat Tempat Tinggal tidak boleh kosong')"
                            oninput="this.setCustomValidity('')">{{ $participants->address }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Nomor Telepon <span class="text-danger">*</span></label>
                            <input class="form-control" id="phone_number" name="phone_number" type="number" required
                            value="{{ $participants->phone_number }}"
                            oninvalid="this.setCustomValidity('Nomor Telepon tidak boleh kosong')"
                            oninput="this.setCustomValidity('')" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Twitter</label>
                            <input class="form-control" id="twitter" name="twitter" type="text" value="{{ $participants->twitter }}" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Instagram</label>
                            <input class="form-control" id="instagram" name="instagram" type="text" value="{{ $participants->instagram }}" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Facebook</label>
                            <input class="form-control" id="facebook" name="facebook" type="text" value="{{ $participants->facebook }}" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">Tiktok</label>
                            <input class="form-control" id="tiktok" name="tiktok" type="text" value="{{ $participants->tiktok }}" />
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">KK (Kartu Keluarga)</label>
                            <input class="form-control mb-2" id="kk_file" name="kk_file" type="file" accept="image/png,image/jpeg,image/jpg" />
                            <span class="text-danger" style="font-size: 13px">* Kosongkan KK (Kartu Keluarga) apabila anda tidak ingin mengubah KK</span>
                            <a href="{{ url('storage/registration') }}/{{ $participants->kk_filename }}" target="_blank">
                                <img src="{{ url('storage/registration') }}/{{ $participants->kk_filename }}" class="mt-3" height="150">
                            </a>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2">KTP</label>
                            <input class="form-control mb-2" id="ktp_file" name="ktp_file" type="file" accept="image/png,image/jpeg,image/jpg" />
                            <span class="text-danger" style="font-size: 13px">* Kosongkan KTP apabila anda tidak ingin mengubah KTP</span>
                            <a href="{{ url('storage/registration') }}/{{ $participants->ktp_filename }}" target="_blank">
                                <img src="{{ url('storage/registration') }}/{{ $participants->ktp_filename }}" class="mt-3" height="150">
                            </a>
                        </div>
                    </div>
                </div>
                <button href="{{ route('form') }}" type="submit" class="btn btn-success btn-icon-split btn-sm mb-4 float-right">
                    <span class="icon text-white-50">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="text">Simpan</span>
                </button>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $("#participant_form").on("submit", function(event) {
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
                        url: "{{ route('form.update', $participants->id) }}",
                        type: "POST",
                        data: new FormData($('#participant_form')[0]),
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
