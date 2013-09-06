@layout('layouts.admin')


@section('content')
<h3>Gérer les utilisateurs</h3>

{{Form::open(URL::to_route('change_user'), 'PUT')}}
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Nom d'utilisateur</th>
      <th>Email</th>
      <th>Rôle</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($users as $user)
    <tr>
      <td>{{$user->id}}</td>
      <td>{{$user->username}}</td>
      <td>{{$user->email}}</td>
      <td>{{Form::select('pro['.$user->id.']', array(1=>'Membre', 3=>'Membre Pro'), $user->role)}}</td>
      <td>
        <a class="btn btn-warning" onclick="del_page({{$user->id}})"><i class="icon-trash icon-white"></i></a></td>
    </tr>
  @endforeach
   <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><input class="btn btn-inverse" value="Mettre à jour" type="submit"></td>
      <td></td>
    </tr>
  </tbody>
</table>
{{Form::close()}}


@endsection

@section('scripts')
<script type="text/javascript">
  function del_page(id){
    if(confirm('Êtes vous sure de supprimer cet utilisateur?')){
      return window.location = "{{URL::base()}}/admin/page/delete/"+id;
    }else{
      return false;
    }
  }
</script>
@endsection