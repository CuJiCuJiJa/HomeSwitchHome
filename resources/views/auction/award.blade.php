@extends('layouts.app')

@section('content')
<div class="container mask-white">
    <div class="row justify-content-center">
        <div class="col-12 text-md-center full-height">
            
                <div class="card">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h2>El ganador es: {{ $user->name }}</h2>
                        <form action="route('auction.award')" method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary">Adjudicar!</button>
                        </form>
                </div>
            @endif
            <a href="{{ URL::previous() }}">Volver</a>
        </div>
    </div>
</div>
@endsection
