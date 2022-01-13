<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Uteis\ManipuladorDeArquivos;

class ArquivoController extends Controller
{
    private $atualizandoTabelasDaSessao = [];

    public function index()
    {
        session()->forget('tabelas');
        return view('scripts-sql.ler-diretorio');    
    }

    public function lerDiretorio(Request $request)
    {
        if(ManipuladorDeArquivos::diretorioExiste($request->diretorio_arquivos))
        {
            $tabelas = ManipuladorDeArquivos::retornaTabelas($request->diretorio_arquivos, $request->extensao_arquivo);
            
            if(!$tabelas)
            {
                return redirect()
                       ->back()
                       ->withErrors( "Diretório \"{$request->diretorio_arquivos}\" existe , mas não contém arquivos com a extensão \"{$request->extensao_arquivo}\" selecionada!" )
                       ->withInput();
            }
            else
            {
                $data['tabelas']   = $tabelas;
                $data['extensao_arquivo']  = $request->extensao_arquivo;
                $data['diretorio_arquivos'] = $request->diretorio_arquivos;
                $request->session()->put('tabelas', $tabelas);

                return view('scripts-sql.gerar-script',
                [
                    'data' => $data
                ]);
            }

        }
        else
        {
            return redirect()
                    ->back()
                    ->withErrors( "Diretorio \"" . $request->diretorio_arquivos . "\" inexistente!" )
                    ->withInput();
        }

        //return view('scripts-sql.gerar-script');    
    }

    public function gerarScript(Request $request)
    {

        $this->atualizandoTabelasDaSessao = $request->session()->get('tabelas');
        $data['tabelas']   = $this->atualizandoTabelasDaSessao;
        $data['extensao_arquivo']  = $request->extensao_arquivo;
        $data['diretorio_arquivos'] = $request->diretorio_arquivos;

        $script = ManipuladorDeArquivos::montaScriptSQL(    
                                $request->extensao_arquivo, 
                                $request->diretorio_arquivos,
                                $request->tabela, 
                                $request->comando, 
                                $request->coluna
                            );
        if($script){
            foreach($this->atualizandoTabelasDaSessao as $indice => $valor){
                if($valor == $request->tabela){
                    unset($this->atualizandoTabelasDaSessao[$indice]);
                }                
            }

            if(count($this->atualizandoTabelasDaSessao) > 0)
            {
                $request->session()->put('tabelas', $this->atualizandoTabelasDaSessao);
                $data['tabelas'] = $this->atualizandoTabelasDaSessao;

                return view('scripts-sql.gerar-script',
                [
                    'data' => $data
                ]);
            }
            else
            {
                return view('home')->with('mensagem', 'ACABOU Ô Ú Ô, ACABOU!');
            }            
        }
    }        
}
