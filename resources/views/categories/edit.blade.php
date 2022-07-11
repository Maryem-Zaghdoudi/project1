<!-- create.blade.php -->

@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
  .buttom{
    width: 25%;
  margin-left: 10%    
  }
</style>

<div class="card uper">
  <div class="card-header">
    Ajouter un Service
  </div>

  <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div><br />
  @endif


  <form method="post" action="{{ route('categories.update', $categorie->id ) }}" enctype="multipart/form-data">
    <div class="form-group">
        @csrf
        @method('PATCH')
        <label for="nom_categorie">Nom du categorie :</label>
        <input type="text" class="form-control" name="nom_categorie" value="{{ $categorie->nom_categorie }}"/>
    </div>

    


  <div class="row">
  <div class="col-6">
    <a href="{{ route('categories.index')}}" class="btn btn-primary mt-3 buttom"">annuler </a>
    </div>
    <div class="col offset-1">
    <button type="submit" class="btn btn-primary mt-3 buttom">Modifier</button>
    </div>
  </div>
</form>


  </div>
</div>
@endsection
