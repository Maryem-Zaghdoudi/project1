<!-- index.blade.php -->

@extends('layout')

@section('content')

<style>
  .uper {
    margin-top: 40px;
  }
  .card-img-top{
    height: 120px;
    width: 15reù;
    position: relative;
  }
  .card-body{
    text-align: left;
  }
  .table-head{
      text-align: center;
  }
  
  </style>
    <div class="uper">
      @if(session()->get('success'))
        <div class="alert alert-success">
          {{ session()->get('success') }}  
        </div><br />
      @endif
      <div class="row">
          <div class="col-9">
              <h2>Liste des catégories</h2>
          </div>
          <div class="col ">
            <a href="{{ route('categories.create')}}" class="btn btn-outline-secondary">Ajouter une catégorie</a>
        </div>
      </div>

<table class="table table-bordred uper">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nom Categorie</th>
        <th scope="col" class="table-head">Action</th>
       
      </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)

        <tr>
            <td>{{ $category->id }}</td>
        <td>{{ $category->nom_categorie }}</td>
        <td>
            <div class="row ">
                <div class="col-md-3 offset-4">
                    <form action="{{ route('categories.destroy', $category->id)}}" method="post">
                         @csrf
                        @method('DELETE')
                        <button class="btn btn-danger " type="submit">Supprimer</button>
                    </form>
                </div>
                <div class="col-md-3 ">
                    <a href="{{ route('categories.edit', $category->id)}}" class="btn btn-primary">Modifier</a>
                </div>
            </div>
        </td>
        @endforeach

        
      </tr>
      
    </tbody>
  </table>


</div>
</div>
  </div>
  

@endsection
