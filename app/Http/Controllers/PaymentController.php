<?php

namespace App\Http\Controllers;

use App\Defendant;
use App\Judge;
use App\Lawyer;
use App\LawyerEducation;
use App\Payment;
use App\Transformers\PaymentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends ApiController
{
	protected $paymentTransformer;
	private $_MAX_PER_PAGE = 10;

	function __construct(PaymentTransformer $paymentTransformer)
	{
		$this->paymentTransformer = $paymentTransformer;
	}

	public function index(Request $request)
	{
		$limit = (int) $request->get('limit');
		if (!($limit > 0 && $limit <= $this->_MAX_PER_PAGE)) {
			$limit = $this->_MAX_PER_PAGE;
		}

		$payments = Payment::with(['lawyer', 'defendant', 'lawyerEducation', 'judge', 'type'])->paginate($limit);
		// dd($payments);
		// $payments = Payment::with('lawyers')::paginate($limit);
		return $this->respondWithPagination($payments, [
			'data' => $this->paymentTransformer->transformCollection($payments->all()),
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'date' => 'required|date',
			'cash' => 'required|numeric|between:0,1000000.00',
			'lawyer' => 'required',
			'lawyer_education' => 'required',
			'defendant' => 'required',
			'judge' => 'required',
			'type' => 'required',
		]);

		if ($validator->fails()) {
			return $this->respondInvalidInput($validator->errors()->toArray());
		}
		$valid = $validator->validated();
		$lawyer           = Lawyer::firstOrCreate(['name' => $valid['lawyer']])->id;
		$lawyer_education = LawyerEducation::firstOrCreate(['name' => $valid['lawyer_education']])->id;
		$defendant        = Defendant::firstOrCreate(['name' => $valid['defendant']])->id;
		$judge            = Judge::firstOrCreate(['name' => $valid['judge']])->id;
		dd($validator->validated());
		

		// $user = User::first();

		// $post = $user->posts()->create([
		// 	'title' => $request->input('title'),
		// 	'body' => $request->input('body'),
		// ]);
		// return $this->respondSuccessCreation($post->toArray());
	}
}
