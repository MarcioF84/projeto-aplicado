window.Usuario = {

    validate(fields) {
        const errors = [];

        fields.forEach(f => {
            const el = document.getElementById(f.id);
            const value = el?.value?.trim();

            // obrigatório
            if (f.required && !value) {
                errors.push(`${f.label} é obrigatório`);
            }

            // max length
            if (f.max && value.length > f.max) {
                errors.push(`${f.label} deve ter no máximo ${f.max} caracteres`);
            }

            // min length
            if (f.min && value.length < f.min) {
                errors.push(`${f.label} deve ter no mínimo ${f.min} caracteres`);
            }

            // email simples
            if (f.type === 'email') {
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (value && !regex.test(value)) {
                    errors.push(`${f.label} inválido`);
                }
            }
        });

        return errors;
    },

    async loadModelos() {
        try {

            const select = document.getElementById('id_modelo');
            const co = btoa('Modelo_Control');
            const ac = btoa('Modelo_Gerencia');

            if (!select) return;

            // limpa opções
            select.innerHTML = '<option value="">Carregando...</option>';

            const res = await fetch(`/app/Core/Router.php?co=${co}&ac=${ac}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const data = await res.json();

            select.innerHTML = '<option value="">Selecione</option>';

            if (!data.success || !data.data.data?.length) {
                select.innerHTML += '<option value="">Nenhum modelo encontrado</option>';
                return;
            }

            data.data.data.forEach(modelo => {
                const option = document.createElement('option');
                option.value = modelo.id_modelo;
                option.textContent = modelo.marca.descricao_marca + ' ' + modelo.descricao_modelo;

                select.appendChild(option);
            });

        } catch (error) {
            showModalMessage('Erro ao carregar modelos:', error);
        }
    },

    async saveNewData(event) {
        event.preventDefault();

        const errors = this.validate([
            { id: 'nome', label: 'Nome', required: true, max: 50 },
            { id: 'email', label: 'E-mail', required: true, type: 'email', max: 150 },
            { id: 'senha', label: 'Senha', required: true, min: 6 },
            { id: 'telefone', label: 'Telefone', max: 20 },
            { id: 'sexo', label: 'Sexo', required: true },
            { id: 'id_tipo_usuario', label: 'Tipo de usuário', required: true },
            { id: 'bio', label: 'Biografia', max: 500 }
        ]);

        if (errors.length > 0) {
            showModalMessage(errors.join('\n'));
            return;
        }

        try {
            showLoading('Salvando...');
            const typeUser = document.getElementById('id_tipo_usuario').value;

            const payload = {
                co: btoa('Usuario_Control'),
                ac: btoa('Usuario_Add'),

                nome: document.getElementById('nome').value,
                email: document.getElementById('email').value,
                senha: document.getElementById('senha').value,
                telefone: document.getElementById('telefone').value,
                sexo: document.getElementById('sexo').value,
                id_tipo_usuario: document.getElementById('id_tipo_usuario').value,
                bio: document.getElementById('bio').value
            };

            // Requisição
            const response = await fetch('/app/Core/Router.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const res = await response.json();

            if (!res.success) {
                showModalMessage(res.error || 'Erro ao salvar');
                return;
            }

            // Sucesso        
            showModalMessage(res.data?.message || 'Salvo com sucesso!');

            // guarda o ID para update
            navigate('usuario-doc-add');

            setTimeout(() => {
                const el = document.getElementById('form-usuario-doc-add');
                if (el) {
                    if (typeUser == 2) {
                        document.getElementById('form-cnh').classList.add('hidden');
                        document.getElementById('form-documento').classList.add('hidden');
                    } else {
                        document.getElementById('form-cnh').classList.remove('hidden');
                        document.getElementById('form-documento').classList.remove('hidden');
                    }
                    el.dataset.id = res.data?.id_usuario;
                    document.getElementById('id_tipo_usuario').value = typeUser;
                }
            }, 100);

            // Limpa formulário
            event.target.reset();

        } catch (err) {
            showModalMessage('Erro inesperado');
        } finally {
            setTimeout(() => {
                hideLoading();
            }, 2000);
        }
    },

    async saveDocsData(event) {
        event.preventDefault();

        try {
            showLoading('Enviando documentos...');

            const form = document.getElementById('form-usuario-doc-add');
            const id_usuario = form?.dataset?.id;

            const id_tipo_usuario = document.getElementById('id_tipo_usuario').value;

            if (!id_usuario) {
                showModalMessage('Usuário não identificado');
                return;
            }

            const arquivos = [
                {
                    file: document.getElementById('cnh').files[0],
                    id_tipo_anexo: 1
                },
                {
                    file: document.getElementById('documento').files[0],
                    id_tipo_anexo: 2
                },
                {
                    file: document.getElementById('foto').files[0],
                    id_tipo_anexo: 3
                }
            ];

            for (const item of arquivos) {

                if (!item.file) continue;

                const formData = new FormData();

                formData.append('co', btoa('Anexo_Control'));
                formData.append('ac', btoa('Anexo_Add'));
                formData.append('id_usuario', id_usuario);
                formData.append('id_tipo_anexo', item.id_tipo_anexo);
                formData.append('arquivo', item.file);

                const response = await fetch('/app/Core/Router.php', {
                    method: 'POST',
                    body: formData
                });

                const res = await response.json();

                if (!res.success) {
                    showModalMessage(res.error || 'Erro ao enviar arquivo');
                    return;
                }
            }

            showModalMessage('Documentos enviados com sucesso!');

            if (id_tipo_usuario == 2) {
                navigate('usuario-add-conclui');
            } else {
                navigate('usuario-frota-add');

                setTimeout(() => {
                    const el = document.getElementById('form-usuario-frota-add');
                    if (el) {
                        el.dataset.id = id_usuario;
                    }
                }, 100);
            }

        } catch (err) {
            showModalMessage('Erro inesperado ao enviar arquivos');
        } finally {
            setTimeout(() => {
                hideLoading();
            }, 2000);
        }
    },

    async saveFrotaData(event) {
        event.preventDefault();

        const form = document.getElementById('form-usuario-frota-add');
        const id_usuario = form?.dataset?.id;

        const errors = this.validate([
            { id: 'placa', label: 'Placa', required: true, max: 7 },
            { id: 'cor', label: 'Cor', required: true, max: 100 },
            { id: 'id_modelo', label: 'Modelo', required: true }
        ]);

        if (errors.length > 0) {
            showModalMessage(errors.join('\n'));
            return;
        }

        try {
            showLoading('Salvando...');

            const payload = {
                co: btoa('Frota_Control'),
                ac: btoa('Frota_Add'),

                placa: document.getElementById('placa').value,
                cor: document.getElementById('cor').value,
                id_modelo: document.getElementById('id_modelo').value,
                id_usuario: id_usuario
            };

            // Requisição
            const response = await fetch('/app/Core/Router.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const res = await response.json();

            if (!res.success) {
                showModalMessage(res.error || 'Erro ao salvar');
                return;
            }

            // Sucesso        
            showModalMessage(res.data?.message || 'Salvo com sucesso!');

            // guarda o ID para update
            navigate('usuario-add-conclui');

            // Limpa formulário
            event.target.reset();

        } catch (err) {
            showModalMessage('Erro inesperado');
        } finally {
            setTimeout(() => {
                hideLoading();
            }, 2000);
        }
    },


    async saveChangeData(event) {
        event.preventDefault();
        const form = event.target;

        const errors = this.validate([
            { id: 'alt_nome', label: 'Nome', required: true, max: 50 },
            { id: 'alt_telefone', label: 'Telefone', max: 20 },
            { id: 'alt_sexo', label: 'Sexo', required: true },
            { id: 'alt_id_tipo_usuario', label: 'Tipo de usuário', required: true },
            { id: 'alt_bio', label: 'Biografia', max: 500 }
        ]);

        if (errors.length > 0) {
            showModalMessage(errors.join('\n'));
            return;
        }

        try {
            showLoading('Salvando...');

            const payload = {
                co: btoa('Usuario_Control'),
                ac: btoa('Usuario_Alt'),
                id_usuario: form.dataset.id,
                nome: document.getElementById('alt_nome').value,
                telefone: document.getElementById('alt_telefone').value,
                sexo: document.getElementById('alt_sexo').value,
                id_tipo_usuario: document.getElementById('alt_id_tipo_usuario').value,
                bio: document.getElementById('alt_bio').value
            };

            // Requisição
            const response = await fetch('/app/Core/Router.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const res = await response.json();

            if (!res.success) {
                showModalMessage(res.error || 'Erro ao salvar');
                return;
            }

            // Sucesso
            showModalMessage(res.data?.message || 'Salvo com sucesso!');

            // Limpa formulário
            event.target.reset();

        } catch (err) {
            showModalMessage('Erro inesperado');
        } finally {
            setTimeout(() => {
                hideLoading();
            }, 2000);
        }
    },

    async removeData(co, ac, id, colunas, tabelaId) {

        try {
            showLoading('Removendo aguarde...');

            const payload = {
                co: co,
                ac: btoa('Usuario_Desativar'),
                [colunas[0]]: id
            };

            // Requisição
            const response = await fetch('/app/Core/Router.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const res = await response.json();

            if (!res.success) {
                showModalMessage(res.error || 'Erro ao salvar');
                return;
            }

            // Sucesso
            showModalMessage(res.data?.message || 'Salvo com sucesso!');

            renderTable({
                entidade: 'Usuario',
                tabelaId: 'usuario-data-table',
                colunas: ['id_usuario', 'nome', 'email'],
                actions: [
                    { label: '✏️', title: 'Editar', onClick: loadData },
                    { label: '❌', title: 'Remover', onClick: 'Usuario.removeData' }
                ]
            });

        } catch (err) {
            showModalMessage('Erro inesperado');
        } finally {
            setTimeout(() => {
                hideLoading();
            }, 2000);
        }
    }
}


