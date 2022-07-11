<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service ;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $service = Service::all();
        $categories=Category::all();

        //$categorie=Category::find($request->category_id);
        //$categorie=Category::find(1);
        $category = Category::with('services')->find($request->categorie_id );

        $services = Service::with('category')->get();


        //dd($services);
        //$services = Service::with('category')->get();
        /*$services = Service::with('categorie')->get();*/
        //$categories = Category::with('services')->get();
        //dd($services , $categories);

        
        return view('services.index', compact('services', 'categories'));
     

      //return view('index', compact('services'));

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       $categories = Category::all();
        return view('services.create' , compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        //dd($request);
        
        $category=Category::find($request->categorie_id );
        if($request->hasFile('image')){
                $image_name = date('mdYHis') . $request->file('image')->getClientOriginalName();
                $path = public_path('image') ;
                $request->file('image')->move($path,$image_name);
                $request->image = $path.$image_name;
                //dd($category);
                
                $category->services()->create([
                    "nom" => $request->input('nom'),
                    "description" => $request->input('description') ,
                    "prix"=>$request->input('prix'),
                    "image" => $image_name,   
                ]);

            }
            else{
                $category->services()->create([
                    "nom" => $request->input('nom'),
                    "description" => $request->input('description') ,
                    "prix"=>$request->input('prix'),
                ]);
            }
        return redirect('/services')->with('success', 'Service ajouté avec succées!');
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(service $service)
    {
        //
        
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        //
        $categories = Category::all();

        $service = Service::findOrFail($id);

    return view('services.edit', compact('service' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {



    $category=Category::find($request->categorie_id );
        if($request->hasFile('image')){
                $image_name = date('mdYHis') . $request->file('image')->getClientOriginalName();
                $path = public_path('image') ;
                $request->file('image')->move($path,$image_name);
                $request->image = $path.$image_name;
                //dd($category);
                $service=$category->services()->whereId( $id);
                $service->update([
                    "nom" => $request->input('nom'),
                    "description" => $request->input('description') ,
                    "prix"=>$request->input('prix'),
                    "image" => $image_name,   
                ]);

            }
            else{
                $category->services()->whereId($id)->update([
                    "nom" => $request->input('nom'),
                    "description" => $request->input('description') ,
                    "prix"=>$request->input('prix'),
                ]);
            }
            //dd($service->image);
        return redirect('/services')->with('success', 'Service mise à jour avec succèss');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $service = Service::findOrFail($id);
        $service->delete();
    
        return redirect('/services')->with('success', 'Service supprimer avec succèss');
    }

  

    public function Search(Request $request){
        $categories= Category::all();
        $services = Service::all();
        
        if ($request->has('nom_rech')){
            $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')->get();
        }
        if (($request->has('prix_max')) && ($request->has('prix_min'))){
            $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
        }
       
        if ($request->categorie != '--'){
            $services= Service::where('categorie_id' , $request->categorie)->get();
        }
        

        //dd($request->categorie != '--');

        if ($request->tri != '--'){
            if($request->tri=='prix_decroissant'){
                $services= Service::all()->sortByDesc('prix')
                ;
            }
            if($request->tri=='prix_croissant'){
                $services= Service::all()->sortBy('prix')                ;
            }
            if($request->tri=='nom_a_z'){
                $services= Service::all()->sortBy('nom') ;   
            }
            if($request->tri=='nom_z_a'){
                $services= Service::all()->sortByDesc('nom') ;   
            }
            
        }
        if ($request->has('nom_rech')&&($request->categorie !='--')){
            $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
            ->where('categorie_id' , $request->categorie)->get();
        }

      
         if (($request->has('prix_max')) && ($request->has('prix_min'))&& ($request->has('nom_rech'))){
            $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])
            ->where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
            ->get();
        }
        if (($request->has('prix_max')) && ($request->has('prix_min'))&& ($request->has('nom_rech'))&&($request->categorie !='--')){
            $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])
            ->where('categorie_id' , $request->categorie)
            ->where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
            ->get();
        }
     
        
        

        //dd($request);
        /*if($request->has('categorie')){
            $category=Category::find($request->categorie_id );
            // $services= $category->services()->get();
            //dd($request->categorie_id );

        }*/

        return view('services.index' , compact('categories' , 'services'));

    }


    /*public function recherche(Request $request ){

        $categories=Category::all();
       // $services=Service::all();
        if ($request->has('nom_rech')) {
            $services=Service::query()->where('nom', 'LIKE' , '%' . $request->nom_rech .'%' )->get();
        }
        //dd($services);
        if (($request->has('prix_max')) && ($request->has('prix_min'))){
            $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
        }
        /*if ($request->filled('prix_min')){
            $services= Service::where('prix', '>', $request->prix_min)->get();
        }
        if ($request->filled('prix_max')){
            $services= Service::where('prix', '<', $request->prix_max)->get();
        }
        if ($request->hasAny('prix_min' ,'prix_max')) {
            $services= Service::where('prix', '>', $request->prix_min)->orwhere('prix' , '<' , $request->prix_max)->get();
        }
        if ($request->has('tri')){
            if($request->tri='prix_croi'){
                $services= Service::orderBy('prix', 'desc')->get()
                ;
            }

            if($request->tri='prix_decroi'){
                $services= Service::orderBy('prix', 'asc')->get()
                ;
            }
        }
        if ($request->has('categorie')) {
            $services= Service::where('categorie', $request->categorie);
        }
        
        return view('services.index', compact('services', 'categories'));
*/


    }


