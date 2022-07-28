<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('') }}css/bagan.css" />
    <title>Document</title>
</head>
<body>
    <h3>
        <center>
            <u>
                STRUKTUR ORGANISASI PUSAT KOMANDO SIGAP (PUSKOGAP) SATPOL PP PROVINSI JAWA TIMUR
            </u>
            <br>
            {{$text_tanggal}}
        </center>
    </h3>
    <div class="container">
        <div class="bagan-center">
            <div class="content">kasatpol pp</div>
            <div class="content">M. HADI WAWAN GUNTORO, S.STP., M.Si., CIPA</div>
        </div>
        <div class="bagan-center">
            <div class="content">KAPUSKOGAP</div>
            <div class="content">ASYIK ISMOYO, SH, MM</div>
            <div class="content">WAKAPUSKOGAP / KASET</div>
            <div class="content">M. ARIEF DARMAWAN, SH</div>
        </div>
        @php
            $index = 0;
        @endphp
        @for ($i = 0; $i < $row; $i++)
        <div class="row-bagan" {{$i+1==$row ? 'data-last=true' : ''}}>
            @for ($z = 0; $z < 2; $z++)
                <div class="col-bagan">
                    <div class="block-line"></div>
                    @for ($x = 0; $x < 3; $x++)
                        @isset($data[$index])
                            <div class="bagan">
                                <div class="top">{{$data[$index]['nama_kegiatan']}}</div>
                                @foreach ($data[$index]['waktu_penugasan'] as $item)
                                    <div class="body">
                                        <div class="row">
                                            <div class="left">ketua</div>
                                            <div class="right">
                                                {{$item['detail_anggota'][count($item['detail_anggota'])-1]['anggota']['nama']}}
                                            </div>
                                        </div>
                                        <div class="row row-anggota">
                                            <div class="left">anggota</div>
                                            <div class="right">
                                                @for ($n = 0; $n < count($item['detail_anggota'])-1; $n++)
                                                    {{$item['detail_anggota'][$n]['anggota']['nama']}}
                                                    <br>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endisset
                        @php
                            $index++;
                        @endphp
                    @endfor
                </div>
            @endfor
        </div>
        @endfor
    </div>
    <h3>
        <center>
            <u>
                RENCANA OPERASI PUSAT KOMANDO SIGAP (PUSKOGAP) SATUAN POLISI PAMONG PRAJA PROVINSI JAWA TIMUR
            </u>
            <br>
            {{$text_tanggal}}
        </center>
    </h3>
    <table width="100%" cellpadding="10px" cellspacing="0" border="1">
        <thead>
            <tr bgcolor="#980000">
                <th>NO</th>
                <th>PUKUL</th>
                <th>KEGIATAN</th>
                <th>TEMPAT</th>
                <th>VIIP HADIR</th>
                <th>JENIS OPS</th>
                <th>PERSONIL</th>
                <th>BIAYA</th>
                <th>RODA 4</th>
                <th>POC</th>
                <th>HT</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($waktu_penugasan as $item)
                <tr>
                   <td>{{$loop->iteration}}</td> 
                   <td>{{date('H:i',strtotime($item['waktu_mulai']))}}</td> 
                   <td>{{$item['penugasan']['nama_kegiatan']}}</td> 
                   <td>{{$item['penugasan']['lokasi']}}</td> 
                   <td>{{$item['penugasan']['tamu_vvip']}}</td> 
                   <td>{{$item['penugasan']['jenis_kegiatan']['jenis_kegiatan']}}</td> 
                   <td>{{count($item['detail_anggota']) - 1}}</td> 
                   <td>Rp {{number_format($item['biaya'],0,',','.')}}</td> 
                   <td>{{$item['jumlah_roda_4']}}</td> 
                   <td>{{$item['poc']}}</td> 
                   <td>{{$item['jumlah_ht']}}</td> 
                   <td>{{$item['penugasan']['keterangan']}}</td> 
                </tr>
            @endforeach
            <tr></tr>
        </tbody>

    </table>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $('.col-bagan').each(function(x,z) {
            var countBagan = parseInt($(this).find(".bagan").length)
            var widthLine = 50/countBagan
            $(this).find(".block-line").css('width',widthLine+"%")
        })
    </script>
</body>
</html>