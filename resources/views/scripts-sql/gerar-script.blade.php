@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <span></span>
@stop

@section('content')

	@if($errors->any())
		@foreach($errors->all() as $error)
			<div class="alert alert-danger">
				{{$error}}
			</div>
		@endforeach	
	@endif
	
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
        <h3 class="card-title">Scripts</h3>
    </div>

    <!-- /.card-header -->
    <!-- form start -->
    @isset($data['tabelas'])
    <form method="post" action="{{ route('gerar-script') }}">
    @csrf
        <div class="card-body">

            <div class="row">

                <div class="col-2">
                    <div class="form-group">
                        <label for="extensao_arquivo">Tipo do Arquivo</label>
                        <input type="text" class="form-control" name="extensao_arquivo" id="extensao_arquivo" value="{{ $data['extensao_arquivo'] }}" readonly>
                    </div>
                </div>

                <div class="col-10">
                    <div class="form-group">
                        <label for="diretorio_arquivos">Diretório dos Arquivos</label>
                        <input type="text" class="form-control" name="diretorio_arquivos" id="diretorio_arquivos" value="{{ $data['diretorio_arquivos'] }}" readonly>
                    </div>
                </div>
                
            </div>

            <div class="row">

                <div class="col-4">

                    <div class="form-group">

                        <label for="tabela">Tabela:</label>
                        <select class="form-control" name="tabela" type="text">
                            @foreach($data['tabelas'] as $tabela)
                            <option value="{{$tabela}}">{{$tabela}}</option>
                            @endforeach
                        </select>

                    </div>
                
                </div>            

                <div class="col-4">
                    <div class="form-group">
                        <label for="comando">Comando:</label>
                        <select class="form-control" name="comando"> <!-- Removido o metódo onchange="validarForm()" - estudar melhor -->
                            <option value="INSERT">INSERT</option>
                            <option value="UPDATE OR INSERT">UPDATE OR INSERT</option>
                        </select>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label">Campo P/ comando: Update or Insert:</label>
                        <input class="form-control" type="text" name="coluna" >
                    </div>
                </div>

            </div>            
        </div>
        <div class="card-footer">            
            <button class="btn btn-success form-control col-2">Gerar Script</a>     
        </div>
    </form>
    @endisset    
@stop

@section('css')

@stop

@section('js')

    <script>
        /*function validarForm() { 
            var optionSelect = document.getElementById("comando").value;

            if(optionSelect == "INSERT" ){ 
                document.getElementById("comando").disabled = true;
            }else{
                document.getElementById("comando").disabled = false;
            }
        }*/

        function gerarScript(){
            console.log(document.getElementById('teste'))
            /*
            let parametros = []
            let xhr                          = new XMLHttpRequest(); //cria o objeto
            parametros['extensao_arquivo']       = document.getElementById("extensao_arquivo")
            parametros['diretorio_arquivos'] = document.getElementById("diretorio_arquivos")
            parametros['diretorio_saida']    = document.getElementById("diretorio_saida")
            parametros['tabela']             = document.getElementById("tabela")
            parametros['comando']            = document.getElementById("comando")
            parametros['coluna']             = document.getElementById("coluna")

            xhr.open('GET', `http://localhost:8000/gerar-script/${parametros}`) //define o endereco e se é do tipo GET ou POST
            
            alert(xhr.status)
            xhr.send()
            /*xhr.onload = function(){
                
                if(xhr.status == 200){
                    result = JSON.parse(xhr.responseText)
                }else if(xhr.status === '404') {
                    alert('Deu treta');
                }
            }*/

            //xhr.send()//executa a requisição do open() de fato*/
        }
    </script>
@stop