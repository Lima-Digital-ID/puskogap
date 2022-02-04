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
        function ambilAnggota(){
            var mulai = $('[name^=waktu_mulai]').val();
            var selesai = $('[name^=waktu_selesai]').val();
            $('#ketua').remove();
            if(mulai != null && selesai != null) {
                mulai = mulai.replace("T", " ");
                selesai = selesai.replace("T", " ");
                $.ajax({
                    type: "GET",
                    data: {waktu_mulai : mulai, waktu_selesai: selesai},
                    url:"{{ url('penugasan/cek-anggota') }}",
                    dataType : "json",
                    success : function(response){
                    console.log(response)
                        // $('#ketua').append(
                        //     '<div class="form-group row" id="ketua">'
                        //         '<label class="col-sm-2 col-form-label">Ketua</label>'
                        //         '<div class="col-sm-10">'
                        //             '<select name="id_user" class="js-example-basic-single" style="width: 100%;" required>'
                        //                 '<option value="">Pilih asd</option>'
                        //             '</select>'
                        //         '</div>'
                        //     '</div>'
                        //     )
                        $.each(response,function(key,val){
                            console.log(`${key}`);
                            $.each(val,function(i,v){
                                $('#ketua').append('halo');
                                // console.log(`${v.nama}`);
                            })
                        })
                    } 
                })
            }
        }
    </script>
@endpush
