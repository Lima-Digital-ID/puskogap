@extends('layouts.template')

@section('content')

    @include('components.notification')

    @include('penugasan._form-create')


@endsection
@push('custom-script')
    <script>
        function funcBtnTanggal(thisParam){
            var index = $(thisParam).closest('.loop-tanggal').attr('data-index')
            nextButton(index)
        }
        function nextButton(destinationIndex){
            var numOfTanggal = parseInt($(".loop-tanggal").length)-1
            if(destinationIndex>numOfTanggal){
                $("#modalTanggal").modal('hide')
            }
            else{
                $(".loop-tanggal.active a").removeClass('btn-success')
                $(".loop-tanggal.active a").addClass('btn-default')

                $(".loop-tanggal.active").removeClass('active')
                $(".input-penugasan-popup.active").removeClass('active')

                $(".loop-tanggal[data-index='"+destinationIndex+"']").addClass('active')
                $(".input-penugasan-popup[data-index='"+destinationIndex+"']").addClass('active')

                $(".loop-tanggal[data-index='"+destinationIndex+"'] a").removeClass('disabled')
                $(".loop-tanggal[data-index='"+destinationIndex+"'] a").removeClass('btn-default')
                $(".loop-tanggal[data-index='"+destinationIndex+"'] a").addClass('btn-success')
                $(".loop-tanggal[data-index='"+destinationIndex+"'] a").attr('onclick','funcBtnTanggal(this)')
            }
        }
        function appendAnggotaFree(parent,res){
                $(parent+" .loop-anggota-free").empty()
                var indexActive = $(parent).attr('data-index');
                $.each(res,function(key,val){
                    $(parent+" .loop-anggota-free").append(`
                        <div class="select-anggota mb-2">
                            <label class='check-anggota' for="free${indexActive}${key}">
                                <input type="checkbox" id="free${indexActive}${key}" name="id_user[]" class="check-free" value="${val.id}">
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
                        $(parent+" .hidden_ketua").val('')
                    }
                    $(".isKetua").click(function(){
                        var parentDiv = $(this).closest('.select-anggota');
                        $(".select-anggota").removeClass("selected-ketua")
                        $(parentDiv).addClass("selected-ketua")
                        var id_ketua = $(this).data('id')
                        $(parent+" .hidden_ketua").val(id_ketua)
                    })
                })
        }
            function appendAnggotaNotFree(parent,res){
                $(parent+" .loop-anggota-bertugas").empty()
                $.each(res,function(key,val){
                    key++
                    $(parent+" .loop-anggota-bertugas").append(`
                        <div class="mb-2">
                            <label class="mb-2">${key}. ${val.nama} (${val.nama_kegiatan})</label>
                        </div>
                    `);
                })
            }
            function ajaxAmbilAnggota(filter=false){
                var tanggal = $(".loop-tanggal.active .hidden_tanggal").val()
                var parent =".input-penugasan-popup.active";
                var dari = $(parent+" .waktu-mulai").val()
                var sampai = $(parent+" .waktu-sampai").val()
                var dataSend = {tanggal : tanggal, dari :dari, sampai : sampai} 

                $(parent+" .hidden_ketua").val('')

                if(filter){
                    var id_jabatan = $(parent+" #id_jabatan").val()
                    var id_unit_kerja = $(parent+" #id_unit_kerja").val()
                    var id_kompetensi_khusus = $(parent+" #id_kompetensi_khusus").val()
                    var dataSend = {tanggal : tanggal, dari :dari, sampai : sampai,id_jabatan : id_jabatan, id_unit_kerja : id_unit_kerja, id_kompetensi_khusus : id_kompetensi_khusus} 
                }
                $.ajax({
                    type: "GET",
                    data : dataSend,
                    url:"{{ url('penugasan/get-anggota') }}",
                    dataType : "json",
                    beforeSend : function(){
                        $(parent+" .loop-anggota-free").prepend('<p>Loading....</p>')
                        $(parent+" .loop-anggota-bertugas").prepend('<p>Loading....</p>')
                    },
                    success : function(response){
                        appendAnggotaFree(parent,response.free);
                        appendAnggotaNotFree(parent,response.tugas);
                    } 
                })
            }
            $('.datepicker-multi').datepicker({
                format: 'yyyy-mm-dd',
                multidate: true,
                clearBtn: true,
                todayHighlight: true,
            });

            $(".btn-tanggal").click(function(e){
                e.preventDefault()
                var valueTanggal = $("#pilih-tanggal").val()
                if(valueTanggal==''){
                    $("#pilih-tanggal").addClass("is-invalid")
                    $("#pilih-tanggal").closest('.col-md-6').append(`
                    <small style="color:red">
                        Pilih Tanggal Terlebih Dahulu
                    </small>
                    `)
                }
                else{
                    $("#pilih-tanggal").removeClass("is-invalid")
                    $("#pilih-tanggal small").remove()
                    $("#modalTanggal").modal('show')
                    $("#modalTanggal").off()
                    var tanggal = valueTanggal.split(',')
                    $.each(tanggal,function(i,v){
                        var tgl = moment(v).format('DD MMMM')
                        var classBtn = i==0 ? 'success' : 'default disabled';
                        var classLoop = i==0 ? 'active' : ''
                        var nextButton = i==0 ? "onclick='funcBtnTanggal(this)'" : ''

                        $("#list-tanggal").append(`
                            <div class='loop-tanggal ${classLoop}' data-index='${i}'>
                                <a class="btn-pointer btn btn-${classBtn} mr-2" ${nextButton}>${tgl} <span class="fa fa-times ml-4 remove-tanggal" onclick="removeTanggal(${i})"></span> </a>
                                <input type='hidden' class="hidden_tanggal" name='tanggal[]' value='${v}'>
                            </div>
                        `)
                        if(i==0){
                            $(".input-penugasan-popup").addClass('active')
                        }
                        else{
                            $(".input-penugasan-popup[data-index='0']").clone().appendTo('.modal-body')
                            $(".input-penugasan-popup:last-child").attr('data-index',i)
                            $(".input-penugasan-popup:last-child").removeClass('active')

                            $(".input-penugasan-popup:last-child .select2-container").remove()
                        }
                    })
                    $(".select2").select2()
                }
            })
            function removeTanggal(index){
                swal({
                    title: "Apakah anda yakin?",
                    text: 'Tanggal Akan Dihapus',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: 'Hapus',
                    closeOnConfirm: false,
                },
                    function() {
                        var tanggal = $(".loop-tanggal[data-index='"+index+"'] .hidden_tanggal").val()
                        $(".loop-tanggal[data-index='"+index+"']").remove()
                        $(".input-penugasan-popup[data-index='"+index+"']").remove()

                        var inputTanggal = $("#pilih-tanggal").val().split(',')

                        $.each(inputTanggal,function(i,v){
                            if(v==tanggal){
                                inputTanggal.splice(i,1)
                                return false
                            }
                        })                
                        $("#pilih-tanggal").val(inputTanggal.join())
                        var numOfTanggal = parseInt($(".loop-tanggal").length)-1
                        var nextIndex = index-1
                        var destinationIndex = nextIndex>numOfTanggal ? 0 : nextIndex
                        nextButton(destinationIndex)
                        swal.close();
                    }
                );

            }
            function getAnggota(){
                var parent =".input-penugasan-popup.active";
                var dari = $(parent+" .waktu-mulai").val()
                var sampai = $(parent+" .waktu-sampai").val()

                if(dari!='' && sampai!=''){
                    ajaxAmbilAnggota()
                }
            }
            function filterAnggota(e){
                e.preventDefault()
                var parent =".input-penugasan-popup.active";
                var dari = $(parent+" .waktu-mulai").val()
                var sampai = $(parent+" .waktu-sampai").val()

                if(dari!='' && sampai!=''){
                    ajaxAmbilAnggota(filter=true)
                }
            }
            $(".reset-popup").click(function(e){
                e.preventDefault()
                $(".input-penugasan-popup.active input,.input-penugasan-popup.active select").val('')
                $(".loop-anggota-free").empty()
                $(".loop-anggota-bertugas").empty()
            })
            $(".next-popup").click(function(){
                var parent = ".input-penugasan-popup.active";
                var countCheck = $(parent+' .check-free:checked').length
                var input = $(parent+" input:not(.check-free)");
                var nextInput = 0
                if(countCheck==0 && $(parent+" .card-free .card-body #error-anggota").length==0){
                    $(parent+" .card-free .card-body").append("<small style='color:red' id='error-anggota'>Pilih Minimal 1 Anggota</small>")
                }
                else{
                    $(parent+" .card-free .card-body #error-anggota").remove()
                }

                $.each(input,function(i,v){
                    if(v.value==''){
                        nextInput++
                        if(!$(this).hasClass('hidden_ketua') && !$(this).hasClass('is-invalid')){
                            $(this).addClass('is-invalid')
                            var label = $(this).prev('label').html()
                            $(this).closest('.col-md-6').append("<small style='color:red'>"+label+" Harap Diisi</small>")
                        }
                        else if($(parent+" .card-free .card-body #error-ketua").length==0 && $(parent+" .card-free .card-body #error-anggota").length==0){
                            $(parent+" .card-free .card-body").append("<small style='color:red' id='error-ketua'>Pilih Ketua</small>")
                        }
                        // return false
                    }
                    else{
                        if(!$(this).hasClass('hidden_ketua') && $(this).hasClass('is-invalid')){
                            $(this).removeClass('is-invalid')
                            $(this).next('small').remove()
                        }
                        else{
                            $(parent+" .card-free .card-body #error-ketua").remove()
                        }
                    }
                })

                if(nextInput==0 && countCheck!=0){
                    var indexActive = $(".loop-tanggal.active").attr('data-index')
                    var nextIndexActive = parseInt(indexActive)+1
                    nextButton(nextIndexActive)
                }
            })
    </script>
@endpush
