<form id="form-usuario-alt" onsubmit="Usuario.saveChangeData(event)">

    <div class="form-group">
        <label>Nome completo</label>
        <input type="text" id="alt_nome" required placeholder="Nome completo">
    </div>

    <div class="form-group">
        <label>Celular</label>        
        <input type="text" id="alt_telefone" required placeholder="(DDD) 99999-9999" maxlength="15" oninput="maskPhone(event)">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Sexo</label>
            <select id="alt_sexo" required>
                <option value="" selected>Sexo</option>
                <option value="F">Feminino</option>
                <option value="M">Masculino</option>
            </select>
        </div>
        <div class="form-group">
            <label>Característica</label>
            <select id="alt_id_tipo_usuario" required>
                <option value="" selected>Característica</option>
                <option value="1">Motorista</option>
                <option value="2">Passageiro</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Biografia</label>
        <textarea id="alt_bio" placeholder="Biografia"></textarea>
    </div>

    <button type="submit" class="btn-save">Salvar</button>
</form>