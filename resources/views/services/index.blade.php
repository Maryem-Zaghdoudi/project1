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
  
  </style>
  <div class="row uper">
    <div class="col-9">
        <h2>Liste des services</h2>
    </div>
    <div class="col ">
      <a href="{{ route('services.create')}}" class="btn btn-outline-secondary">Ajouter un service</a>
  </div>
</div>
<div id="app">
  <example-component></example-component>
</div>
<div class="row">
  <div class="col-md-8">
    <div class="uper">
      @if(session()->get('success'))
        <div class="alert alert-success">
          {{ session()->get('success') }}  
        </div><br />
      @endif
      
        <div class="row">
          @foreach($services as $service)
          <div class="col-md-4">
            <div class="card mb-3" style="width: 15rem;">
              <div class="card-header">
                <img src="{{ asset('image/'. $service->image) }}" class="card-img-top ">
      
              </div>
              <div class="card-body">
                <h5 class="card-title">ID : {{$service->id}}</h5>
                <h2>{{$service->nom}}</h2>
                @if ( ($service->promotion) > 0 )
                  <div class="row">
                    <h4> <strong> {{ $service->prix_promo }} TND</strong></h4>
                  </div>
                  <div class="row">
                    
                    <div class="col"><del>{{ $service->prix_initiale }} TND</del></div>
                    <div class="col"> - {{ $service->promotion  }} % </div>
                  </div>
                @else
                <h4> {{$service->prix_initiale}} TND</h4>
                @endif
            
                <p class="card-text"><strong>Categorie:</strong><br>
                  {{$service->category->nom_categorie }}
                    
                  </p>
                <div class="row">
                  <div class="col ">
                      <form action="{{ route('services.destroy', $service->id)}}" method="post">
                        @csrf
                          @method('DELETE')
                         <button class="btn btn-danger" type="submit">Supprimer</button>
                       </form>
                  </div>
                  <div class="col"> 
                    <a href="{{ route('services.edit', $service->id)}}" class="btn btn-primary">Modifier</a>
                  </div>

                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
    </div>
  </div>
<div class="col-md-4 uper">
  <div class="card">
    <div class="card-body">
    <h3 class="mt-3">Recherchez un service</h3>
    <br>
    <form method="post" action="{{ route('services.search') }}" enctype="multipart/form-data">
      @csrf

    <div class="form-group">
      
      <label for="nom_rech">Saisir le nom du service</label>
      <input type="text" class="form-control" name="nom_rech" id="nom_rech"/>
    </div>
    <br>
    <div class="form-group ">
      <label for="nom">Prix</label>
      <div class="row ">
        <div class="col-6 ml-1 ">
          <input type="number"  class="form-control" name="prix_min" id="prix_min" placeholder="minimum" />
        </div>
        <div class="col-6 ">
          <input type="number" class="form-control" name="prix_max" id="prix_max" placeholder="maximum" />
        </div>
        </div>
    </div>
    <br>
    
    <div class="form-group ">
      <label for="categorie">Rechercher par categorie: </label>
      <select name="categorie" id="categorie" class="form-select"  >
        <option value="--"> Choisir la categorie </option>
  
        @foreach ($categories as $item)
        <option value="{{ $item->id }}">  {{ $item->nom_categorie }} </option>
        
        @endforeach
      </select>
    </div>
  <div class="form-group ">
    <label for="tri">Trier par : </label>
    <select name="tri" id="tri" class="form-select"  >
      <option value="--"> --   </option>
      <option value="plus_recent"> PLus recent </option>

      <option value="prix_croissant"> Prix croissant  </option>
      <option value="prix_decroissant"> Prix decroissant </option>
      <option value="nom_a_z">Nom , A à Z </option>
      <option value="nom_z_a"> Nom , Z à A  </option>
      <option value="promo"> Service en promotion </option>

      

    </select>
  </div>
  <div class="col offset-1">
    
    <button type="submit" class="btn btn-primary mt-3 buttom">Filtrer</button>
  </div>
  <!-- Button -->

@endsection
