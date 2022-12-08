
@if ($preasignacionOrden == null)
<p>No tienes ordenes ordenes preasignadas</p>
@else
{{ $preasignacionOrden->getFecha() }}
<form method="POST" action="{{ route('surtidor.aceptarOrden') }}">
    @csrf
    <input type="hidden" name="orden_id" value="{{ $preasignacionOrden->getOrdenId() }}">
    <button type="submit">Aceptar</button>
</form>
@endif
