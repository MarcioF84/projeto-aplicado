window.Modelo = {

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

        });

        return errors;
    },

    async saveNewData(event) {
        event.preventDefault();

        const errors = this.validate([
            { id: 'descricao_modelo', label: 'Descrição', required: true, max: 255 }
        ]);

        if (errors.length > 0) {
            showModalMessage(errors.join('\n'));
            return;
        }

        try {
            showLoading('Salvando...');

            const payload = {
                co: btoa('Modelo_Control'),
                ac: btoa('Modelo_Add'),
                descricao_modelo: document.getElementById('descricao_modelo').value
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

    async saveChangeData(event) {
        event.preventDefault();
        const form = event.target;

        const errors = this.validate([
            { id: 'alt_descricao_modelo', label: 'Descrição', required: true, max: 255 }
        ]);

        if (errors.length > 0) {
            showModalMessage(errors.join('\n'));
            return;
        }

        try {
            showLoading('Salvando...');

            const payload = {
                co: btoa('Modelo_Control'),
                ac: btoa('Modelo_Alt'),
                id_modelo: form.dataset.id,
                descricao_modelo: document.getElementById('alt_descricao_modelo').value
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
                ac: btoa('Modelo_Desativar'),
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
                entidade: 'Modelo',
                tabelaId: 'modelo-data-table',
                colunas: ['id_modelo', 'descricao_modelo'],
                actions: [
                    { label: '✏️', title: 'Editar', onClick: loadData },
                    { label: '❌', title: 'Remover', onClick: 'Modelo.removeData' }
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


