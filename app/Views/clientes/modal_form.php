<style>
  .modal-cliente-custom .modal-content {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
  }

  .modal-cliente-custom .modal-header {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    border: none;
    padding: 25px 30px;
    color: #fff;
  }

  .modal-cliente-custom .modal-header h4 {
    font-weight: 600;
    font-size: 1.5rem;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  .modal-cliente-custom .modal-header .close {
    color: #fff;
    opacity: 0.9;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    font-size: 1.8rem;
  }

  .modal-cliente-custom .modal-header .close:hover {
    opacity: 1;
    transform: scale(1.1);
    transition: all 0.2s ease;
  }

  .modal-cliente-custom .modal-body {
    background: linear-gradient(to bottom, #E0F4F8 0%, #ffffff 100%);
    padding: 30px;
  }

  .form-group-custom {
    margin-bottom: 25px;
  }

  .form-group-custom label {
    display: block;
    font-weight: 600;
    color: #5a5a5a;
    margin-bottom: 8px;
    font-size: 0.95rem;
    letter-spacing: 0.3px;
  }

  .form-group-custom .input-wrapper {
    position: relative;
  }

  .form-group-custom .input-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #3A7A9A;
    font-size: 1rem;
    z-index: 1;
  }

  .form-group-custom input {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 2px solid #B8D4E0;
    border-radius: 12px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #fff;
    color: #333;
  }

  .form-group-custom input:focus {
    outline: none;
    border-color: #1B5E7C;
    box-shadow: 0 0 0 4px rgba(27, 94, 124, 0.1);
    background: #fff;
  }

  .form-group-custom input:read-only {
    background: linear-gradient(135deg, #E0F4F8 0%, #F0F9FB 100%);
    color: #3A7A9A;
    cursor: not-allowed;
    border-color: #B8D4E0;
  }

  .form-group-custom input::placeholder {
    color: #b8b8c4;
  }

  .modal-cliente-custom .modal-footer {
    background: linear-gradient(to top, #E0F4F8 0%, #ffffff 100%);
    border: none;
    padding: 20px 30px;
    border-radius: 0 0 20px 20px;
  }

  .btn-save-custom {
    background: linear-gradient(135deg, #1B5E7C 0%, #87CEEB 100%);
    border: none;
    color: #fff;
    padding: 12px 35px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(27, 94, 124, 0.4);
    transition: all 0.3s ease;
    text-transform: uppercase;
  }

  .btn-save-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(27, 94, 124, 0.5);
    color: #fff;
  }

  .btn-save-custom:active {
    transform: translateY(0);
  }

  .btn-cancel-custom {
    background: linear-gradient(135deg, #3A7A9A 0%, #87CEEB 100%);
    border: none;
    color: #fff;
    padding: 12px 35px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(58, 122, 154, 0.4);
    transition: all 0.3s ease;
    text-transform: uppercase;
    margin-right: 10px;
  }

  .btn-cancel-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(58, 122, 154, 0.5);
    color: #fff;
  }
</style>

<div class="modal fade modal-cliente-custom" id="modalCliente" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <i class="fas fa-user-edit mr-2"></i>
          <span id="modalTitle">Nuevo Cliente</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formCliente">
        <div class="modal-body">
          <input type="hidden" name="id" id="cliente_id">
          
          <div class="form-group-custom">
            <label for="numero_documento">
              <i class="fas fa-id-card mr-1"></i> Número de documento
            </label>
            <div class="input-wrapper">
              <i class="fas fa-id-card input-icon"></i>
              <input type="text" name="numero_documento" id="numero_documento" readonly>
            </div>
          </div>

          <div class="form-group-custom">
            <label for="nombres">
              <i class="fas fa-user mr-1"></i> Nombres
            </label>
            <div class="input-wrapper">
              <i class="fas fa-user input-icon"></i>
              <input type="text" name="nombres" id="nombres" placeholder="Ingrese los nombres" required>
            </div>
          </div>

          <div class="form-group-custom">
            <label for="apellidos">
              <i class="fas fa-user-tag mr-1"></i> Apellidos
            </label>
            <div class="input-wrapper">
              <i class="fas fa-user-tag input-icon"></i>
              <input type="text" name="apellidos" id="apellidos" placeholder="Ingrese los apellidos" required>
            </div>
          </div>

          <div class="form-group-custom">
            <label for="telefono">
              <i class="fas fa-phone mr-1"></i> Teléfono
            </label>
            <div class="input-wrapper">
              <i class="fas fa-phone input-icon"></i>
              <input type="text" name="telefono" id="telefono" placeholder="Ingrese el teléfono">
            </div>
          </div>

          <div class="form-group-custom">
            <label for="email">
              <i class="fas fa-envelope mr-1"></i> Email
            </label>
            <div class="input-wrapper">
              <i class="fas fa-envelope input-icon"></i>
              <input type="email" name="email" id="email" placeholder="Ingrese el correo electrónico">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-cancel-custom" data-dismiss="modal">
            <i class="fas fa-times mr-2"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-save-custom">
            <i class="fas fa-save mr-2"></i>Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
