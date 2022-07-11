@extends('layout')

@section('content')

<style>
  .uper {
    margin-top: 40px;
  }
  .card-img{
    height: 120px;
    width: 18rem;
    position: relative;
  }
  .buttom{
    width: 25%;
  margin-left: 10%    
  }
  
</style>

<div class="card uper">
  <div class="card-header">
    Modifier le service
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

      <form method="post" action="{{ route('services.update', $service->id ) }}" enctype="multipart/form-data">
          <div class="form-group">
              @csrf
              @method('PUT')
              <label for="nom">Nom :</label>
              <input type="text" class="form-control" name="nom" value="{{ $service->nom }}"/>
          </div>

          <div class="form-group">
              <label for="cases">description :</label>
              <input type="text" class="form-control" name="description" value="{{ $service->description }}"/>
          </div>
          <div class="form-group">
            <label for="prix">Prix :</label>
            <input type="number" class="form-control" name="prix" value="{{ $service->prix }}"
          </div>
          <div class="form-group ">
            <label for="categorie">Changer la categorie: </label>
            <select name="categorie_id" id="categorie_id" class="form-select"  >
              <!--<option value="{{ $service->categorie_id }}" selected>  {{ $service->category->nom_categorie }} </option>
              -->
              @foreach ($categories as $item)
              <option value="{{ $item->id }}" {{ $service->categorie_id == $item->id ? 'selected':'' }} > 
                 {{ $item->nom_categorie }} </option>
              @endforeach
            </select>
          </div>
      <div class="card mt-3 mb-3" style="width: 18rem;">
			<div class="card-header">Image actuelle </div>
			<img class="card-img" src="{{ asset('image/'. $service->image)  }}" >
      </div>
		

      <div class="form-group">
        <label for="image">Image :</label>
        <input type="file"  accept="image/png, image/jpeg" class="form-control" name="image" />
    </div>
        <div class="row">
        <div class="col-6">
          <a href="{{ route('services.index')}}" class="btn btn-primary mt-3 buttom"">annuler </a>
          </div>
          <div class="col offset-1">
          <button type="submit" class="btn btn-primary mt-3 buttom">Modifier</button>
          </div>
        </div>
      </form>
  </div>
</div>
@endsection