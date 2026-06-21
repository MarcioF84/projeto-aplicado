<form id="form-carona-add" onsubmit="Carona.saveNewData(event)">
    <div class="form-group">
        <label>Origem</label>
        <select id="origem_endereco" onchange="trocarOrigem(this.value)">
            <option value="" selected>Seleciona a Origem</option>
            <option value="1">Campus</option>
            <option value="2">Endereço</option>
        </select>
        <input type="hidden" id="id_endereco_origem" value="0">
        <input type="hidden" id="id_endereco_destino" value="0">
    </div>
    <label id="label-endereco">Preencha o Endereço de Destino</label>
    <br>
    <div class="form-group">
        <label>CEP</label>
        <input type="text" id="cep" onblur="pesquisacep(this.value)" required placeholder="CEP" oninput="maskCEP(event)">
    </div>
    <div class="form-group">
        <label>Rua</label>
        <input type="text" id="rua" required placeholder="Rua">
    </div>
    <div class="form-group">
        <label>Bairro</label>
        <input type="text" id="bairro" required placeholder="Bairro">
    </div>
    <div class="form-row">
        <div class="form-group">
            <label>Cidade</label>
            <input type="text" id="cidade" required placeholder="Cidade">
        </div>
        <div class="form-group">
            <label>Estado</label>
            <input type="text" id="estado" required placeholder="Estado">
        </div>
    </div>

    <br>
    <label>Data e Hora</label>
    <br>
    <div class="form-row">
        <div class="form-group">
            <label>Data</label>
            <input type="text" id="data_partida" required placeholder="dd/mm/aaaa" maxlength="10" oninput="maskDate(event)">
        </div>
        <div class="form-group">
            <label>Hora</label>
            <input type="text" id="hora_partida" required placeholder="hh:mm" maxlength="5" oninput="maskTime(event)">
        </div>
    </div>
    <br>
    <label>Informações sobre o Veículo</label>
    <br>
    <div class="form-row">

        <div class="form-group">
            <label>Placa</label>
            <input type="text" id="placa" required oninput="maskPlaca(event)" onblur="consultaPlaca(this.value)" placeholder="Placa">
            <input type="hidden" id="id_frota" value="">
        </div>
        <div class="form-group">
            <label>N° de Passageiros</label>
            <input type="text" id="qtde_assento" required placeholder="N° de Passageiros">
        </div>
        <div class="form-group">
            <label>Valor</label>
            <input type="text" id="valor_carona" placeholder="R$ 0,00" oninput="maskMoney(event)">
        </div>
    </div>
    <!-- 

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
    </div> -->

    <button type="submit" class="btn-save">Salvar</button>
</form>