@props(['category'])



<div class="row m-3">
    <div class="col-4 ">
        
        @php echo App\Http\Controllers\CategorieController::getParentTree($category , $category->nom_categorie); 
        
        @endphp
    </div>
            <div class="col-4 offset-3">
               <form action="{{ route('categories.destroy', $category->id)}}" method="post">
                     @csrf
                    @method('DELETE')
                    <button class="btn btn-danger " type="submit">Supprimer</button>
                </form>
            </div>
            <div class="col">
                <a href="{{ route('categories.edit', $category->id)}}" >Modifier</a>
            </div>
        </div>
</div>
        @if (count($category->children) > 0)
            
    
                @foreach ($category->children as $sub)
                
                <tr >
                    <td >
                        <x-sub-category  :category="$sub"/>
                    </td>
                </tr>
                @endforeach
            
        @endif

    