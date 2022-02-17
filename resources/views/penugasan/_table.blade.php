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
                        <a href="{{ route('penugasan.edit', $item->id) }}" class="mr-2">
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
                        <form action="{{ route('penugasan.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-rgb-danger btn-sm" data-toggle="tooltip"
                                title="Hapus" data-placement="top"
                                onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''">
                                <span class="fa fa-trash fa-sm"></span>
                            </button>
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