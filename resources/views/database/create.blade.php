<form action="#" method="POST">
    @csrf
    <div class="form-group">
        <label for="nome_tabela">Nome da Tabela</label>
        <input type="text" class="form-control" id="nome_tabela" name="nome_tabela" required>
    </div>

    <h5 class="fw-bold mt-3" >Colunas</h5>
    <div id="colunas">
        <div class="row mb-2">
            <div class="col-8">
                <input type="text" class="form-control" name="colunas[0][nome]" placeholder="Nome da coluna" required>
            </div>
            <div class="col-3">
                <select class="form-control" name="colunas[0][tipo]" required>
                    <option value="">Selecione o tipo</option>
                    <option value="string" selected>Texto</option>
                </select>
            </div>
            <div class="col">
                <button type="button" class="btn text-danger" onclick="removeColumn(this)"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-secondary" onclick="addColumn()">Adicionar Coluna</button>
    <button type="submit" class="btn btn-primary">Criar Tabela</button>
</form>

<script>
    let columnIndex = 1;

    function addColumn() {
        const columnContainer = document.getElementById('colunas');
        const newColumn = `
            <div class="row mb-2">
                <div class="col-8">
                    <input type="text" class="form-control" name="colunas[${columnIndex}][nome]" placeholder="Nome da coluna" required>
                </div>
                <div class="col-3">
                    <select class="form-control" name="colunas[${columnIndex}][tipo]" required>
                        <option value="">Selecione o tipo</option>
                        <option value="string" selected>Texto</option>
                    </select>
                </div>
                <div class="col">
                    <button type="button" class="btn text-danger" onclick="removeColumn(this)"><i class="fas fa-trash"></i></button>
                </div>
            </div>`;
        columnContainer.insertAdjacentHTML('beforeend', newColumn);
        columnIndex++;
    }

    function removeColumn(button) {
        button.closest('.row').remove();
    }
</script>
