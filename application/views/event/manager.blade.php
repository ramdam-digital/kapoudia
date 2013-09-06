@layout('layouts.admin')


@section('content')
<h3>Gérer les événements</h3>

<p><a class="btn" href="{{URL::to_route('add_event')}}"><i class="icon-pencil"></i> Ajouter un événement</a></p>

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Titre</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($events as $page)
    <tr>
      <td>{{$page->id}}</td>
      <td>{{$page->title}}</td>
      <td><a class="btn btn-inverse" href="{{URL::to_route('modify_event', array($page->id))}}"><i class="icon-edit icon-white"></i></a> 
        <a class="btn btn-warning" onclick="del_page({{$page->id}})"><i class="icon-trash icon-white"></i></a></td>
    </tr>
  @endforeach
   
  </tbody>
</table>

@endsection

@section('scripts')
<script type="text/javascript">
  function del_page(id){
    if(confirm('Êtes vous sure de supprimer cet événement?')){
      return window.location = "{{URL::base()}}/admin/event/delete/"+id;
    }else{
      return false;
    }
  }
</script>
@endsection