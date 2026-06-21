<h3>Faça seu login:</h3>

<form onsubmit="saveData(event)">

    <div class="form-group">
        <label>Usuário</label>
        <input type="text" id="user" required placeholder="Entre com o usuário">
    </div>
    <div class="form-group">
        <label>Senha</label>
        <input type="password" id="pass" required placeholder="Entre com a senha">
    </div>

    <button type="submit" class="btn-save">Entrar</button>

</form>
<i data-lucide="table"></i>

<button class="btn-cadastro" onclick="navigate('usuario-add')">Não tem Cadastro?</button>

