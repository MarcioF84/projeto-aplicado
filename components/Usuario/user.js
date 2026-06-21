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
                    el.dataset.id = res.data?.id_usuario;
                }
            }, 50);

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
            
            navigate('usuario-add-conclui');            

        } catch (err) {
            showModalMessage('Erro inesperado ao enviar arquivos');
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


