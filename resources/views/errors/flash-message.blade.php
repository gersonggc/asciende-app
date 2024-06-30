@if ($message = Session::get('alert-success'))
<div class="alert alert-success alert-dismissible">
        <strong>{{ $message }}</strong>
        @if($referenceMessage = Session::get('alert-success-reference'))
                <span style="font-weight:bold">{{ $referenceMessage }}</span>
        @endif
	<button type="button" class="close" data-dismiss="alert">×</button>	
</div>
@endif
@if ($message = Session::get('alert-warning'))
<div class="alert alert-warning alert-dismissible">
        <strong>{{ $message }}</strong>
	<button type="button" class="close" data-dismiss="alert">×</button>	
</div>
@endif
@if ($message = Session::get('alert-info'))
<div class="alert alert-info alert-dismissible">
        <strong>{{ $message }}</strong>
	<button type="button" class="close" data-dismiss="alert">×</button>	
</div>
@endif
@if ($message = Session::get('alert-primary'))
<div class="alert alert-primary alert-dismissible">
        <strong>{{ $message }}</strong>
	<button type="button" class="close" data-dismiss="alert">×</button>	
</div>
@endif