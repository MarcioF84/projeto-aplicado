const pagesConfig = {
    'home': {
        title: 'Início',
        onLoad: () => { loadPage('home', 'components/home.php') }
    },
    'login': {
        title: 'Login',
        onLoad: () => { loadPage('login', 'form_login.php') }
    },
    // USUARIOS
    'usuario-add': {
        title: 'Novo Cadastro',
        onLoad: () => { loadPage('usuario-add', 'components/Usuario/form_add_user.php', 'components/Usuario/user.js') }
    },
    'usuario-alt': {
        title: 'Atualizar Cadastro',
        onLoad: () => { loadPage('usuario-alt', 'components/Usuario/form_alt_user.php', 'components/Usuario/user.js') }
    },
    'usuario-list': {
        title: 'Lista de Usuários',
        onLoad: () => {
            loadPage('usuario-list', 'components/Usuario/list_user.php');
            renderTable({
                entidade: 'Usuario',
                tabelaId: 'usuario-data-table',
                colunas: ['id_usuario', 'nome', 'email'],
                actions: [
                    { label: '✏️', title: 'Editar', onClick: loadData },
                    { label: '❌', title: 'Remover', onClick: 'Usuario.removeData' }
                ]
            });
        }
    },
    // TIPO DE USUÁRIOS
    'tipo-usuario-add': {
        title: 'Novo Cadastro',
        onLoad: () => { loadPage('tipo-usuario-add', 'components/TipoUsuario/form_add_type_user.php', 'components/TipoUsuario/type_user.js') }
    },
    'tipo-usuario-alt': {
        title: 'Atualizar Cadastro',
        onLoad: () => { loadPage('tipo-usuario-alt', 'components/TipoUsuario/form_alt_type_user.php', 'components/TipoUsuario/type_user.js') }
    },
    'tipo-usuario-list': {
        title: 'Lista Tipos de Usuários',
        onLoad: async () => {
            await loadPage('tipo-usuario-list', 'components/TipoUsuario/list_type_user.php', 'components/TipoUsuario/type_user.js');
            renderTable({
                entidade: 'TipoUsuario',
                tabelaId: 'tipo-usuario-data-table',
                colunas: ['id_tipo_usuario', 'descricao_tipo'],
                actions: [
                    { label: '✏️', title: 'Editar', onClick: loadData },
                    { label: '❌', title: 'Remover', onClick: 'TipoUsuario.removeData' }
                ]
            });
        }
    },

    // CARONA
    'carona-add': {
        title: 'Oferecer Carona',
        onLoad: () => { loadPage('carona-add', 'components/Carona/form_add_carona.php', 'components/Carona/carona.js') }
    },
    'carona-alt': {
        title: 'Atualizar Cadastro',
        onLoad: () => { loadPage('carona-alt', 'components/Carona/form_alt_carona.php', 'components/Carona/carona.js') }
    },
    'carona-list': {
        title: 'Minhas Caronas',
        onLoad: async () => {
            await loadPage('carona-list', 'components/Carona/list_carona.php', 'components/Carona/carona.js');
            renderTable({
                entidade: 'Carona',
                tabelaId: 'carona-data-table',
                colunas: ['id_carona', 'data_partida', 'hora_partida', 'endereco'],
                actions: [
                    { label: '✏️', title: 'Editar', onClick: loadData },
                    { label: '❌', title: 'Remover', onClick: 'Carona.removeData' }
                ]
            });
        }
    },
    'carona-search': {
        title: 'Buscar Caronas',
        onLoad: async () => {
            await loadPage('carona-search', 'components/Carona/search_carona.php', 'components/Carona/carona.js');
            renderTable({
                entidade: 'Carona',
                tabelaId: 'carona-search-data-table',
                colunas: ['id_carona', 'motorista', 'data_partida', 'hora_partida', 'endereco'],
                actions: [
                    { label: '✏️', title: 'Solicitar Carona', onClick: Carona.solicitarCarona }
                ]
            });
        }
    },

    // MARCAS
    'marca-add': {
        title: 'Novo Cadastro',
        onLoad: () => { loadPage('marca-add', 'components/Marca/form_add_marca.php', 'components/Marca/marca.js') }
    },
    'marca-alt': {
        title: 'Atualizar Cadastro',
        onLoad: () => { loadPage('marca-alt', 'components/Marca/form_alt_marca.php', 'components/Marca/marca.js') }
    },
    'marca-list': {
        title: 'Listar Marcas',
        onLoad: async () => {
            await loadPage('marca-list', 'components/Marca/list_marca.php', 'components/Marca/marca.js');
            renderTable({
                entidade: 'Marca',
                tabelaId: 'marca-data-table',
                colunas: ['id_marca', 'descricao_marca'],
                actions: [
                    { label: '✏️', title: 'Editar', onClick: loadData },
                    { label: '❌', title: 'Remover', onClick: 'Marca.removeData' }
                ]
            });
        }
    },
    // MODELOS
    'modelo-add': {
        title: 'Novo Cadastro',
        onLoad: () => { loadPage('modelo-add', 'components/Modelo/form_add_modelo.php', 'components/Modelo/modelo.js') }
    },
    'modelo-alt': {
        title: 'Atualizar Cadastro',
        onLoad: () => { loadPage('modelo-alt', 'components/Modelo/form_alt_modelo.php', 'components/Modelo/modelo.js') }
    },
    'modelo-list': {
        title: 'Listar Modelos',
        onLoad: async () => {
            await loadPage('modelo-list', 'components/Modelo/list_modelo.php', 'components/Modelo/modelo.js');
            renderTable({
                entidade: 'Modelo',
                tabelaId: 'modelo-data-table',
                colunas: ['id_modelo', 'descricao_modelo', 'descricao_marca'],
                actions: [
                    { label: '✏️', title: 'Editar', onClick: loadData },
                    { label: '❌', title: 'Remover', onClick: 'Modelo.removeData' }
                ]
            });
        }
    }
};

