<script>
    var selectedAnggota = []
    var selectedKetua = []
    if($("#id_penugasan").length==1){
        @foreach($selectedKetua as $i => $item)
            selectedKetua.push({{$item}})
        @endforeach
        
        @foreach($selectedAnggota as $i => $item)
            var arr = [];

            @foreach($item as $x => $data)
                arr.push({{$data}})
            @endforeach

            selectedAnggota.push(arr)
        @endforeach
    }

    $("#form-penugasan").submit(function(e){
        e.preventDefault()
        var action = $(this).attr('action')
        var formData = new FormData($(this)[0]);
        $(".text-error").remove()
        $.ajax({
            type : 'post',
            data : formData,
            url : action,
            processData: false,
            contentType: false,
            success : function(res) {
                $(".loading").removeClass('show')
                if(res.type=='error'){
                    swal({
                        title: "Penugasan Gagal",
                        text: res.msg,
                        type: "warning",
                    });
                }else{
                    swal({
                            title: "Penugasan Berhasil",
                            text: res.msg,
                            type: "success",
                        },
                        function() {
                            window.location = "{{url('penugasan')}}"
                        }
                    );
                }

            },
            error : function(err) {
                $(".loading").removeClass('show')
                $.each(err.responseJSON.errors,function(i,v) {
                    var after
                    if(i=='tanggal_kegiatan'){
                        after = ".input-group-tanggal"
                    }
                    else if(i=='id_jenis_kegiatan'){
                        after = "#col-jenis .select2-container"
                    }
                    else{
                        after = "[name='"+i+"']"
                    }
                    $("<small class='text-error'>"+v+"</small>").insertAfter(after)
                })
            }
        })

    })

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

            $(".loop-tanggal.active").removeClass('active')
            $(".input-penugasan-popup.active").removeClass('active')

            $(".loop-tanggal[data-index='"+destinationIndex+"']").addClass('active')
            $(".input-penugasan-popup[data-index='"+destinationIndex+"']").addClass('active')

            $(".loop-tanggal[data-index='"+destinationIndex+"'] a").removeClass('disabled')
            $(".loop-tanggal[data-index='"+destinationIndex+"'] a").attr('onclick','funcBtnTanggal(this)')
        }
    }
    function appendAnggotaFree(parent,res){
        $(parent+" .loop-anggota-free").empty()
        var indexActive = $(parent).attr('data-index');
        $.each(res,function(key,val){
            var checked = $(parent+" .id_waktu_penugasan").length==1 && selectedAnggota[indexActive].includes(val.id) ? 'checked' : ''
            var isKetua = $(parent+" .id_waktu_penugasan").length==1 && selectedKetua[indexActive] == val.id ? 'selected-ketua' : ''
            $(parent+" .loop-anggota-free").append(`
                <div class="select-anggota ${checked} ${isKetua} mb-2">
                    <label class='check-anggota' for="free${indexActive}${key}">
                        <input type="checkbox" id="free${indexActive}${key}" name="id_user[${indexActive}][]" class="check-free" value="${val.id}" ${checked}>
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
                if($(parent+" .hidden_ketua").val()==$(parent+" .check-free").val()){
                    $(parent+" .hidden_ketua").val('')
                }
                
            }
            $(".isKetua").click(function(){
                var parentDiv = $(this).closest('.select-anggota');
                $(".input-penugasan-popup.active .select-anggota").removeClass("selected-ketua")
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
        var id_penugasan = $("#id_penugasan").length==1 ? $("#id_penugasan").val() : '' 
        var dataSend = {tanggal : tanggal, dari :dari, sampai : sampai,id_penugasan:id_penugasan} 
        if($(parent+" .id_waktu_penugasan").length==0){
            $(parent+" .hidden_ketua").val('')
        }

        if(filter){
            var id_jabatan = $(parent+" #id_jabatan").val()
            var id_unit_kerja = $(parent+" #id_unit_kerja").val()
            var id_kompetensi_khusus = $(parent+" #id_kompetensi_khusus").val()
            var dataSend = {tanggal : tanggal, dari :dari, sampai : sampai,id_jabatan : id_jabatan, id_unit_kerja : id_unit_kerja, id_kompetensi_khusus : id_kompetensi_khusus,id_penugasan:id_penugasan} 
        }
        if(tanggal==""){
            $(parent+" .loop-anggota-free").prepend('<p class="error" style="color:red">Pilih Tanggal Terlebih Dahulu</p>')
            $(parent+" .loop-anggota-bertugas").prepend('<p  class="error" style="color:red">Pilih Tanggal Terlebih Dahulu</p>')
        }
        else{
            if(dari!='' && sampai!=''){
                $(parent+" .loop-anggota-bertugas .error").remove()
                $(parent+" .loop-anggota-free .error").remove()
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
        }
    }
    $('.datepicker-multi').datepicker({
        format: 'yyyy-mm-dd',
        multidate: true,
        clearBtn: true,
        todayHighlight: true,
    });

    function newItemTanggal(first=false) {

        var index = first ? 0 : parseInt($(".loop-tanggal:last-child").attr('data-index')) + 1 

        var hapus = ""
        if(index!=0){
            $(".loop-tanggal.active .hidden_tanggal").prop('disabled','true')
            hapus = `<a onclick="removeTanggal(${index})" class="dropdown-item btn-pointer remove-tanggal">Hapus</a>`;
        }
        $(".loop-tanggal").removeClass('active')
        $(".loop-tanggal[data-index='"+index+"']").addClass('active')
        
        $("#list-tanggal").append(`
            <div class='loop-tanggal active mb-2' data-index='${index}'>
                <div class="input-group">
                    <input type='text' placeholder="Masukkan Tanggal" class="form-control hidden_tanggal datepicker btn-pointer" onchange="ajaxAmbilAnggota()" name='tanggal[]' readonly>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item btn-pointer" onclick="changeActiveTanggal(${index})">Detail</a>
                            ${hapus}
                        </div>
                    </div>                            
                </div>
            </div>
        `)
        $(".input-penugasan-popup").removeClass('active')

        if(index!=0){
            $(".input-penugasan-popup[data-index='0']").clone().appendTo('.modal-body')
            
            $(".input-penugasan-popup:last-child").attr('data-index',index)
            $(".input-penugasan-popup[data-index='"+index+"'] input, .input-penugasan-popup[data-index='"+index+"'] select").val('')
            
            $(".input-penugasan-popup:last-child .select2-container").remove()


            $(".input-penugasan-popup:last-child .loop-anggota-free").empty()
            $(".input-penugasan-popup:last-child #error-anggota").remove()
            $(".input-penugasan-popup:last-child input").removeClass("is-invalid")
            $(".input-penugasan-popup:last-child .error").remove()
        }
        $(".input-penugasan-popup[data-index='"+index+"']").addClass('active')

        $(".select2").select2()
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
        });
    }

    function changeActiveTanggal(index) {
        $(".loop-tanggal").removeClass('active')
        $(".loop-tanggal[data-index='"+index+"']").addClass('active')
        $(".loop-tanggal .hidden_tanggal").prop('disabled','false')
        $(".loop-tanggal[data-index='"+index+"'] .hidden_tanggal").removeAttr('disabled')
        $(".input-penugasan-popup").removeClass('active')
        $(".input-penugasan-popup[data-index='"+index+"']").addClass('active')
    }

    function updateTanggalInputValue() {
        var tanggal = $(".hidden")
    }

    $(".btn-tanggal").click(function(e){
        e.preventDefault()
        var valueTanggal = $("#pilih-tanggal").val()
        $("#pilih-tanggal").removeClass("is-invalid")
        $("#pilih-tanggal small").remove()
        $("#modalTanggal").modal('show')
        $("#modalTanggal").off()

        if($(".loop-tanggal").length==0){
            newItemTanggal(true)

            $(".select2").select2()
            $(".datepicker").datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
            });
        }
        else{
            $(".loop-tanggal:not(.active) .hidden_tanggal").prop('disabled','true')
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
                $(".loop-tanggal[data-index='"+index+"']").remove()
                $(".input-penugasan-popup[data-index='"+index+"']").remove()

                var numOfTanggal = parseInt($(".loop-tanggal").length)-1
                var nextIndex = index-1
                var destinationIndex = nextIndex>numOfTanggal ? 0 : nextIndex
                changeActiveTanggal(destinationIndex)

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

    function save(addNew=false) {
        var parent = ".input-penugasan-popup.active";
        var countCheck = $(parent+' .check-free:checked').length
        var input = $(parent+" input:not(.check-free)");
        var nextInput = 0
        if(countCheck==0 && $(parent+" .card-free .card-body #error-anggota").length==0){
            $(parent+" .card-free .card-body").append("<small class='error' style='color:red' id='error-anggota'>Pilih Minimal 1 Anggota</small>")
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
                    $(this).closest('.col-md-6').append("<small class='error' style='color:red'>"+label+" Harap Diisi</small>")
                }
                else if($(parent+" .card-free .card-body #error-ketua").length==0 && $(parent+" .card-free .card-body #error-anggota").length==0){
                    $(parent+" .card-free .card-body").append("<small class='error' style='color:red' id='error-ketua'>Pilih Ketua</small>")
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
        var ketua = $(parent+" .hidden_ketua").val()
        var theresKetua = false
        $(parent+" .check-free:checked").each(function(){
            if($(this).val()==ketua){
                theresKetua = true
            }
        })
        
        if(!theresKetua){
            $(parent+" .card-free .card-body").append("<small class='error' style='color:red' id='error-ketua'>Pilih Ketua</small>")
        }
        else{
            $(parent+" .card-free .card-body #error-ketua").remove()
        }

        if(theresKetua && nextInput==0 && countCheck!=0){
            if(addNew){
                newItemTanggal()
            }
            else{
                var tanggal = $(".hidden_tanggal")
                var selectedTanggal = "";
                tanggal.each(function(i,v){
                    var glue = (i+1)!=tanggal.length ? ", " : ""
                    selectedTanggal+=v.value+glue
                })
                $("#pilih-tanggal").val(selectedTanggal)
    
                var indexActive = $(".loop-tanggal.active").attr('data-index')
                var nextIndexActive = parseInt(indexActive)+1
                nextButton(nextIndexActive)
                $(".hidden_tanggal").removeAttr('disabled')
            }
        }
    }

</script>
