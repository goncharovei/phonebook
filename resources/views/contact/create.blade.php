@extends('layouts.app')

@section('content')
<div class="container contact-list">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					{{ trans('contact.create') }}
					<a class="float-right" href="{{ route('contact_list') }}">{{ trans('contact.back_to_list') }}</a>
				</div>

                <div class="card-body">
					<form class="needs-validation" method="post" action="{{ route('contact_store') }}" novalidate>
						@csrf
						<div class="form-row">
							<div class="col">
								<input value="{{ old('name') }}" type="text" maxlength="{{ $name_max_length }}" name="name" class="form-control" placeholder="{{ trans('contact.first_name') }}" required>
								<small class="form-text text-muted">{{ trans('contact.no_more_than', ['PHONE_MAX_LENGTH' => $name_max_length]) }}</small>
							</div>
							<div class="col">
								<input value="{{ old('lastname') }}" type="text" maxlength="{{ $lastname_max_length }}" name="lastname" class="form-control" placeholder="{{ trans('contact.last_name') }}">
								<small class="form-text text-muted">{{ trans('contact.no_more_than', ['PHONE_MAX_LENGTH' => $lastname_max_length]) }}</small>
							</div>
						</div>
						
						<div class="form-group">
							<label>Phones</label>
							@for ($phone_index = 0; $phone_index < $phones_max_count; $phone_index+=2)
							<div class="form-row">
								<div class="col">
									<input value="{{ old('phones.' . $phone_index) }}" maxlength="{{ $phone_max_length }}" type="text" name="phones[]" class="form-control">
								</div>
								<div class="col">
									<input value="{{ old('phones.' . ($phone_index + 1)) }}" maxlength="{{ $phone_max_length }}" type="text" name="phones[]" class="form-control">
								</div>
							</div>
							@endfor
							<small class="form-text text-muted">{{ trans('contact.no_more_than', ['PHONE_MAX_LENGTH' => $phone_max_length]) }}</small>
						</div>
						<button class="btn btn-primary" type="submit">{{ trans('contact.submit') }}</button>
					</form>
                </div>


            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_script')
<script type="text/javascript" src="{{ asset('js/contact_form.js') }}"></script>
@endsection