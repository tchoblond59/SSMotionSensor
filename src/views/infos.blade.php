@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Info du capteur</h1><hr>
                @foreach($nbActivation as $activation)
                    <div>Le: {{\Carbon\Carbon::parse($activation->date)->format('d/m/Y')}} il y a eu {{$activation->compte}} personnes</div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
