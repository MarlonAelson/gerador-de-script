<?php

namespace App\Uteis;

use Maatwebsite\Excel\Facades\Excel;

class LeitorDeArquivo {
    

    //variáveis utilizadas para os scripts SQL
    private $colunasDaTabela        ;
    private $dados                  ;
    private $fechamentoLinha        ;
    private $sqlMontado             = array();
    private $coluna                 ;
    private $comando                ;

    public function montarSql(
                                $tipo_arquivo, 
                                $diretorio_arquivos,
                                $diretorio_saida,
                                $tabela, 
                                $comando, 
                                $coluna
                            ){
        $this->dados   = Excel::toArray(new \StdClass, "{$diretorio_arquivos}\\{$tabela}.{$tipo_arquivo}");

        $this->tabela  = $tabela;
        $this->comando = $comando;
        $this->coluna  = $coluna;        

        //$qtdColunas = count($this->dados[0][0]);
        $qtdLinhas  = count($this->dados[0]);   
        
        /*for($i = 0; $i < $qtdColunas; $i++){
            //armazena concatenando para formar os campos da tabela
            $this->colunasDaTabela .= $this->dados[0][0][$i] . ", ";
        }*/

        //código abaixo substitui o código para qtdColunas comentado acima
        $this->colunasDaTabela = array_filter($this->dados[0][0]);

        if($comando === "INSERT"){
            $this->fechamentoLinha = "');";
            $this->coluna = "";
        }
        else{
            $this->fechamentoLinha = "') MATCHING( '{$this->coluna}' );";
        }

        for($i = 1; $i < $qtdLinhas; $i++){
            //armazena concatenando para formar os scripts sql
            $this->sqlMontado[$i] = $this->comando . " INTO "
                                  . $this->tabela  . " ( "
                                  . implode(",", $this->colunasDaTabela)
                                  . " ) VALUES ( '"
                                  . implode("','", $this->dados[0][$i])
                                  . $this->coluna
                                  . $this->fechamentoLinha;                                  
        }

        //remove a virgula do final
        $sqlTratado = str_replace(",  )", " )", $this->sqlMontado);

        //cria/abre um arquivo com o nome da tabela.sql em modo de escrita e leitura 
        $arquivo = fopen("{$diretorio_arquivos}\\{$this->tabela}.sql", 'w+');

        //escreve o comando dentro do arquivo que foi criado acima
        for($i = 1; $i <= count($sqlTratado); $i++){            
            fwrite($arquivo, $sqlTratado[$i].PHP_EOL);//PHP_EOL para quebrar a linha
        }

        //fecha o arquivo
        return fclose($arquivo);
    }
}