function toggleMenu() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('active');
}

function navigate(page) {

    const current = document.getElementById(page);
    const title = document.getElementById('page-title');

    document.querySelectorAll('.page').forEach(p => p.classList.add('hidden'));

    if (current) {
        current.classList.remove('hidden');
    }

    // if (window.innerWidth <= 768) toggleMenu();
    const config = pagesConfig[page] || { title: 'Início' };
    title.innerText = config.title;

    if (config.onLoad) {
        config.onLoad();
    }
}

async function loadPage(pageId, file, script = null) {

    const container = document.getElementById(pageId);

    if (!container.dataset.loaded) {
        const response = await fetch(file);
        const html = await response.text();

        container.innerHTML = html;

        // carrega js do componente
        if (script && !document.querySelector(`script[src="${script}"]`)) {

            await new Promise((resolve, reject) => {
                const s = document.createElement('script');

                s.src = script;
                s.onload = resolve;
                s.onerror = reject;

                document.body.appendChild(s);
            });
        }
        container.dataset.loaded = true;
    }
}

function showLoading(message = 'Carregando...') {
    const modal = document.getElementById('modal');
    const text = document.getElementById('modal-message');

    // Remove o botão "Fechar" caso ele tenha sido criado anteriormente
    const btnExistente = document.getElementById('modal-close');
    if (btnExistente) {
        btnExistente.remove();
    }

    text.innerText = message;
    modal.classList.remove('hidden');
}

function showModalMessage(message) {
    const modal = document.getElementById('modal');
    const text = document.getElementById('modal-message');

    text.innerText = message;

    // adiciona botão fechar dinamicamente
    if (!document.getElementById('modal-close')) {
        const btn = document.createElement('button');
        btn.id = 'modal-close';
        btn.innerText = 'Fechar';
        btn.style.marginTop = '15px';
        btn.style.padding = '8px 12px';
        btn.style.border = 'none';
        btn.style.background = '#2563eb';
        btn.style.color = '#fff';
        btn.style.borderRadius = '6px';
        btn.style.cursor = 'pointer';

        btn.onclick = hideLoading;

        modal.querySelector('.modal-content').appendChild(btn);
    }

    modal.classList.remove('hidden');
}

function hideLoading() {
    document.getElementById('modal').classList.add('hidden');
}

function waitForElement(id) {
    return new Promise(resolve => {
        const interval = setInterval(() => {
            const el = document.getElementById(id);
            if (el) {
                clearInterval(interval);
                resolve(el);
            }
        }, 50);
    });
}

function maskPhone(e) {
    let v = e.target.value.replace(/\D/g, '');
    if (v.length > 11) v = v.slice(0, 11);
    v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
    v = v.replace(/(\d{5})(\d)/, '$1-$2');
    e.target.value = v;
}

function maskCEP(e) {
    let v = e.target.value.replace(/\D/g, '');
    // limita a 8 dígitos
    if (v.length > 8) v = v.slice(0, 8);
    // adiciona hífen após os 5 primeiros
    v = v.replace(/^(\d{5})(\d)/, '$1-$2');
    e.target.value = v;
}

function maskDate(e) {
    let v = e.target.value.replace(/\D/g, '');
    if (v.length > 8) v = v.slice(0, 8);
    v = v.replace(/^(\d{2})(\d)/, '$1/$2');
    v = v.replace(/^(\d{2})\/(\d{2})(\d)/, '$1/$2/$3');
    e.target.value = v;
}

function maskTime(e) {
    let v = e.target.value.replace(/\D/g, '');
    if (v.length > 4) v = v.slice(0, 4);
    v = v.replace(/^(\d{2})(\d)/, '$1:$2');
    e.target.value = v;
}

function maskPlaca(e) {
    let v = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

    if (v.length > 7) v = v.slice(0, 7);

    // formato antigo ou Mercosul (não força hífen, só limpa)
    e.target.value = v;
}

