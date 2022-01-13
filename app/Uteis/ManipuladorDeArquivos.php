<?php

namespace App\Uteis;

use Maatwebsite\Excel\Facades\Excel;

class ManipuladorDeArquivos 
{
    private static $arquivosDoDiretorio = [];
    private static $comando                 ;
    private static $fechamentoLinha         ;
    private static $tabela;
    private static $colunasDaTabela         ;
    private static $dados                   ;
    private static $sqlMontado = array();
    

    ////tem que vir no formato "c:\ar\teste.xlsx" para carregar os dados e retorna em forma de array
    public static function carregarDadosDoArquivoEmArray($arquivo)
    {
        return Excel::toArray(new \StdClass, $arquivo);        
    }

    //conta a quantidade de linhas do arquivo
    public static function quantidadeDeLinhas($array)
    {
        $qtdLinhas  = count($array[0]);
        return $qtdLinhas;
    }

    //conta a quantidade de colunas do arquivo
    public static function colunasDaTabela($array)
    {
        //esse trecho de código substituiu o que está comentado mais abaixo
        $colunas  = array_filter($array[0][0]);

        return $colunas;
        /*for($i = 0; $i < $qtdColunas; $i++){ primeira tentativa
            //armazena concatenando para formar os campos da tabela
            $this->colunasDaTabela .= $this->dados[0][0][$i] . ", ";
        }*/
    }
    
    /*
    **cria/abre um arquivo em modo de escrita e leitura no local, nome e extensão que está vindo no parâmetro ($detalhes)
    **insere o conteúdo que está vindo no segundo parâmetro ($conteudo) 
    */
    public static function criarArquivo($detalhes, $conteudo)
    {
        //cria/abre um arquivo em modo de escrita e leitura
        $arquivo = fopen($detalhes, 'w+');

        //conta e escreve o conteudo dentro do arquivo que foi criado acima
        for($i = 1; $i <= count($conteudo); $i++){            
            fwrite($arquivo, $conteudo[$i].PHP_EOL);//PHP_EOL para quebrar a linha
        }

        //fecha o arquivo
        return fclose($arquivo);
    }

    //retorna falso caso o diretório não exista;
    public static function diretorioExiste($diretorio){
        return is_dir($diretorio);
    }

    public static function retornaTabelas($diretorio, $extensaoDoArquivo)
    {
        //o diretório existindo, ele cria um "id" para ser utilizado no método abaixo
        $diretorioId = opendir($diretorio);
        /* enquanto existir arquivo no diretório que foi passado o id
        ** vai salvar num array conforme está descrito dentro do método
        */
        while ($arquivo = readdir($diretorioId))
        { 
            // armazena o tamanho do arquivo
            $tamanhoArquivoComExtensao = strlen($arquivo);
            /* verifica se o tipo do arquivo que vem na requisição é igual a extensão (extraída com ajuda dos metódos substr e strlen) dos arquivos dentro da pasta 
            ** se for igual ele vai armazenando dentro de um array os nomes dos arquivos para serem utilizado como nome das tabelas e gerar o script de cada
            */

            if($extensaoDoArquivo == strtoupper(substr($arquivo, -strlen($extensaoDoArquivo))))
            {
                self::$arquivosDoDiretorio[] = substr($arquivo, 0, (strlen($arquivo) - (strlen($extensaoDoArquivo)+1)));
            }
        }

        return self::$arquivosDoDiretorio;
    }

    public static function montaScriptSQL(
        $extensao_arquivo, 
        $diretorio_arquivos,
        $tabela, 
        $comando, 
        $coluna)
    {
        self::$comando = $comando;
        //self::$coluna  = $coluna;
        self::$tabela  = $tabela;

        if($comando === "INSERT")
        {
            self::$fechamentoLinha = "');";
        }
        else
        {
            self::$fechamentoLinha = "') MATCHING ($coluna);";
        }

        self::$dados = self::carregarDadosDoArquivoEmArray("{$diretorio_arquivos}\\{$tabela}.{$extensao_arquivo}");
        $qtdLinhas   =  self::quantidadeDeLinhas(self::$dados);
        self::$colunasDaTabela   =  self::colunasDaTabela(self::$dados);
        //self::$colunasDaTabela = array_filter(self::$dados[0][0]);

        for($i = 1; $i < $qtdLinhas; $i++)
        {
            //armazena concatenando para formar os scripts sql
            self::$sqlMontado[$i] = self::$comando . " INTO "
                                  . self::$tabela  . " ("
                                  . implode(",", self::$colunasDaTabela)
                                  . ") VALUES ('"
                                  . implode("','", self::$dados[0][$i])
                                  //. self::$coluna
                                  . self::$fechamentoLinha;                                  
        }

        //remove a virgula do final
        $sqlTratado = str_replace(", )", ")", self::$sqlMontado);

        //cria/abre um arquivo com o nome da tabela.sql em modo de escrita e leitura 
        $arquivo = fopen("{$diretorio_arquivos}\\ ". self::$tabela . ".sql", 'w+');

        //escreve o comando dentro do arquivo que foi criado acima
        for($i = 1; $i <= count($sqlTratado); $i++){            
            fwrite($arquivo, $sqlTratado[$i].PHP_EOL);//PHP_EOL para quebrar a linha
        }

        //fecha o arquivo
        return fclose($arquivo);

    }
}