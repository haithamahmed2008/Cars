<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Select * from cars
        $cars = Car::all();

        //Select * with where cluse
       /*  $cars = Car::where('name', '=', 'Audi')
            ->get(); */

        // for processing a larg amount of records for not being in a memory or a lock issues use chunk method to break your request into smaller pices.
        /* $cars = Car::chunk(2, function($cars){
            foreach($cars as $car){
                print_r($car);
            }
        }); */

        //if there is a chance that model may fail or not found we can use findOrFail/firstOrFail method
        /* $cars = Car::where('name', '=', 'Audi')
            ->firstOrFail(); */

        return view('Cars.index',[
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // We Have two ways for storing the data into database 
        // First way
        /* $car = new Car;
        $car->name = $request->input('name');
        $car->founded = $request->input('founded');
        $car->description = $request->input('description');

        $car->save(); */

        // Second way
        $car = Car::create([ //We can use Car::make instead but after we finish we have to call $car-save(), while with create no need
            'name' => $request->input('name'),
            'founded' => $request->input('founded'),
            'description' => $request->input('description')
        ]);

        return redirect('/cars');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::find($id);

        
        return view('Cars.edit')->with('car' , $car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $car = Car::where('id', $id)
            ->update([ 
                'name' => $request->input('name'),
                'founded' => $request->input('founded'),
                'description' => $request->input('description')
        ]);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);

        $car->delete();
        
        return redirect('/cars');
    }
}