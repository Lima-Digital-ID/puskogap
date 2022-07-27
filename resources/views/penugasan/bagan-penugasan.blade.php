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
            STRUKTUR ORGANISASI PUSAT KOMANDO SIGAP (PUSKOGAP) SATPOL PP PROVINSI JAWA TIMUR
        </center>
    </h3>
    <div class="container">
        <div class="bagan-center">
            <div class="content">kasatpol pp</div>
            <div class="content">M. HADI WAWAN GUNTORO, S.STP., M.Si., CIPA</div>
        </div>
        <div class="bagan-center">
            <div class="content">kasatpol pp</div>
            <div class="content">M. HADI WAWAN GUNTORO, S.STP., M.Si., CIPA</div>
            <div class="content">kasatpol pp</div>
            <div class="content">M. HADI WAWAN GUNTORO, S.STP., M.Si., CIPA</div>
        </div>
        @php
            $index = 0;
        @endphp
        @for ($i = 0; $i < $row; $i++)
        <div class="row-bagan">
            <div class="col-bagan">
                <div class="block-line"></div>
                @for ($x = 0; $x < 3; $x++)
                    @isset($data[$index])
                        <div class="bagan">
                            <div class="top">{{$data[$index]['nama_kegiatan']}}</div>
                            <div class="body">
                                <div class="row">
                                    <div class="left">ka pti</div>
                                    <div class="right">david</div>
                                </div>
                                <div class="row">
                                    <div class="left">anggota</div>
                                    <div class="right">
                                        david
                                        <br>
                                        david
                                        <br>
                                        david
                                        <br>
                                        david
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                    @php
                        $index++;
                    @endphp
                @endfor
            </div>
            <div class="col-bagan">
                <div class="block-line"></div>                
                @for ($x = 0; $x < 3; $x++)
                    @isset($data[$index])
                        <div class="bagan">
                            <div class="top">{{$data[$index]['nama_kegiatan']}}</div>
                            <div class="body">
                                <div class="row">
                                    <div class="left">ka pti</div>
                                    <div class="right">david</div>
                                </div>
                                <div class="row">
                                    <div class="left">anggota</div>
                                    <div class="right">
                                        david
                                        <br>
                                        david
                                        <br>
                                        david
                                        <br>
                                        david
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                    @php
                        $index++;
                    @endphp
                @endfor
            </div>
        </div>
        @endfor
    </div>
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