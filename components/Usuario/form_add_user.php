<form id="form-usuario-add" onsubmit="Usuario.saveNewData(event)">

    <div class="form-group">
        <label>Nome completo</label>
        <input type="text" id="nome" required placeholder="Nome completo">
    </div>

    <div class="form-group">
        <label>E-mail</label>
        <input type="text" id="email" required placeholder="E-mail">
    </div>

    <div class="form-group">
        <label>Senha</label>
        <input type="password" id="senha" required placeholder="Senha">
    </div>

    <div class="form-group">
        <label>Celular</label>
        <input type="text" id="telefone" required placeholder="(DDD) 99999-9999" maxlength="15" oninput="maskPhone(event)">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label>Sexo</label>
            <select id="sexo" required>
                <option value="" selected>Sexo</option>
                <option value="F">Feminino</option>
                <option value="M">Masculino</option>
            </select>
        </div>
        <div class="form-group">
            <label>Característica</label>
            <select id="id_tipo_usuario" required>
                <option value="" selected>Característica</option>
                <option value="1">Motorista</option>
                <option value="2">Passageiro</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Biografia</label>
        <textarea id="bio" placeholder="Biografia"></textarea>
    </div>

    <button type="submit" class="btn-save">Salvar</button>
</form>