@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="container">
                            <form  action="{{route('NewUser')}}" method="post" >
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputNome">Nome</label>
                                        <input type="text" name="nome" minlength="3" maxlength="60" class="form-control" id="inputEmail4" placeholder="Nome Completo">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail">Email</label>
                                        <input type="email" name="email" onchange="VerificarEmail(this.value)" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword">Senha</label>
                                        <input type="password" name="senha" class="form-control" id="inputPassword4" placeholder="Senha">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPasswordConfirm">Confirma Senha</label>
                                        <input type="password" name="senha2" class="form-control" id="inputPasswordConfirm" placeholder="Confirma Senha">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="inputCep">CEP</label>
                                        <input type="text" placeholder="Cep" name="cep" required onblur="pesquisacep(this.value);" class="form-control" id="inputCep">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="inputRua">Rua</label>
                                        <input type="text" placeholder="rua" name="rua" required class="form-control"   id="rua">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputNum">Numero</label>
                                        <input type="number" placeholder="numero" name="numero" class="form-control" id="inputNum">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.es.gov.br/scripts/jquery/1.11.2/jquery-1.11.2.min.js"></script>
    <script src="https://cdn.es.gov.br/scripts/jquery/jquery-mask/1.7.7/jquery.mask.min.js"></script>
    <script>
        jQuery(function ($) {
            $('#inputCep').mask('00000-000');


            });
    </script>
  <script>


      function limpa_formulário_cep() {
          //Limpa valores do formulário de cep.
          document.getElementById('rua').value=("");
          document.getElementById('bairro').value=("");
      }
      function meu_callback(conteudo) {
          if (!("erro" in conteudo)) {
              //Atualiza os campos com os valores.
              document.getElementById('rua').value=(conteudo.logradouro);
          } //end if.
          else {
              //CEP não Encontrado.
              limpa_formulário_cep();
              alert("CEP não encontrado.");
          }
      }

      function VerificarEmail(valor) {

          $.ajax({
              url: 'VerificarEmail/' + valor, // verifica se user ja é um afiliado
              type: 'GET',
              dataType: 'json',
          }).done(function (data) {
              console.log(data)
              if(data.email ==  valor){
                alert('email ja Cadastrado');
                $('#inputEmail').val("");
              }
          }).fail(function (erro) {
              console.log(erro)
          });
      }

      function pesquisacep(valor) {

          //Nova variável "cep" somente com dígitos.
          var cep = valor.replace(/\D/g, '');


          //Verifica se campo cep possui valor informado.
          if (cep != "") {

              //Expressão regular para validar o CEP.
              var validacep = /^[0-9]{8}$/;

              //Valida o formato do CEP.
              if(validacep.test(cep)) {

                  //Preenche os campos com "..." enquanto consulta webservice.
                  document.getElementById('rua').value="...";

                  //Cria um elemento javascript.
                  var script = document.createElement('script');

                  //Sincroniza com o callback.
                  script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                  //Insere script no documento e carrega o conteúdo.
                  document.body.appendChild(script);

              }else {
                  //cep é inválido.
                  limpa_formulário_cep();
                  swal({
                      title: "Atenção!",
                      text: "Formato de CEP inválido!",
                  });

              }
          } //end if.
          else {
              //cep sem valor, limpa formulário.
              limpa_formulário_cep();
          }
      };


  </script>


</body>
</html>



@endsection
