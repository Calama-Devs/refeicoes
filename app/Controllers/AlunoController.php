<?php

namespace App\Controllers;

use App\Models\AlunoModel;
use App\Models\TurmaModel;

class AlunoController extends BaseController
{
    public function index()
    {
        $alunoModel = new AlunoModel();
        $turmaModel = new TurmaModel();
        
        $alunos = $alunoModel->paginate(10);
        $pager = $alunoModel->pager;

        $dataAlunos = [
            'alunos' => $alunos,
            'pager' => $pager,
            'turmas' => $turmaModel->select('turmas.*, cursos.nome as curso_nome')->join('cursos', 'cursos.id = turmas.curso_id')->findAll(),
        ];
        
        $mainContent = view('sys/aluno', $dataAlunos);

        $data = [
            'content' => $mainContent,
        ];
        
        return view('dashboard', $data);
    }
    
    public function criar()
    {
        $alunoModel = new AlunoModel();
        $postData = $this->request->getPost();
        
        // CORREÇÃO: A validação e a inserção agora são mais simples. O modelo lida com a conversão.
        if (!$alunoModel->insert($postData)) {
            return redirect()->back()->withInput()->with('errors', $alunoModel->errors());
        } else {
            return redirect()->to('sys/alunos')->with('success', 'Aluno cadastrado com sucesso!');
        }
    }
    
    public function delete($id)
    {
        $alunoModel = new AlunoModel();
        
        if ($alunoModel->delete($id)) {
            return redirect()->to('sys/alunos')->with('success', 'Aluno deletado com sucesso!');
        } else {
            return redirect()->to('sys/alunos')->with('errors', ['Erro ao deletar o aluno.']);
        }
    }
    
    public function edit($id)
    {
        $alunoModel = new AlunoModel();
        $aluno = $alunoModel->find($id);

        if ($aluno === null) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Aluno não encontrado.']);
        }

        return $this->response->setJSON($aluno);
    }

    public function update($id)
    {
        $alunoModel = new AlunoModel();
        $postData = $this->request->getPost();
        
        unset($postData['matricula']);
        unset($postData['_method']);

        if (!$alunoModel->update($id, $postData)) {
            return redirect()->back()->withInput()->with('errors', $alunoModel->errors());
        } else {
            return redirect()->to('sys/alunos')->with('success', 'Aluno atualizado com sucesso!');
        }
    }
}