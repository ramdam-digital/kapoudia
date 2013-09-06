@layout('layouts.admin')


@section('content')
<h3>Gérer les catégories</h3>

<p><a class="btn" href="{{URL::to_route('add_category')}}"><i class="icon-pencil"></i> Ajouter une catégorie</a></p>

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Libellé</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($categories as $categorie)
    <tr>
      <td>{{$categorie->id}}</td>
      <td>{{$categorie->label}}</td>
      <td>
        <a class="btn btn-inverse" href="{{URL::to_route('modify_category', array($categorie->id))}}"><i class="icon-edit icon-white"></i></a> 
        <a class="btn btn-warning" onclick="del_page({{$categorie->id}})"><i class="icon-trash icon-white"></i></a>
        @if($categorie->model=='eshop')
        <a class="btn" href="{{URL::to_route('assoc_category', array($categorie->id))}}"><i class="icon-th-list"></i></a>
        @endif
      </td>
    </tr>
  @endforeach
   
  </tbody>
</table>

@endsection

@section('scripts')
<script type="text/javascript">
  function del_page(id){
    if(confirm('Êtes vous sure de supprimer cette catégorie?')){
      return window.location = "{{URL::base()}}/admin/category/delete/"+id;
    }else{
      return false;
    }
  }
</script>
@endsection