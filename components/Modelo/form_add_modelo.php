<form id="form-modelo-add" onsubmit="Modelo.saveNewData(event)">

    <div class="form-group">
        <label>Marca</label>
        <select id="id_tipo_usuario" required>
            <option value="" selected>Selecione</option>
            <option value="1">Motorista</option>
            <option value="2">Passageiro</option>
        </select>
    </div>

    <div class="form-group">
        <label>Modelo</label>
        <input type="text" id="descricao_modelo" required placeholder="Descrição">
    </div>

    <button type="submit" class="btn-save">Salvar</button>
</form>