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
        <h3 class="card-title">Arquivos</h3>
    </div>

    <!-- /.card-header -->
    <!-- form start -->
    <form method="post" action="{{ route('ler-diretorio') }}">
    @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-2">					
                    <div class="form-group">
                        <label for="extensao_arquivo">Tipo do Arquivo</label>
                        <select class="form-control" id="extensao_arquivo" name="extensao_arquivo">
                            <option value="XLSX" {{ old('extensao_arquivo') === 'XLSX' ? 'selected' : ''}}>XLSX</option>
                            <option value="XLS"  {{ old('extensao_arquivo') === 'XLS' ? 'selected' : ''}}>XLS</option>
                        </select>
                    </div>
                </div>	
                <div class="col-10">	
                    <div class="form-group">
                        <label for="diretorio_arquivos">Diretório dos arquivos</label>
                        <input type="text" class="form-control" id="diretorio_arquivos" name="diretorio_arquivos" value="{{ old('diretorio_arquivos') ?? '' }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success form-control col-2">Ler Diretório</a>
        </div>
    </form>
    
@stop

@section('css')

@stop

@section('js')
@stop