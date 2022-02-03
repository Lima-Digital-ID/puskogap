<div class="table-responsive">
  <table class="table table-styling table-de">
      <thead>
          <tr class="table-primary">
              <th class="text-center">#</th>
              <th>Nama Kegiatan</th>
              <th>Jenis Kegiatan</th>
              <th>Waktu Mulai</th>
              <th>Waktu Selesai</th>
              <th>Lokasi</th>
              <th>Tamu VVIP</th>
              <th>Biaya</th>
              <th>Jumlah Roda 4</th>
              <th>Jumlah Roda 2</th>
              <th>POC</th>
              <th>Jumlah HT</th>
              <th>Penyelenggara</th>
              <th>Jumlah Peserta</th>
              <th>Penanggung Jawab</th>
              <th>Lampiran</th>
              <th>Status</th>
              <th>Keterangan</th>
              <th>Aksi</th>
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
                <td>{{ $item->nama_kegiatan }}</td>
                <td>{{ $item->jenis_kegiatan->jenis_kegiatan }}</td>
                <td>{{ $item->waktu_mulai }}</td>
                <td>{{ $item->waktu_selesai }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->tamu_vvip }}</td>
                <td>{{ "Rp. " . number_format($item->biaya,2,',','.') }}</td>
                <td>{{ $item->jumlah_roda_4 }}</td>
                <td>{{ $item->jumlah_roda_2 }}</td>
                <td>{{ $item->poc }}</td>
                <td>{{ $item->jumlah_ht }}</td>
                <td>{{ $item->penyelenggara }}</td>
                <td>{{ $item->jumlah_peserta }}</td>
                <td>{{ $item->penanggung_jawab }}</td>
                <td>{{ $item->lampiran }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>
                    <div class="form-inline">
                        <a href="{{ route('penugasan.edit', $item->id) }}" class="mr-2">
                            <button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm"
                                data-toggle="tooltip" title="Edit" data-placement="top"><span
                                    class="feather icon-edit"></span></button>
                        </a>
                        <form action="{{ route('penugasan.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                title="Hapus" data-placement="top"
                                onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''">
                                <span class="feather icon-trash"></span>
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