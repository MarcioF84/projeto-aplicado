<form id="carona-detail-data" onsubmit="Carona.reservarCarona(event)">
    <input type="hidden" id="id_usuario" value="">
    <input type="hidden" id="id_frota" value="">
    <input type="hidden" id="data_reserva" value="">

    <!-- Linha do tempo (Rota) -->
    <div class="timeline">

        <div class="timeline-time">
            <span class="timeline-date" id="detalhe-carona-data"></span>
            <span class="timeline-hour" id="detalhe-carona-hora"></span>
        </div>

        <div class="timeline-track">
            <div class="timeline-line"></div>
            <div class="timeline-dot"></div>
        </div>

        <div class="timeline-details">
            <div class="location-origin" id="detalhe-carona-origem"></div>
            <div class="location-destination" id="detalhe-carona-destino"></div>
        </div>
    </div>

    <!-- Dados da motorista e veículo -->
    <div class="driver-profile">
        <img class="driver-avatar" id="detalhe-carona-foto" src="" alt="Foto do Motorista">
        <div class="driver-info">
            <h3 id="detalhe-carona-motorista"></h3>
            <p id="detalhe-carona-veiculo"></p>
        </div>
    </div>
    <br>
    <br>
    <br>
    <!-- Botão de ação -->

    <div class="form-row">
        <button class="btn-save" onclick="navigate('carona-search')">Voltar</button>
        <button type="submit" class="btn-save">Confirmar</button>
    </div>
</form>