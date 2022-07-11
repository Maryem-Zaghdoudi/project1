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

      <form method="post" action="{{ route('services.store') }}" enctype="multipart/form-data">
   @csrf
          <div class="form-group">
              <label for="nom">Nom de service:</label>
              <input type="text" class="form-control" name="nom"/>
          </div>

          <div class="form-group">
              <label for="description">Description :</label>
              <textarea rows="4" cols="50" id="description" class="form-control" name="description"></textarea>
            </div>
            <div class="form-group">
              <label for="prix">Prix :</label>
              <input type="number" class="form-control" name="prix"/>
            </div>

          <div class="form-group">
            <label for="image">Image :</label>
            <input type="file"  accept="image/png, image/jpeg" class="form-control" name="image" />
        </div>
        <div class="row">
          <div class="col-9">
        <div class="form-group ">
          <label for="categorie">Choisir la categorie: </label>
          <select name="categorie_id" id="categorie_id" class="form-select"  >
            <option value="--"> Choisir la categorie </option>
  
            @foreach ($categories as $item)
            <option value="{{ $item->id }}">  {{ $item->nom_categorie }} </option>
            
            @endforeach
          </select>
        </div>
      </div>
      <div class="col mt-4">
        <a href="{{ route('categories.index')}}" class="btn btn-outline-secondary">consulter liste des categories</a>

      </div>
  </div>
        <div class="row">
          <div class="col-6">
          <a href="{{ route('services.index')}}" class="btn btn-primary mt-3 buttom"">annuler </a>
          </div>
          <div class="col offset-1">
          <button type="submit" class="btn btn-primary mt-3 buttom">Ajouter</button>
          </div>
        </div>
      </form>
  </div>
</div>
@endsection
