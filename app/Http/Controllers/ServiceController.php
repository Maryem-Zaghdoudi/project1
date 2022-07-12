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
        
        
        if ((($request->prix_max)!=null) && ($request->prix_min != null)){
            $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
        }

        if ($request->categorie != "--"){
            $services= Service::where('categorie_id' , $request->categorie)->get();
        }
        if ($request->nom_rech != null){
            $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')->get();
        }

        
        if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null))){
            $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
            ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
        }
        if (($request->nom_rech != null) &&($request->categorie !='--')){
            $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
            ->where('categorie_id' , $request->categorie)
            ->get();
        }
        if (($request->categorie !='--')&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
        if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null)&&($request->categorie !='--'))){
            $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
            ->where('categorie_id' , $request->categorie)
            ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
        }
 
        if ($request->tri != "--"){
            if($request->tri=='prix_decroissant'){
                if ($request->nom_rech != null){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')->get();
                }
                if ($request->categorie != "--"){
                    $services= Service::where('categorie_id' , $request->categorie)->get();
                }
                if ((($request->prix_max)!=null) && ($request->prix_min != null)){
                    $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                if (($request->nom_rech != null) &&($request->categorie !='--')){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->get();
                }
                if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null)&&($request->categorie !='--'))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }        
                if (($request->categorie !='--')&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                $services= $services->sortByDesc('prix')
                ;
            }
            if($request->tri=='prix_croissant'){
                if ($request->nom_rech != null){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')->get();
                }
                if ($request->categorie != "--"){
                    $services= Service::where('categorie_id' , $request->categorie)->get();
                }
                if ((($request->prix_max)!=null) && ($request->prix_min != null)){
                    $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                if (($request->nom_rech != null) &&($request->categorie !='--')){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->get();
                }
                if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null)&&($request->categorie !='--'))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }    
                if (($request->categorie !='--')&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                $services= $services->sortBy('prix')                ;
            }
            if($request->tri=='nom_a_z'){
                if ($request->nom_rech != null){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')->get();
                }
                if ($request->categorie != "--"){
                    $services= Service::where('categorie_id' , $request->categorie)->get();
                }
                if ((($request->prix_max)!=null) && ($request->prix_min != null)){
                    $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                if (($request->nom_rech != null) &&($request->categorie !='--')){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->get();
                }
                if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null)&&($request->categorie !='--'))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }    
                if (($request->categorie !='--')&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                $services= $services->sortBy('nom') ;   
            }
            if($request->tri=='nom_z_a'){
                if ($request->nom_rech != null){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')->get();
                }
                if ($request->categorie != "--"){
                    $services= Service::where('categorie_id' , $request->categorie)->get();
                }
                if ((($request->prix_max)!=null) && ($request->prix_min != null)){
                    $services =Service::whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                if (($request->nom_rech != null) &&($request->categorie !='--')){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->get();
                }
                if (($request->nom_rech != null)&&((($request->prix_max)!=null) && ($request->prix_min != null)&&($request->categorie !='--'))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }    
                if (($request->categorie !='--')&&((($request->prix_max)!=null) && ($request->prix_min != null))){
                    $services= Service::where('nom' , 'LIKE' , '%'.$request->nom_rech.'%')
                    ->where('categorie_id' , $request->categorie)
                    ->whereBetween('prix' , [$request->prix_min , $request->prix_max ])->get();
                }
                $services= $services->sortByDesc('nom') ;   
            }
            
        }
        return view('services.index' , compact('categories'  ,'services'));
    }

}


