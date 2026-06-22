<h3 id="page-title">Cadastro de Veículo</h3>
<br>
<form id="form-usuario-frota-add" onsubmit="Usuario.saveFrotaData(event)">

    <div class="form-group">
        <label>Placa</label>
        <input type="text" id="placa" required placeholder="Placa">
    </div>

    <div class="form-group">
        <label>Cor</label>
        <input type="text" id="cor" required placeholder="Cor do Veículo">
    </div>

    <div class="form-group">
        <label>Modelo</label>
        <select id="id_modelo" required>
            <option value="" selected>Selecione</option>            
        </select>
    </div>

    <button type="submit" class="btn-save">Salvar</button>
</form>