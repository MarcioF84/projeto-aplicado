<h3 id="page-title">Novo Cadastro</h3>
<br>
<form id="form-usuario-doc-add" onsubmit="Usuario.saveDocsData(event)">

    <!-- CNH -->
    <div class="form-group">
        <label>Anexe sua CNH</label>
        <small>Caso pretenda oferecer caronas, anexe sua Carteira Nacional de Habilitação.</small>

        <label class="upload-box">
            <input type="file" id="cnh" name="cnh" accept=".pdf,.png,.jpg,.jpeg">
            <div class="upload-content">
                <i data-lucide="upload"></i>
            </div>
        </label>

        <small>Formatos aceitos: PDF, imagens (JPG/PNG)</small>
    </div>

    <!-- Comprovante -->
    <div class="form-group">
        <label>Anexe seu comprovante de vínculo</label>
        <small>Usaremos sua identidade para fins de segurança e verificação.</small>

        <label class="upload-box">
            <input type="file" id="documento" name="documento" accept=".pdf,.png,.jpg,.jpeg">
            <div class="upload-content">
                <i data-lucide="upload"></i>
            </div>
        </label>

        <small>Formatos aceitos: PDF, imagens (JPG/PNG)</small>
    </div>

    <!-- Foto -->
    <div class="form-group">
        <label>Tire uma foto sua</label>
        <small>Usaremos sua foto para verificação de identidade.</small>

        <label class="upload-box">
            <input type="file" id="foto" name="foto" accept=".png,.jpg,.jpeg">
            <div class="upload-content">
                <i data-lucide="camera"></i>
            </div>
        </label>

        <small>Formatos aceitos: imagens (JPG/PNG)</small>
    </div>

    <button type="submit" class="btn-save">Salvar</button>
</form>