function maskMoney(e) {
    let v = e.target.value.replace(/\D/g, '');
    if (v === '') {
        e.target.value = '';
        return;
    }
    // transforma em centavos
    v = (parseInt(v, 10) / 100).toFixed(2);
    // formata pt-BR
    v = v.replace('.', ',');
    v = v.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    e.target.value = 'R$ ' + v;
}



function renderTable({ entidade, tabelaId, colunas, actions = [] }) {

    const co = btoa(entidade + '_Control');
    const ac = btoa(entidade + '_Gerencia');

    showLoading('Carregando dados...');

    fetch(`/app/Core/Router.php?co=${co}&ac=${ac}`)
        .then(response => response.json())
        .then(res => {

            if (!res.success) {
                alert(res.error);
                return;
            }

            const dados = res.data.data;
            const tbody = document.getElementById(tabelaId);

            tbody.innerHTML = '';

            if (!dados || dados.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="${colunas.length + 1}" style="text-align:center">
                            Nenhum dado encontrado.
                        </td>
                    </tr>
                `;
                return;
            }

            dados.forEach(item => {
                const tr = document.createElement('tr');

                colunas.forEach(col => {
                    const td = document.createElement('td');
                    td.textContent = item[col] ?? '';
                    tr.appendChild(td);
                });

                const tdActions = document.createElement('td');
                const ul = document.createElement('ul');

                actions.forEach(action => {
                    const li = document.createElement('li');
                    const btn = document.createElement('button');
                    btn.title = action.title;
                    btn.textContent = action.label;

                    btn.addEventListener('click', () => {

                        const fn =
                            typeof action.onClick === 'string'
                                ? action.onClick
                                    .split('.')
                                    .reduce((obj, key) => obj?.[key], window)
                                : action.onClick;

                        if (typeof fn !== 'function') {
                            console.error('Função não encontrada:', action.onClick);
                            return;
                        }

                        fn(co, ac, item[colunas[0]], colunas, tabelaId);
                    });

                    li.appendChild(btn);
                    ul.appendChild(li);
                });
                tdActions.appendChild(ul);
                tr.appendChild(tdActions);
                tbody.appendChild(tr);

            });
        })
        .catch(err => console.error(err))
        .finally(() => hideLoading());
}

async function loadData(co, ac, id, colunas, tabelaId) {

    try {
        showLoading('Carregando...');

        const response = await fetch(`/app/Core/Router.php?co=${co}&ac=${ac}&${colunas[0]}=${id}`);
        const res = await response.json();

        if (!res.success) {
            showModalMessage(res.error || 'Erro ao buscar registro');
            return;
        }

        const dados = res.data.data[0];
        const objeto = tabelaId.replace('-data-table', '');
        const pg = objeto + '-alt';

        delete dados[colunas[0]];

        //navega para o form
        navigate(`${pg}`);

        //aguarda o form carregar (IMPORTANTE)
        await waitForElement('alt_' + Object.keys(dados)[0]);
        Object.keys(dados).forEach(chave => {
            const elemento = document.getElementById('alt_' + chave);
            if (elemento) {
                elemento.value = dados[chave] || '';
            }
        });

        // guarda o ID para update
        document.getElementById('form-' + `${pg}`).dataset.id = id;

    } catch (err) {
        showModalMessage('Erro inesperado');
    } finally {
        hideLoading();
    }
}

function meu_callback(conteudo) {

    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('rua').value = (conteudo.logradouro);
        document.getElementById('bairro').value = (conteudo.bairro);
        document.getElementById('cidade').value = (conteudo.localidade);
        document.getElementById('estado').value = (conteudo.uf);
    } else {
        showModalMessage("CEP não encontrado.");
    }
}

async function consultaPlaca(valor) {
    const placa = valor.toUpperCase().replace(/[^A-Z0-9]/g, '');
    const co = btoa('Frota_Control');
    const ac = btoa('Frota_Gerencia');

    try {
        const response = await fetch(`/app/Core/Router.php?co=${co}&ac=${ac}&placa=${placa}`);

        if (!response.ok) {
            throw new Error("Placa não encontrada");
        }

        const resp = await response.json();

        if (resp.success && resp.data.data.length === 0) {
            showModalMessage("Placa não encontrada");
            document.getElementById('placa').value = '';
        } else {
            document.getElementById('id_frota').value = resp.data.data[0].id_frota;
        }

    } catch (err) {
        console.log(err);
        showModalMessage("Erro ao consultar placa");
    }
}

function pesquisacep(valor) {
    var cep = valor.replace(/\D/g, '');

    if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if (validacep.test(cep)) {

            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } else {
            //cep é inválido.
            showModalMessage("Formato de CEP inválido.");
        }
    }
}

function trocarOrigem(v) {

    document.getElementById('id_endereco_origem').value = 0;
    document.getElementById('id_endereco_destino').value = 0;

    const label = document.getElementById("label-endereco");
    if (v == 2) {
        document.getElementById('id_endereco_destino').value = 3;
        label.textContent = "Preencha o Endereço de Origem";
    } else {
        document.getElementById('id_endereco_origem').value = 3;
        label.textContent = "Preencha o Endereço de Destino";
    }
}

