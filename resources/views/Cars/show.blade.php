@extends('layouts.app')

 @section('content')

    <div class="m-auto w-4/5 py-24">
        <div class="text-center">
            <h1 class="text-5pxl uppercase font-bold">
                {{$car->name}}
            </h1>
        
            <div class="py-10 text-center">
                
                    <div class="m-auto">
                        

                        <span class="uppercase text-blue-500 font-bold text-xs italic">
                            Founded: {{$car->founded}}
                        </span>
                        

                        <p class="text-lg text-gray-700 py-6">
                            {{$car->description}}
                        </p>
                        <table class="table-auto m-auto">
                            <tr class="bg-blue-100">
                                <th class="w-1/3 border-4 border-gray-500">
                                    Model
                                </th>
                                <th class="w-1/3 border-4 border-gray-500">
                                    Engines
                                </th>
                                <th class="w-1/3 border-4 border-gray-500">
                                    Production Date
                                </th>
                            </tr>
                            @forelse ($car->carModel as $model)
                                <tr>
                                    <td class="border-4 border-gray-500">
                                        {{ $model->model_name }}

                                    </td>
                                    <td class="border-4 border-gray-500">
                                        @foreach ($car->engines as $engine)
                                            @if ($model->id == $engine->model_id )
                                                {{ $engine->engine_name }}
                                                <br>
                                                
                                            @endif
                                            
                                        @endforeach

                                    </td>
                                    <td class="border-4 border-gray-500">
                                        {{ date('d-m-Y', strtotime($car->productionDate->created_at)) }}
                                    </td>
                                </tr>
                                
                            @empty
                                NO CAR MODELS FOUND
                            @endforelse
                        </table>
                        {{-- <ul>
                            @forelse ($car->carModel as $model)
                                <li class="inline italic text-gray-600 px-1 py-6">
                                
                                        {{$model['model_name']}}
                                
                                </li>
                            @empty
                                <p>
                                    <h1 class="text-5pxl uppercase font-bold">
                                        There is no Model for the Current car
                                    </h1>
                                </p>
                            @endforelse
                        </ul> --}}
                        <hr class="mt-4 mb-8">
                    </div>
            </div>
        </div>
    </div>

 @endsection