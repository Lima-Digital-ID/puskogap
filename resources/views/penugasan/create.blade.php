@extends('layouts.template')

@section('page-header')
    @include('components.page-header', [
    'pageTitle' => $pageTitle,
    'pageSubtitle' => '',
    'pageIcon' => $pageIcon,
    'parentMenu' => $parentMenu,
    'current' => $current
    ])
@endsection

@section('content')

    @include('components.notification')

    <div class="row">
        <div class="col-sm-12">
            @include('components.button-list', ['btnText' => $btnText, 'btnLink' => $btnLink])
            <div class="card">
                <div class="card-header">
                    <h5>Tambah {{ $pageTitle }}</h5>
                </div>
                <div class="card-block">
                    {{-- <h4 class="sub-title">Basic Inputs</h4> --}}
                    @include('penugasan._form-create')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script>
        function appendAnggotaFree(res){
            $(".loop-anggota-free").empty()
            $.each(res,function(key,val){
                $(".loop-anggota-free").append(`
                    <div class="mb-2">
                        <input type="checkbox" id="free${key}" name="id_user[]" value="${val.id}">
                        <label class='check-anggota' for="free${key}">${val.nama}</label>
                    </div>
                `);
            })
            $(".check-anggota").click(function(){
                var dataFor = $(this).attr('for')
                if($("#"+dataFor).is(":checked")){
                    $(".check-anggota").removeClass("checked")
                }
                else{
                    $(".check-anggota").addClass("checked")
                }
            })
        }
        function ambilAnggota(){
            var mulai = $('[name^=waktu_mulai]').val();
            var selesai = $('[name^=waktu_selesai]').val();
            if(mulai != '' && selesai != '') {
                mulai = mulai.replace("T", " ");
                selesai = selesai.replace("T", " ");
                $.ajax({
                    type: "GET",
                    data: {waktu_mulai : mulai, waktu_selesai: selesai},
                    url:"{{ url('penugasan/cek-anggota') }}",
                    dataType : "json",
                    success : function(response){
                        appendAnggotaFree(response.free);
                        $(".loop-anggota-bertugas").empty()
                        $.each(response.tugas,function(key,val){
                            $(".loop-anggota-bertugas").append(`
                                <div class="mb-2">
                                    <label class="mb-2">${val.nama} (${val.nama_kegiatan})</label>
                                </div>
                            `);
                        })
                    } 
                })
            }
        }
        $(document).ready(function(){
            $("#btn-filter").click(function(e){
                e.preventDefault();
                
                var id_jabatan = $("#id_jabatan").val()
                var id_unit_kerja = $("#id_unit_kerja").val()
                var id_kompetensi_khusus = $("#id_kompetensi_khusus").val()
                var mulai = $('[name^=waktu_mulai]').val();
                var selesai = $('[name^=waktu_selesai]').val();

                if(mulai != '' && selesai != '') {
                    $.ajax({
                        type : 'get',
                        url:"{{ url('penugasan/filter-anggota-free') }}",
                        data: {waktu_mulai : mulai, 
                                waktu_selesai: selesai,
                                id_jabatan:id_jabatan,
                                id_unit_kerja:id_unit_kerja,
                                id_kompetensi_khusus:id_kompetensi_khusus},
                        dataType : "json",
                        beforeSend : function(){
                            $(".loop-anggota-free").prepend('<p>Loading....</p>')
                        },
                        success : function(response){
                            appendAnggotaFree(response);
                        }
                    })
                }
            })
        })

    </script>
@endpush
