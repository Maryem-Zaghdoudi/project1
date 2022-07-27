<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\categorie;
use Illuminate\Http\Request;



class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$categories=Category::with('allChildren')->get();
        //=Category::all();

        $categories=Category::where('position' , 0)->get();
        //$category=Category::find(1);
        //$category_ids[] = $category->getDescendants($category);
        
        //dd($category_ids);
        //dd(Category::where("position" , 0)->get());
        //$categorie = Category::find(1);
        //$categories = $categorie->children;
        //dd($categorie->parent());
        //dd($category);
        //dd($categories);
        return view('categories.index', compact('categories' ));
     

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::all();

        return view('categories.create' , compact('categories'));

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
        //dd(Category::find($request->parent_id));
    
        if ($request->parent_id==0){
            $position = 0;
        }
        else{
            $position = Category::find($request->parent_id)->position + 1;
        }
        Category::create(
            [
                "nom_categorie"=> $request->nom_categorie,
                "parent_id"=> $request->parent_id,
                "position"=> $position
                    
                ]
        );
        
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categories=Category::all();
        $categorie = Category::findOrFail($id);
        //dd($categorie);
    return view('categories.edit', compact( 'categorie' , 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $category=Category::find($request->id);
        Category::whereId($id)->update($request->except(['_token' , '_method']));
        return redirect('/categories')->with('success', 'Categorie mise à jour avec succèss');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Category::findOrFail($id)->delete();
        return redirect('/categories')->with('success', 'Categorie supprimé avec tousces services');
    

    }

    protected $appends = [
        'getParentTree'
    ];
    public function getParentTree($category , $nom_categorie){
        if($category->parent_id == 0){
            return $nom_categorie;
        }
        
            //dd(Category::find($category->parent_id));
        $parent=Category::find($category->parent_id);
        //dd($category);
        $nom_categorie= $parent->nom_categorie . "->" . $nom_categorie;
        return CategorieController::getParentTree($parent , $nom_categorie);
        }

    public static function getChildren($categorie_id){
        $category=Category::find($categorie_id);
        if ($category->children){
            foreach ($category->allChildren as $child){
                return CategorieController::getChildren($child->id);
            }    
        }
        return ($category->id);
        }
        

}
