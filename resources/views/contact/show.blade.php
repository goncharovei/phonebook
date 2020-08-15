@extends('layouts.app')

@section('content')
<div class="container contact-list">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
					{{ trans('contact.view') }}
					<a class="float-right" href="{{ route('contact_list') }}">{{ trans('contact.back_to_list') }}</a>
				</div>

                <div class="card-body">
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<strong>{{ $contact['name'] }} {{ $contact['lastname'] }}</strong>
						</li>
						@foreach($contact['phones'] as $contact_phone)
							<li class="list-group-item">{{ $contact_phone }}</li>
						@endforeach	
					</ul>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
