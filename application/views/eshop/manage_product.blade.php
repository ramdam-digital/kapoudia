@layout('layouts.admin')


@section('content')
<h3>Gérer les produits</h3>

<p><a class="btn" href="{{URL::to_route('add_product')}}"><i class="icon-pencil"></i> Ajouter un produit</a></p>

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Libellé</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($products as $p)
    <tr>
      <td>{{$p->id}}</td>
      <td>{{$p->label}}</td>
      <td><a class="btn btn-inverse" href="{{URL::to_route('edit_product', array($p->id))}}"><i class="icon-edit icon-white"></i></a> 
        <a class="btn btn-warning" onclick="del_page({{$p->id}})"><i class="icon-trash icon-white"></i></a></td>
    </tr>
  @endforeach
   
  </tbody>
</table>

@endsection

@section('scripts')
<script type="text/javascript">
  function del_page(id){
    if(confirm('Êtes vous sure de supprimer ce produit?')){
      return window.location = "{{URL::base()}}/admin/product/delete/"+id;
    }else{
      return false;
    }
  }
</script>
@endsection