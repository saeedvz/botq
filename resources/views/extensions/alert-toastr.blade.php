@if(!session('type'))
	@if(count($errors) || session('alert') || session('status'))
		<script type="text/javascript">
            $(document).ready(function () {
                window.toastr.options = {
                    "positionClass": "toast-bottom-center"
                };
				@if (count($errors))
					@foreach ($errors->all() as $error)
							window.toastr['error']("{!! $error !!}")
					@endforeach
				@endif
				@if(session('alert'))
                    window.toastr["{{ session('alert') }}"]("{!! session('message') !!}")
				@endif
            });
		</script>
	@endif
@endif