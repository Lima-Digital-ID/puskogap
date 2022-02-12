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
        $(document).ready(function(){
            $(".newTanggal").click(function(e){
                e.preventDefault()
                var tanggal = $("#pilih-tanggal").val()
                var dari = $("#pilih-dari").val()
                var sampai = $("#pilih-sampai").val()
                var row = $(".list-tanggal").attr('data-row')
                if((tanggal!='' && dari!='' && sampai!='') && ($(".list-tanggal .hidden_tanggal[value='"+tanggal+"']").length==0 || $(".list-tanggal .hidden_dari[value='"+dari+"']").length==0 || $(".list-tanggal .hidden_sampai[value='"+sampai+"']").length==0)){
                    $(".loop-tanggal").removeClass('active')
                    $(".list-tanggal").append(`
                    <div class='loop-tanggal active' data-id='${row}'>
                        <a href="">${moment(tanggal).format('DD-MM-YYYY')} (${dari} s/d ${sampai}) <span class="fa fa-times"></span></a>
                        <input type="hidden" class="hidden_tanggal" name="tanggal[]" value="${tanggal}">
                        <input type="hidden" class="hidden_dari" name="dari[]" value="${dari}">
                        <input type="hidden" class="hidden_sampai" name="sampai[]" value="${sampai}">
                        <input type="hidden" class="hidden_ketua" name="ketua[]" value="">
                        <br>
                    </div>
                    `)

                    $(".loop-tanggal[data-id='"+row+"'] a").click(function(e){
                        e.preventDefault() 
                        $(".loop-tanggal").removeClass("active")
                        $(this).closest(".loop-tanggal").addClass("active")
                        ajaxAmbilAnggota()
                    })
                    $(".loop-tanggal[data-id='"+row+"'] a span").click(function(e){
                        e.preventDefault() 
                        e.stopPropagation() 
                        if(confirm('Apakah Anda Yakin?')){
                            var closestLoop = $(this).closest(".loop-tanggal")
                            if(closestLoop.hasClass('active')){
                                $(".loop-anggota-free").empty()
                                $(".loop-anggota-bertugas").empty()
                            }
                            closestLoop.remove()
                        }
                    })
                    row++
                    $(".list-tanggal").attr("data-row",row)
                    ajaxAmbilAnggota()
                }
            })
            $("#btn-filter").click(function(e){
                e.preventDefault()
                if($(".loop-tanggal.active").length!=0){
                    ajaxAmbilAnggota(filter=true)
                }
                
            })
            function ajaxAmbilAnggota(filter=false){
                var parent =".loop-tanggal.active";
                var tanggal = $(parent+" .hidden_tanggal").val()
                var dari = $(parent+" .hidden_dari").val()
                var sampai = $(parent+" .hidden_sampai").val()
                var dataSend = {tanggal : tanggal, dari :dari, sampai : sampai} 
                if(filter){
                    var id_jabatan = $("#id_jabatan").val()
                    var id_unit_kerja = $("#id_unit_kerja").val()
                    var id_kompetensi_khusus = $("#id_kompetensi_khusus").val()
                    var dataSend = {tanggal : tanggal, dari :dari, sampai : sampai,id_jabatan : id_jabatan, id_unit_kerja : id_unit_kerja, id_kompetensi_khusus : id_kompetensi_khusus} 
                }
                $.ajax({
                    type: "GET",
                    data : dataSend,
                    url:"{{ url('penugasan/cek-anggota') }}",
                    dataType : "json",
                    beforeSend : function(){
                        $(".loop-anggota-free").prepend('<p>Loading....</p>')
                        $(".loop-anggota-bertugas").prepend('<p>Loading....</p>')
                    },
                    success : function(response){
                        appendAnggotaFree(response.free);
                        appendAnggotaNotFree(response.tugas);
                    } 
                })
            }
            function appendAnggotaFree(res){
                $(".loop-anggota-free").empty()
                $.each(res,function(key,val){
                    $(".loop-anggota-free").append(`
                        <div class="select-anggota mb-2">
                            <label class='check-anggota' for="free${key}">
                                <input type="checkbox" id="free${key}" name="id_user[]" value="${val.id}">
                                ${val.nama}
                            </label>
                            <span class="isKetua" data-id="${val.id}">Jadikan Ketua</span>                                
                        </div>
                    `);
                })
                $(".check-anggota").click(function(){
                    var dataFor = $(this).attr('for')
                    var parentDiv = $(this).closest('.select-anggota');

                    if($("#"+dataFor).is(":checked")){
                        $(parentDiv).addClass("checked")
                    }
                    else{
                        $(parentDiv).removeClass("checked")
                        $(parentDiv).removeClass("selected-ketua")
                        $(".loop-tanggal.active .hidden_ketua").val('')
                    }
                    $(".isKetua").click(function(){
                        var parentDiv = $(this).closest('.select-anggota');
                        $(".select-anggota").removeClass("selected-ketua")
                        $(parentDiv).addClass("selected-ketua")
                        var id_ketua = $(this).data('id')
                        $(".loop-tanggal.active .hidden_ketua").val(id_ketua)
                    })
                })
            }
            function appendAnggotaNotFree(res){
                $(".loop-anggota-bertugas").empty()
                $.each(res,function(key,val){
                    $(".loop-anggota-bertugas").append(`
                        <div class="mb-2">
                            <label class="mb-2">${val.nama} (${val.nama_kegiatan})</label>
                        </div>
                    `);
                })
            }
            
        })

    </script>
@endpush
