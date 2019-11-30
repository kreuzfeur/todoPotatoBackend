<?php

namespace App\Http\Controllers;

use App\Transformers\UnitTransformer;
use App\Unit;
use Illuminate\Http\Request;

class UnitController extends ApiController
{
	protected $unitTransformer;
	private $_MAX_PER_PAGE = 5;

	function __construct(UnitTransformer $unitTransformer)
	{
		$this->unitTransformer = $unitTransformer;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return $this->respond($this->unitTransformer->transformCollection(Unit::all()->toArray()));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Unit  $unit
	 * @return \Illuminate\Http\Response
	 */
	public function show(Unit $unit)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Unit  $unit
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Unit $unit)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Unit  $unit
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Unit $unit)
	{
		//
	}
}
