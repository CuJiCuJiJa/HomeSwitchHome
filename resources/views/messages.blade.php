@if(Session::has('success'))
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert">×</a>
             {!!Session::get('success')!!}
        </div>
  @endif




@if ($message = Session::has('deleted'))

<div class="alert alert-info alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong><a href="/getRecover">{{$message = Session::get('deleted')}}</a></strong>
	

</div>

@endif

@if ($message = Session::has('rideConfirmationDelete'))

<div class="alert alert-info alert-block">
	<form action="{{ route('ride.delete', $ride->id) }}" method="POST">
            {{method_field('DELETE')}}
            {{ csrf_field() }}
            <button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{$message = Session::get('rideConfirmationDelete')}}</strong>
			<button type="submit" class="btn-danger btn">Confirmar</button>
    </form>
</div>

@endif


@if ($message = Session::has('error'))
	
	<div class="alert alert-danger alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>	

        <strong>{{ $message = Session::get('error') }}</strong>

</div>

@endif


@if ($message = Session::has('warning'))

<div class="alert alert-warning alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>	

	<strong>{{ $message = Session::get('warning') }}</strong>

</div>

@endif


@if ($message = Session::has('info'))

<div class="alert alert-info alert-block">

	<button type="button" class="close" data-dismiss="alert">×</button>	

	<strong>{{ $message = Session::get('info') }}</strong>

</div>

@endif