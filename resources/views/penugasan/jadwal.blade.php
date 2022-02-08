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
    
    <div class="card">
        <div class="card-header">
            <h5>{{ $pageTitle }} Penugasan</h5>
        </div>
        <div class="card-block table-border-style">
            <div id="calendar"></div>
        </div>
    </div>

@endsection
@section("full-calendar")
<script>
    $(document).ready(function() {
         $('#calendar').fullCalendar({
             header: {
                 left: 'prev,next today',
                 center: 'title',
                 right: 'month,agendaWeek,agendaDay'
             },
             defaultDate: new Date(),
             defaultView: 'month',
             timeFormat: 'H:mm',
             displayEventEnd : true,
             eventMouseover: function (data, event, view) {
                tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#f4f4f4;position:absolute;z-index:10001;padding:7px 15px 7px 15px ;  line-height: 200%;border-radius:10px">' + data.title + '</div>';
                $("body").append(tooltip);
                $(this).mouseover(function (e) {
                    $(this).css('z-index', 10000);
                    $('.tooltiptopicevent').fadeIn('500');
                    $('.tooltiptopicevent').fadeTo('10', 1.9);
                }).mousemove(function (e) {
                    $('.tooltiptopicevent').css('top', e.pageY + 10);
                    $('.tooltiptopicevent').css('left', e.pageX + 20);
                });
            },
            eventMouseout: function (data, event, view) {
                $(this).css('z-index', 8);

                $('.tooltiptopicevent').remove();

            },
            dayClick: function () {
                tooltip.hide()
            },
            eventResizeStart: function () {
                tooltip.hide()
            },
            eventDragStart: function () {
                tooltip.hide()
            },
            viewDisplay: function () {
                tooltip.hide()
            },
 
             events: [
                 @foreach($penugasan as $data)
                    {
                        id: {{$data->id}},
                        title: '{{$data->nama_kegiatan}}',
                        description : '{{$data->nama_kegiatan}}',
                        start: '{{$data->waktu_mulai}}',
                        end: '{{$data->waktu_selesai}}',
                    },
                 @endforeach
             ]
         });
         
     });
    
   </script>    
 @endsection
