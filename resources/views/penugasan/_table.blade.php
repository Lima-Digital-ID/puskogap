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
                        {{ $item->jenis_kegiatan->jenis_kegiatan }}
                    </div>
                </td>
                <td>{{ $item->waktu_mulai }}</td>
                <td>{{ $item->waktu_selesai }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>
                    @if ($item->status=='Rencana')
                        <span class="badge badge-warning">{{$item->status}}</span>
                        @elseif ($item->status=='Pelaksanaan')
                        <span class="badge badge-primary">{{$item->status}}</span>
                        @elseif ($item->status=='Selesai')
                        <span class="badge badge-success">{{$item->status}}</span>
                        @elseif ($item->status=='Batal')
                        <span class="badge badge-danger">{{$item->status}}</span>
                    @endif
                </td>
                <td class="p-0 m-0">
                    {{-- <div class="dropdown">
                        <button class="dropdown-toggle btn-custom-dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="fa fa-chevron-right"></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">Detail</a>
                          <a class="dropdown-item" href="#">Edit</a>
                          <a class="dropdown-item" href="#">Delete</a>
                        </div>
                      </div>                     --}}
                      <div class="form-inline btn-action">
                        <a href="{{ route('penugasan.edit', $item->id) }}" class="mr-2">
                            <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-success btn-sm"
                                data-toggle="tooltip" title="Detail" data-placement="top"><span
                                    class="fa fa-table fa-sm"></span></button>
                        </a>
                        <a href="{{ route('penugasan.edit', $item->id) }}" class="mr-2">
                            <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary btn-sm"
                                data-toggle="tooltip" title="Edit" data-placement="top"><span
                                    class="fa fa-edit fa-sm"></span></button>
                        </a>
                        <form action="{{ route('penugasan.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-rgb-danger btn-sm" data-toggle="tooltip"
                                title="Hapus" data-placement="top"
                                onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''">
                                <span class="fa fa-trash fa-sm"></span>
                            </button>
                        </form>
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
    {{$data->appends(Request::all())->links('vendor.pagination.custom')}}
  </div>
</div>