<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Product;
use App\Rules\Uppercase;
use App\Http\Requests\CreateValidationRequest;

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
    public function store(CreateValidationRequest $request)
    {

        // --------------- Methods we can use on $request regarding the image --------------------

            // Guess Extension --> show the extesion of the image
                //$test = $request->file('image')->guessExtension();
            //Get the Mime Type ---> the type of file (document, image , ..)/extestion
                //$test = $request->file('image')->getMimeType();
            //store(), asStore(), storePublicly()
            //move()
            //getClientOriginalName() ---> getting the name of the file
                //$test = $request->file('image')->getClientOriginalName();
            //getClientMimeType()
            //guessClientExtension() ---> to get the file extension without the name or the dot.
            //getSize()
            //getError()
            //isValid()
        
       // ----------- end of Methods we can use on $request regarding the image -------------------
       
        // ----------Validation----------------------

        $request->validated();

        /* $request->validate([
            'name' => ['required','unique:cars',new Uppercase],
            'founded' => ['required','integer','min:0','max:2023'],
            'description' => ['required'],
        ]); */
        // if it's valid, it will proceed
        // if it's not valid, it will throw a ValidationException with all the necessary validation errors.

        // ---------- End of Validation----------------------

        //----------- Working with Image --------------------

        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension(); //set the name of the image file
        $request->image->move(public_path('images'), $newImageName); //move the image and store it in the public/image folder 

        //--------End Working with Image --------------------

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
            'description' => $request->input('description'),
            'image_path' => $newImageName
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
        $car = Car::find($id);

        /* $products = Product::find(2);

        dd($products->cars); */


        return view('cars.show')->with('car', $car);
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
    public function update(CreateValidationRequest $request, $id)
    {
        $request->validated();
        
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

        // other method of deleting is to pass the model to the destroy function instead of the id
        // public function destroy(Car $car){ $car->delete() } 
    }
}
