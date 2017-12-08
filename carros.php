<!DOCTYPE html>
<html>
    <head>
        <title>Teste de Desenvolvimento</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="lib/bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/jquery-1.11.3.min.js"></script>
        <script src="lib/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $(".cadastro-carro").click(function(){
                    $("#consultar").attr("style","display:none");
                    $("#frmCadastro").removeAttr("style");
                    $(this).addClass("active");
                    $(".list-carro").removeClass("active");
                    
                    $("#hdnid").val("");
                    $("#txtnome").val("");
                    $("#txtmodelo").val("");
                    $("#txtano").val("");
                    $("#lstmarca").val("");  
                });
                
                $(".list-carro").click(function(){
                    $("#frmCadastro").attr("style","display:none");
                    $("#consultar").removeAttr("style");
                    $(this).addClass("active");
                    $(".cadastro-carro").removeClass("active");
                    $.post("carros/consultar.php", {consulta: true}, function (data) {
                    try {
                            var json = $.parseJSON(data);
                            $(".carros-list").html(json);
                        } catch (err) {
                            alert(err);
                        }
                    });
                });
                
                $.post("carros/consultar.php", {consulta: true}, function (data) {
                    try {
                        var json = $.parseJSON(data);
                        $(".carros-list").html(json);
                    } catch (err) {
                        alert(err);
                    }
                });
            });
            $(function () {
                $(document).on('click','.delete-carro',function(){
                    var confirma = confirm("Deseja excluir o carro ?");
                    if(!confirma){
                        return false;
                    }
                    
                    
                    var id = $(this).attr("attrDelete");
                    
                    
                    $.post("carros/excluir.php", {id:id}, function (data) {
                        try {
                            var json = $.parseJSON(data);
                            if(json['MSG'] == "OK"){
                                alert("Carro excluido com sucesso !");
                                $.post("carros/consultar.php", {consulta: true}, function (data) {
                                  try {
                                      var json = $.parseJSON(data);
                                      $(".carros-list").html(json);
                                  } catch (err) {
                                      alert(err);
                                  }
                                });
                            }else{
                                alert("O carro não pode ser cadastrado !");
                            }
                        } catch (err) {
                            alert(err);
                        }
                    });
                });
                $(document).on('click','.edit-carro',function(){
                    var id = $(this).attr("attrEdit");
                    $.post("carros/consultar.php", {consulta: true, id:id}, function (data) {
                        try {
                            var json = $.parseJSON(data);
                            
                            $("#consultar").attr("style","display:none");
                            $("#frmCadastro").removeAttr("style");
                            $(this).addClass("active");
                            $(".list-carro").removeClass("active");

                            $("#hdnid").val(json["id"]);
                            $("#txtnome").val(json["nome"]);
                            $("#txtmodelo").val(json["modelo"]);
                            $("#txtano").val(json["ano"]);
                            $("#lstmarca").val(json["marca"]);
                            
                        } catch (err) {
                            alert(err);
                        }
                    });
                });
                $(document).on('click','#btnsave',function(){
                   var form = $("#frmCadastro").serialize();
                   var id = $("#hdnid").val();
                   if(id.length){
                       $.post("carros/editar.php",form,function(data){
                           var json = $.parseJSON(data);
                           if(json['MSG'] == "OK"){
                               alert("Carro editado com sucesso !");
                               $("#frmCadastro").attr("style","display:none");
                               $("#consultar").removeAttr("style");
                               $(".list-carro").addClass("active");
                               $(".cadastro-carro").removeClass("active");
                               $.post("carros/consultar.php", {consulta: true}, function (data) {
                                 try {
                                     var json = $.parseJSON(data);
                                     $(".carros-list").html(json);
                                 } catch (err) {
                                     alert(err);
                                 }
                             });
                           }else{
                               alert("O carro não pode ser cadastrado !");
                           }
                        });  
                   }else{
                        $.post("carros/cadastrar.php",form,function(data){
                           var json = $.parseJSON(data);
                           if(json['MSG'] == "OK"){
                               alert("Carro cadastrado com sucesso !");
                               $("#frmCadastro").attr("style","display:none");
                               $("#consultar").removeAttr("style");
                               $(".list-carro").addClass("active");
                               $(".cadastro-carro").removeClass("active");
                               $.post("carros/consultar.php", {consulta: true}, function (data) {
                                 try {
                                     var json = $.parseJSON(data);
                                     $(".carros-list").html(json);
                                 } catch (err) {
                                     alert(err);
                                 }
                             });
                           }else{
                               alert("O carro não pode ser cadastrado !");
                           }
                        });
                    }
                });
            });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Teste Dev</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="carros.php">Carros</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid text-center">
            <div class="row content">
                <div class="col-sm-2 sidenav list-group">
                    <p><a href="#" class="list-carro list-group-item active">Listar</a></p>
                    <p><a href="#" class="cadastro-carro list-group-item">Cadastrar</a></p>
                </div>
                <div class="col-sm-8 text-left">
                    <h1>Carros</h1>
                    <div class="container" id="body-carro">
                        <table class="table table-striped table-hover table-responsive" id="consultar">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NOME</th>
                                    <th>MARCA</th>
                                    <th>MODELO</th>
                                    <th>ANO</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody class="carros-list">
                                
                            </tbody>
                        </table>

                        <form name="frmCadastro" id="frmCadastro" method="post" action="#" onsubmit="return false" style="display: none;">
                            <fieldset>
                                <legend>Cadastro</legend>
                                <input name="hdnid" id="hdnid" type="hidden" />
                                <div class="form-group">
                                    <label>Nome *</label><br>
                                    <input name="txtnome" id="txtnome" type="text" value="" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label>Marca *</label><br>
                                    <select name="lstmarca" id="lstmarca" class="form-control" required>
                                        <option value="">Selecione</option>
                                        <option value="Honda">Honda</option>
                                        <option value="Fiat">Fiat</option>
                                        <option value="Reno">Reno</option>
                                        <option value="BMW">BMW</option>
                                        <option value="Ford">Ford</option>
                                        <option value="Chevrolet">Chevrolet</option>
                                        <option value="Toyota">Toyota</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Modelo *</label><br>
                                    <input name="txtmodelo" id="txtmodelo" type="text" value="" class="form-control" required/>
                                </div>
                                <div class="form-group">
                                    <label>Ano</label><br>
                                    <input name="txtano" id="txtano" type="number" value="" min="1900" maxlength="4" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <input name="btnsave" id="btnsave" type="submit" value="Salvar" class="btn btn-info" />
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer class="container-fluid text-center">
            <p>&nbsp;</p>
        </footer>

    </body>
</html>

