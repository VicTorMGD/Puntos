<div class="modal fade" id="modalCliente" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formCliente">
        <input type="hidden" name="id" id="cliente_id">
        <div>
          <label>Número de documento</label>
          <input type="text" name="numero_documento" id="numero_documento" readonly>
        </div>
        <div>
          <label>Nombres</label>
          <input type="text" name="nombres" placeholder="Nombres" required>
        </div>
        <div> 
          <label>Apellidos</label>
          <input type="text" name="apellidos" placeholder="Apellidos" required>
        </div>
        <div>
          <label>Teléfono</label>
          <input type="text" name="telefono" placeholder="Teléfono">
        </div>
        <div>
          <label>Email</label>
          <input type="email" name="email" placeholder="Email">
        </div>
        <button type="submit">Guardar</button>
      </form>
    </div>
  </div>    
</div>
