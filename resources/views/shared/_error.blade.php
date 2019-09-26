@if (count($errors) > 0)
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <ul class="mt-2 mb-2">
    @foreach ($errors->all() as $error)
    <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
