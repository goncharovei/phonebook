<?php

namespace App\Http\Controllers;

use Auth;
use App\Forms\ContactForm;
use App\Models\Contact;
use Validator;
use Illuminate\Http\Request;

class ContactController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$items = Contact::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->get();

		return view('index', compact('items'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('contact.create', ContactForm::limits());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$validator = Validator::make(
			ContactForm::requestData($request),
			ContactForm::validationRules()
		);
		if ($validator->fails()) {
			return redirect()->route('contact_create')
							->withErrors($validator)
							->withInput();
		}
		
		$contact_add = new Contact(['user_id' => Auth::user()->id] + $validator->valid());
		Auth::user()->contacts()->save($contact_add);
		
		return redirect()->route('contact_list')
						->with('success', trans('contact.contact_created_successfully'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Contact $contact
	 * @return \Illuminate\Http\Response
	 */
	public function show(Contact $contact) {
		if (empty($contact->id) || $contact->user_id != Auth::user()->id) {
			abort(404);
		}
		
		$contact = array_only($contact->toArray(), ['name', 'lastname', 'phones']);
		
		return view('contact.show', compact('contact'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  Contact $contact
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Contact $contact, Request $request) {
		if (empty($contact->id) || $contact->user_id != Auth::user()->id) {
			abort(404);
		}
		
		$inputs = [
			'name' => $contact->name,
			'lastname' => $contact->lastname,
			'phones' => $contact->phones,
		];
		if ($request->session()->has('inputs')) {
			$inputs = $request->session()->get('inputs');
		}	
		$request->session()->flashInput($inputs);
		
		return view('contact.edit', [	'contact_id' => $contact->id] + ContactForm::limits());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  Contact $contact
	 * @return \Illuminate\Http\Response
	 */
	public function update(Contact $contact, Request $request) {
		if (empty($contact->id) || $contact->user_id != Auth::user()->id) {
			abort(404);
		}
		
		$request_data = ContactForm::requestData($request);
		$validator = Validator::make($request_data, ContactForm::validationRules());
		if ($validator->fails()) {
			return redirect()->route('contact_edit', ['contact'=>$contact->id])
							->withErrors($validator)
							->with('inputs', $request_data);
		}
		
		$contact->fill($validator->valid());
		$contact->save();
		
		return redirect()->route('contact_list')
						->with('success', trans('contact.contact_updated_successfully'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Contact $contact
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Contact $contact, Request $request) {
		$result = [
			'success' => 0,
			'success_box' => '',
		];
		
		try {
			if (!$request->ajax()) {
				return redirect('/');
			}

			if (empty($contact->id) || $contact->user_id != Auth::user()->id) {
				return response()->json($result);
			}

			$result['success'] = intval($contact->delete());
			$result['success_box'] = view('includes.alert_success', ['message' => trans('contact.contact_deleted_successfully')])->render();
			
		} catch (\Exception $ex) {
			$logger = app(\Psr\Log\LoggerInterface::class);
			$logger->error(
				'error_text=' . $ex->getMessage() . "\n" .
				'error_trace=' . $ex->getTraceAsString()
			);
		}
		
		return response()->json($result);
	}

}
