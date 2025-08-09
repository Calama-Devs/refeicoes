<h1 class="mt-4 mb-4">Alunos Cadastrados</h1>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success mt-3">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger mt-3">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<button type="button" class="btn btn-primary btn-fw mt-3" data-bs-toggle="modal" data-bs-target="#alunoModal">
    Novo Aluno
</button>

<div class="table-container mt-4">
    <?php if (isset($alunos) && !empty($alunos)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Turma ID</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?= esc($aluno['matricula']) ?></td>
                        <td><?= esc($aluno['nome']) ?></td>
                        <td><?= esc($aluno['turma_id']) ?></td>
                        <td><?= $aluno['status'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editarAlunoModal"
                                data-matricula="<?= esc($aluno['matricula']) ?>">
                                Editar
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletarModal"
                                data-matricula="<?= esc($aluno['matricula']) ?>"
                                data-nome="<?= esc($aluno['nome']) ?>">
                                Deletar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="mt-3">
            <?= $pager->links() ?>
        </div>

    <?php else: ?>
        <p>Nenhum aluno encontrado no banco de dados.</p>
    <?php endif; ?>
</div>

<?= $this->include('components/alunos/modal_cad_aluno', ['turmas' => $turmas]) ?>
<?= $this->include('components/alunos/modal_del_aluno') ?>
<?= $this->include('components/alunos/modal_edit_aluno', ['turmas' => $turmas]) ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deletarModal = document.getElementById('deletarModal');
        deletarModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var matricula = button.getAttribute('data-matricula');
            var nome = button.getAttribute('data-nome');
            var modalTitle = deletarModal.querySelector('.modal-title');
            var modalBody = deletarModal.querySelector('.modal-body');
            var modalForm = deletarModal.querySelector('form');
            modalTitle.textContent = 'Deletar Aluno';
            modalBody.textContent = 'Tem certeza de que deseja deletar o aluno ' + nome + ' (Matrícula: ' + matricula + ')?';
            modalForm.action = '<?= base_url('sys/alunos/deletar') ?>/' + matricula;
        });

        var editarAlunoModal = document.getElementById('editarAlunoModal');
        editarAlunoModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var matricula = button.getAttribute('data-matricula');
            
            fetch('<?= base_url('sys/alunos/editar') ?>/' + matricula)
                .then(response => response.json())
                .then(aluno => {
                    if (aluno.error) {
                        alert(aluno.error);
                        return;
                    }

                    document.getElementById('edit_matricula').value = aluno.matricula;
                    document.getElementById('edit_nome').value = aluno.nome;
                    document.getElementById('edit_turma_id').value = aluno.turma_id;
                    document.getElementById('edit_status').value = (aluno.status == 1) ? 'ativo' : 'inativo';
                    
                    var form = document.getElementById('formEditarAluno');
                    form.action = '<?= base_url('sys/alunos/atualizar') ?>/' + aluno.matricula;
                })
                .catch(error => console.error('Erro ao buscar dados do aluno:', error));
        });
    });
</script>