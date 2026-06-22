window.Carona = {

    validate(fields) {
        const errors = [];

        fields.forEach(f => {
            const el = document.getElementById(f.id);
            const value = el?.value?.trim();

            // obrigatório
            if (f.required && !value) {
                errors.push(`${f.label} é obrigatório`);
            }

            // // max length
            // if (f.max && value.length > f.max) {
            //     errors.push(`${f.label} deve ter no máximo ${f.max} caracteres`);
            // }

            // // min length
            // if (f.min && value.length < f.min) {
            //     errors.push(`${f.label} deve ter no mínimo ${f.min} caracteres`);
            // }

        });

        return errors;
    },

    async saveNewData(event) {
        event.preventDefault();

        const errors = this.validate([
            { id: 'cep', label: 'CEP', required: true, max: 9 },
            { id: 'rua', label: 'RUA', required: true, max: 255 },
            { id: 'bairro', label: 'Bairro', required: true, max: 150 },
            { id: 'estado', label: 'Estado', required: true, max: 2 },
            { id: 'data_partida', label: 'data', required: true, max: 10 },
            { id: 'hora_partida', label: 'hora', required: true, max: 2 },
            { id: 'placa', label: 'placa', required: true, max: 10 },
            { id: 'qtde_assento', label: 'N° de Passaeiros', required: true, max: 5 }
        ]);

        if (errors.length > 0) {
            showModalMessage(errors.join('\n'));
            return;
        }

        try {
            showLoading('Salvando...');

            const payload = {
                co: btoa('Carona_Control'),
                ac: btoa('Carona_Add'),

                id_frota: document.getElementById('id_frota').value,
                id_endereco_origem: document.getElementById('id_endereco_origem').value,
                id_endereco_destino: document.getElementById('id_endereco_destino').value,
                data_partida: document.getElementById('data_partida').value,
                hora_partida: document.getElementById('hora_partida').value,
                valor_carona: document.getElementById('valor_carona').value,
                qtde_assento: document.getElementById('qtde_assento').value,
                cep: document.getElementById('cep').value,
                rua: document.getElementById('rua').value,
                bairro: document.getElementById('bairro').value,
                cidade: document.getElementById('cidade').value,
                estado: document.getElementById('estado').value

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
            { id: 'alt_descricao_marca', label: 'Descrição', required: true, max: 255 }
        ]);

        if (errors.length > 0) {
            showModalMessage(errors.join('\n'));
            return;
        }

        try {
            showLoading('Salvando...');

            const payload = {
                co: btoa('Marca_Control'),
                ac: btoa('Marca_Alt'),
                id_marca: form.dataset.id,
                descricao_marca: document.getElementById('alt_descricao_marca').value
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

    async reservarCarona(event) {
        event.preventDefault();

        try {
            showLoading('Salvando...');

            const payload = {
                co: btoa('Reserva_Control'),
                ac: btoa('Reserva_Add'),
                id_carona: document.getElementById('id_frota').value,
                id_usuario: document.getElementById('id_usuario').value,
                data_reserva: document.getElementById('data_reserva').value,
                qtde_assentos: 1
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
            showModalMessage(res.data?.message || 'Carona solicitada com sucesso!');

            navigate('carona-reservada');

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
                ac: btoa('Marca_Desativar'),
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
                entidade: 'Marca',
                tabelaId: 'tipo-usuario-data-table',
                colunas: ['id_tipo_usuario', 'descricao_marca'],
                actions: [
                    { label: '✏️', title: 'Editar', onClick: loadData },
                    { label: '❌', title: 'Remover', onClick: 'Marca.removeData' }
                ]
            });

        } catch (err) {
            showModalMessage('Erro inesperado');
        } finally {
            setTimeout(() => {
                hideLoading();
            }, 2000);
        }
    },

    async solicitarCarona(){
        navigate('carona-detail');
    }
}


