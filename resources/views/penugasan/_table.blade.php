<div class="table-responsive">
  <table class="table table-hover table-custom">
      <thead>
          <tr class="table-primary">
              <th class="text-center">#</th>
              <th>Nama Kegiatan</th>
              <th>Waktu Mulai</th>
              <th>Waktu Selesai</th>
              <th>Lokasi</th>
              <th>Status</th>
              <th></th>
          </tr>
      </thead>
      <tbody>
          @php
              $page = Request::get('page');
              $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
          @endphp
          @foreach ($data as $item)
              <tr class="border-bottom-primary">
                <td class="text-center text-muted">{{ $no }}</td>
                <td>
                    <div class="td-top">
                        {{ $item->nama_kegiatan }}
                    </div>
                    <div class="td-bottom">
                        {{ $item->jenis_kegiatan }}
                    </div>
                </td>
                <td>
                    <div class="td-top">
                        <span class="text-info">{{ date('d F Y',strtotime($item->tanggal_mulai)) }}</span>
                    </div>
                    <div class="td-bottom">
                        <span class="badge badge-info">
                            {{ date('H:i',strtotime($item->waktu_mulai)) }} WIB
                        </span>
                    </div>
                </td>
                <td>
                    <div class="td-top">
                        <span class="text-success">{{ date('d F Y',strtotime($item->tanggal_selesai)) }}</span>
                    </div>
                    <div class="td-bottom">
                        <span class="badge badge-success">
                        {{ date('H:i',strtotime($item->waktu_selesai)) }} WIB
                        </span>
                    </div>
                </td>
                <td>{{ $item->lokasi }}</td>
                <td>
                    @if ($item->status=='Rencana')
                        <span class="badge badge-info">{{$item->status}}</span>
                        @elseif ($item->status=='Pelaksanaan')
                        <span class="badge badge-primary">{{$item->status}}</span>
                        @elseif ($item->status=='Selesai')
                        <span class="badge badge-success">{{$item->status}}</span>
                        @elseif ($item->status=='Batal')
                        <span class="badge badge-danger">{{$item->status}}</span>
                    @endif
                </td>
                <td class="p-0 m-0">
                      <div class="form-inline btn-action">
                        <a href="#" class="mr-2 btn-detail" data-id="{{$item->id}}">
                            <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-success btn-sm"
                                data-toggle="tooltip" title="Detail" data-placement="top"><span
                                    class="fa fa-table fa-sm"></span></button>
                        </a>
                        @if (auth()->user()->level == 'Administrator' || auth()->user()->level == 'Admin' || auth()->user()->level == 'Kasat')
                        <a href="{{ route('penugasan.edit', $item->id) }}" class="mr-2">
                            <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary btn-sm"
                                data-toggle="tooltip" title="Edit" data-placement="top"><span
                                    class="fa fa-edit fa-sm"></span></button>
                        </a>
                        <button type="submit" class="btn btn-rgb-danger btn-sm delete" data-toggle="tooltip"
                                title="Hapus" data-placement="top">
                                {{-- onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''"> --}}
                                <span class="fa fa-trash fa-sm"></span>
                            </button>
                        {{-- <a href="#" type="button" class="btn btn-rgb-danger btn-sm delete" data-toggle="tooltip"
                        title="Hapus" data-placement="top"><span class="fa fa-trash fa-sm"></span></a> --}}
                        <form id="delete-penugasan" action="{{ route('penugasan.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        @endif
                    </div>
                </td>
              </tr>
              @php
                  $no++;
              @endphp
          @endforeach
      </tbody>
  </table>
  <div class="pull-right">
    {{-- {{$data->appends(Request::all())->links('vendor.pagination.custom')}} --}}
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header d-block">
            <div class="d-flex">
                <h5 class="modal-title font-weight-bold color-darkBlue content-detail" id="nama-penugasan" style="min-width:400px">Nama Penugasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="mt-2">
            <div class="btn btn-sm btn-rgb-primary">
                <span class="fa fa-map-marker-alt"></span> 
                <span class="content-detail" id="lokasi">Gedung Sate Bandung</span>
            </div>
            <div class="btn btn-sm btn-rgb-success">
                <span class="fa fa-calendar-alt"></span> 
                <span>
                    <span class="content-detail" id="dari">27 Jan 2022 20:00 </span>
                    s/d 
                    <span class="content-detail" id="sampai">30 Jan 2022 20:00</span>
                </span>
            </div>
        </div>
        <div class="modal-body mt-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#home">Informasi General</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#menu1">Jadwal Penugasan</a>
                </li>
              </ul>
              
              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane container active" id="home">
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label class="mb-1">Jenis Kegiatan</label>
                            <p class="my-0 content-detail" id="jenis">Jenis A</p>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-1">Tamu VVIP</label>
                            <p class="my-0 content-detail" id="tamu-vvip">Presiden Indonesia</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="mb-1">Penyelenggara</label>
                            <p class="my-0 content-detail" id="penyelenggara">Satpol PP Indo</p>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-1">Penanggung Jawab</label>
                            <p class="my-0 content-detail" id="penanggung-jawab">Galih Bagus</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="mb-1">Status</label>
                            <p class="my-0 "><span class="badge content-detail" id="status">Pelaksanaan</span></p>
                        </div>
                        <div class="col-md-6">
                            <label class="mb-1">Keterangan</label>
                            <p class="my-0 content-detail" id="keterangan">Keterangan ini</p>
                        </div>
                    </div>
                    
                </div>
                <div class="tab-pane container fade" id="menu1">
                    <div class="row mt-4">
                        <div class="col-md-12" id="place-detail">
                        </div>
                    </div>                    
                </div>
              </div>
        </div>
      </div>
    </div>
  </div>
  @push('custom-script')
  <script>
      $(document).ready(function(){
          $(".btn-detail").click(function(e){
              e.preventDefault();
              var id = $(this).data('id')
              $.ajax({
                  type : 'get',
                  data : {id,id},
                  url : "{{url('penugasan/detail')}}",
                  dataType : 'json',
                  beforeSend : function(){
                        $(".content-detail").empty()
                        $(".content-detail").append(`<div class='loading-content-detail'></div>`)
                        $("#modalDetail").modal('show')

                        $("#status").removeClass("badge-info")
                        $("#status").removeClass("badge-primary")
                        $("#status").removeClass("badge-success")
                        $("#status").removeClass("badge-danger")
                        $("#place-detail").empty()

                  },
                  success : function(res){
                    //   $("#modalDetail .modal-body").empty()
                    $(".content-detail").empty()
                    var data = res.general
                    $("#nama-penugasan").html(data.nama_kegiatan)
                    $("#lokasi").html(data.lokasi)
                    var tanggal_mulai = moment(data.tanggal_mulai).format('D MMM Y')+" "+moment(data.tanggal_mulai+" "+data.waktu_mulai).format('HH:mm')+" WIB"
                    var tanggal_selesai = moment(data.tanggal_selesai).format('D MMM Y')+" "+moment(data.tanggal_selesai+" "+data.waktu_selesai).format('HH:mm')+" WIB"
                    $("#dari").html(tanggal_mulai)
                    $("#sampai").html(tanggal_selesai)
                    $("#jenis").html(data.jenis_kegiatan)
                    $("#tamu-vvip").html(data.tamu_vvip)
                    $("#penyelenggara").html(data.penyelenggara)
                    $("#penanggung-jawab").html(data.penanggung_jawab)
                    var badgeClass
                    if (data.status=='Rencana'){
                        badgeClass = "badge-info";
                    }
                    else if (data.status=='Pelaksanaan'){
                        badgeClass = "badge-primary";
                    }
                    else if (data.status=='Selesai'){
                        badgeClass = "badge-success";
                    }
                    else if (data.status=='Batal'){
                        badgeClass = "badge-danger";
                    }
                    $("#status").addClass(badgeClass)

                    $("#status").html(data.status)
                    $("#keterangan").html(data.keterangan)

                    var detail = res.detail

                    $.each(detail,function(i,v){
                        $("#place-detail").append(`
                            <div class="card mb-3">
                                <div class="card-header alert-success font-weight-bold d-flex justify-content-between">
                                    <div>
                                        <span class="fa fa-calendar-alt mr-2"></span> 
                                        <span></span>
                                        ${moment(v.waktu.tanggal).format('D MMMM Y')}
                                    </div>
                                    <div>
                                        <span>${moment(v.waktu.tanggal+" "+v.waktu.waktu_mulai).format('HH:mm')} WIB s/d ${moment(v.waktu.tanggal+" "+v.waktu.waktu_selesai).format('HH:mm')} WIB</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="mb-1">Biaya</label>
                                            <p class="my-0"><span class="badge badge-primary">Rp. ${v.waktu.biaya}</span></p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="mb-1">Jumlah Roda 4</label>
                                            <p class="my-0">${v.waktu.jumlah_roda_4}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="mb-1">Jumlah Roda 2</label>
                                            <p class="my-0">${v.waktu.jumlah_roda_2}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label class="mb-1">Jumlah POC</label>
                                            <p class="my-0">${v.waktu.poc}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="mb-1">Jumlah HT</label>
                                            <p class="my-0">${v.waktu.jumlah_ht}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="mb-1">Jumlah Peserta</label>
                                            <p class="my-0">${v.waktu.jumlah_peserta}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <label>Daftar Anggota Bertugas : </label>
                                    <ol style="padding-left:20px" id="anggota${i}">
                                    </ol>
                                </div>
                            </div>
                        `)
                        $.each(v.anggota, function(index,val){
                            var isKetua = val.status=='Ketua' ? '(Ketua)' : '';
                            $("#anggota"+i).append(`
                                <li>${val.nama} ${isKetua}</li> 
                            `)
                        })
                    })
                  }
              })
          })
      })
  </script>
@endpush