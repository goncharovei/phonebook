@extends('layouts.app')

@section('content')
<div class="container contact-list">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">List</div>
					
				<nav class="navbar navbar-light bg-light justify-content-between">
					<a class="btn btn-success" href="{{ route('contact_create') }}">{{ trans('contact.create') }}</a>
					<!--todo-->
					<!--form class="form-inline">
						<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form-->
				</nav>

                <div class="card-body">
                    @if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
                    @endif

					@if (!$items->isEmpty())

					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th scope="col">{{ trans('contact.name') }}</th>
									<th scope="col">{{ trans('contact.surname') }}</th>
									<th scope="col">&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($items as $item)
								<tr class="js-box-contact">
									<td class="w-42">{{ $item->name }}</td>
									<td class="w-42">{{ $item->lastname }}</td>
									<td class="w-16 box-actions">
										<a href="{{ route('contact_view', ['contact' => $item->id]) }}"><i class="fa fa-eye on"></i></a>
										<a href="{{ route('contact_edit', ['contact' => $item->id]) }}"><i class="fa fa-pencil"></i></a>
										<a href="{{ route('contact_delete', ['contact' => $item->id]) }}" data-toggle="modal" data-target="#contactTrash"><i class="fa fa-trash-o"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>	
					@else

					<p class="text-center">{{ trans('contact.the_list_is_empty') }}</p>

					@endif
                </div>
				<!--Maybe need to do pager-->
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="contactTrash" tabindex="-1" role="dialog" aria-labelledby="contactTrashLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="contactTrashLabel">Delete contact</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				{{ trans('contact.are_you_sure_you_want_to_delete_the_contact') }}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('contact.no') }}</button>
				<button type="button" id="js_contact_trash_button" class="btn btn-primary">{{ trans('contact.yes') }}</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer_script')
<script type="text/javascript" src="{{ asset('js/contact_list.js') }}"></script>
@endsection
