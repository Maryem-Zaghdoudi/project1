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
        <th scope="col">Nom Categorie</th>
        <th scope="col" >Action</th>
       
      </tr>
    </thead>
    <tbody>


  
    @foreach ($categories as $category)
    
    <tr>
     
    <td >

      <x-sub-category :category="$category"/>

    </td>

        @endforeach

        
      </tr>
     
      
    </tbody>
  </table>


</div>
</div>
  </div>
  

@endsection
