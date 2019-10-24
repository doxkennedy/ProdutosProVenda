<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Registar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::to('/css/my-login.css') }}">
</head>
<body class="my-login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand">
                    <img src="{{URL::to('/img/logo.jpg')}}" alt="logo">
                </div>
                <div class="card fat">
                    <div class="card-body">
                        <div class="card-header">{{ __('Register') }}</div>
                        <form method="POST" class="my-login-validation" action="{{ route('register') }}" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nome</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('Endereço de E-mail') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                                <div class="form-group">
                                    <label>CEP<span style="color:#ffa000;">*</span></label>
                                    <input type="text"  onblur="pesquisacep(this.value);" value=" " class="form-control form-control-line" name="cep" id="cep" required>
                                </div>
                                <div class="form-group">
                                    <label>Rua<span style="color:#ffa000;">*</span></label>
                                    <input type="text" placeholder="Rua exemplo" value="" class="form-control form-control-line"  name="rua" id="rua" required>
                                </div>
                                <div class="form-group">
                                    <label>Número<span style="color:#ffa000;">*</span></label>
                                    <input type="text" placeholder="00"   value=" "  class="form-control form-control-line" name="numero" id="numero" required>
                                </div>

                            <div class="form-group m-0">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                            <div class="mt-4 text-center">
                                Already have an account? <a href="{{route('login')}}">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{URL::to('js/my-login.js')}}"></script>
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
