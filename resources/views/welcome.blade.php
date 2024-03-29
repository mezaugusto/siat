@extends('layouts.app')
@section('content')
<div class="container">
    @if(isset($error) && $error != '')
        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Lo sentimos :c </strong> {{ $error }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-dismissible alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Exito</strong> {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <h1>Juegos Disponibles</h1>
            <table class="table juegos">
                <thead>
                    <tr>
                        <th class="tablehead">Selecciona uno de la lista</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($juegos as $key=>$juego)
                        @if($juego->status == "disponible")
                            <tr>
                                <th class="celljuego @if($juego==$juegodisp) selected @endif" data-id="{{ $juego->id }}">
                                    <div class="juego">
                                        <p class="name">{{ $juego->name }}<img class="iconito" src="icons/roller-coaster.svg"></p>
                                        <p class="age">Edad mínima: {{ $juego->agelimit }}</p>
                                    </div>
                                </th>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6 col-xs-12" id="juegoinfo">
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-xs-12">
            <div class="input-group hidden" id="reservar">
                <input type="number" class="form-control"  placeholder="# Boleto" id="id_boleto">
                <span class="input-group-btn">
                    <button class="btn btn-success" id="irareserva" type="button" disabled>¡Reserva Ahora!</button>
                </span>
            </div><!-- /input-group -->
        </div>
    </div>
</div>
<script type="text/javascript">
    var id_juego = 9999;
    var id_hora = 0;
    @if(isset($juegodisp))
    $( document ).ready(function() {
        $.get('/juegos', { id: "{{ $juegodisp->id}}"}, function(data) {
            $("#juegoinfo").replaceWith(data);
        });
    });
    @endif
    $( ".celljuego" ).click(function() {
        var id_juego = jQuery(this).data("id");
        $( ".celljuego" ).removeClass('selected');
        jQuery(this).addClass('selected');
        $.get('/juegos', { id: id_juego }, function(data) {
                $("#juegoinfo").replaceWith(data);
        });
    });
    $( "#id_boleto" ).on('input', function() {
        if(jQuery(this).val() != ''){
            $( "#irareserva" ).prop('disabled', false);
        }else{
            $( "#irareserva" ).prop('disabled', true);
        }
    });
    function show_button() {
        $("#reservar").removeClass("hidden");
    }
    $( "#irareserva" ).click(function() {
        window.location.replace("reservar?jg="+id_juego+"&dt="+id_hora+"&tk="+$("#id_boleto").val() );
    });

</script>
@endsection