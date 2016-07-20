<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\BusinessRepository;
use App\Models\Business;
use Illuminate\Http\Request;
use Flash;
use Response;
use Session;

/*
* Controller class to handle the requests of the basics operations of a business
*/
class BusinessController extends Controller
{

    /**
     * Displays a listing of the Business.
     * @return Response with the view of the businesses index
     */
    public function index()
    {
        $businesses = BusinessRepository::getAll();
        return view('businesses.index')
            ->with('businesses', $businesses);
    }

    /**
     * Shows the form for creating a new Business.
     * @return Response with the view of the form to create a new business
     */
    public function create()
    {
        $sessionBusiness = Session::get('business');
        Session::forget('business');
        return view('businesses.create')->with('business', $sessionBusiness);
    }

    /**
     * Stores a newly created Business in the database.
     * @param Request $request with the data of the new business
     * @return Response with a redirection the the business index
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if($input['name'] == ''){
            Flash::error('The business must have a name.');
            Session::put('business', $input);
            return redirect(route('businesses.create'));
        }
        if($input['lat'] == '' || $input['long'] == ''){
            Flash::error('The business must have a latitude and a longitude.');
            Session::put('business', $input);
            return redirect(route('businesses.create'));
        }
        if(BusinessRepository::create($input)){
            Flash::success('Business saved successfully.');
        }
        else{
            Flash::error('Something went wrong, please try later.');
        }
        return redirect(route('businesses.index'));
    }

    /**
     * Displays the specified Business.
     * @param  int $id  Representing the identifier of the business
     * @return Response redirecting to the detail of the business if the business was found,
     *           or redirecting to the index if not.
     */
    public function show($id)
    {
        $business = BusinessRepository::findById($id);

        if (empty($business)) {
            Flash::error('Business not found');

            return redirect(route('businesses.index'));
        }

        return view('businesses.show')->with('business', $business);
    }

    /**
     * Shows the form for editing the specified Business.
     * @param  int $id Representing the identifier of the business
     * @return Response redirecting to the edit form of the business if the business was found,
     *           or redirecting to the index if not.
     */
    public function edit($id)
    {
        $business = BusinessRepository::findById($id);

        if (empty($business)) {
            Flash::error('Business not found');

            return redirect(route('businesses.index'));
        }

        return view('businesses.edit')->with('business', $business);
    }

    /**
     * Updates the specified Business in storage.
     * @param  int $id Representing the identifier of the business
     * @param Request $request with the new data of the business
     * @return Response redirecting to the index whether the operation is succesfull or not
     */
    public function update($id, Request $request)
    {
        $business = BusinessRepository::findById($id);

        if (empty($business)) {
            Flash::error('Business not found');

            return redirect(route('businesses.index'));
        }
        $input = $request->all();
        if($input['name'] == ''){
            Flash::error('The business must have a name.');
            return redirect(route('businesses.edit', ['businesses' => $id]));
        }

        if($input['lat'] == '' || $input['long'] == ''){
            Flash::error('The business must have a latitude and a longitude.');
            return redirect(route('businesses.edit', ['businesses' => $id]));
        }

        if(BusinessRepository::update($input, $id)){
            Flash::success('Business updated successfully.');
        }
        else{
            Flash::errot('Something went wrong while updating the business.');
        }

        return redirect(route('businesses.index'));
    }

    /**
     * Removes the specified Business from storage.
     * @param  int $id Representing the identifier of the business
     * @return Response redirecting to the index whether the operation is succesfull or not
     */
    public function destroy($id)
    {
        $business = BusinessRepository::findById($id);

        if (empty($business)) {
            Flash::error('Business not found');

            return redirect(route('businesses.index'));
        }

        BusinessRepository::delete($id);

        Flash::success('Business deleted successfully.');

        return redirect(route('businesses.index'));
    }
}
