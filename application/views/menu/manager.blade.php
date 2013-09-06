@layout('layouts.admin')


@section('content')
<h3>Gérer les menus</h3>

<p><a class="btn" href="{{URL::to_route('add_menu')}}"><i class="icon-pencil"></i> Ajouter un menu</a></p>

<table class="table table-striped">
  <thead>
    <tr>
      <th></th>
      <th>Libellé</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($menus as $menu)
    <?php 
    $submenu = Menu::allByCategory($menu->id, $lang);
    ?>
    <tr id="menu_{{$menu->id}}">
      <td style="width:18px;"><img src="{{URL::base()}}/backend/img/drag.png" style="height:16px;width:16px;cursor:pointer;" > </td>
      <td>{{$menu->label}}</td>
      <td>
        <a class="btn btn-inverse" href="{{URL::to_route('modify_menu', array($menu->id))}}"><i class="icon-edit icon-white"></i></a> 
        <a class="btn btn-warning" onclick="del_page({{$menu->id}})"><i class="icon-trash icon-white"></i></a>
        @if($submenu)
        <a class="btn" href="{{URL::to_route('manage_menu', array($menu->id))}}"><i class="icon-list"></i></a>
        @endif
      </td>
    </tr>
  @endforeach
   
  </tbody>
</table>

{{Form::open(URL::to_route('reorder_menu'))}}
<p><a class="btn" id="reorder"><i class="icon-download-alt"></i> Enregistrer l'ordre</a></p>
<input type="hidden" name="order" value="" id="order"> 
<input type="hidden" name="current" value="{{$current_menu}}" id="current">
{{Form::close()}}

@endsection


@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    $(".table tbody").sortable().disableSelection();

    $("#reorder").click(function(){
      var idsInOrder = $(".table tbody").sortable("toArray");
      var i;
      var txt = "";
      for(i=0;i<idsInOrder.length;i++){
        txt = txt + idsInOrder[i] +";";
      }
      $('#order').val(txt);
      $('#order').parent().submit();
    });
    


});

  function del_page(id){
    if(confirm('Êtes vous sure de supprimer cet élément?')){
      return window.location = "{{URL::base()}}/admin/menu/delete/"+id;
    }else{
      return false;
    }
  }
</script>
@endsection