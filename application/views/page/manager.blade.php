@layout('layouts.admin')


@section('content')
<h3>Gérer les pages</h3>

<p><a class="btn" href="{{URL::to_route('add_page')}}"><i class="icon-pencil"></i> Ajouter une page</a></p>

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Titre</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($pages as $page)
    <tr>
      <td>{{$page->id}}</td>
      <td>{{$page->title}}</td>
      <td><a class="btn btn-inverse" href="{{URL::to_route('modify_page', array($page->id))}}"><i class="icon-edit icon-white"></i></a> 
        <a class="btn btn-warning" onclick="del_page({{$page->id}})"><i class="icon-trash icon-white"></i></a></td>
    </tr>
  @endforeach
   
  </tbody>
</table>

@endsection

@section('scripts')
<script type="text/javascript">
  function del_page(id){
    if(confirm('Êtes vous sure de supprimer cette page?')){
      return window.location = "{{URL::base()}}/admin/page/delete/"+id;
    }else{
      return false;
    }
  }
</script>
@endsection