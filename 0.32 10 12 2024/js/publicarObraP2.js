var adicionarCapituloButton = document.getElementById('adicionar-capitulo');
var removerCapituloButton = document.getElementById('remover-capitulo');
var quantidadeInput = document.getElementById('quantidade');
var capitulosContainer = document.getElementById('capitulos-container');
var capituloData = []; // Array para armazenar os dados dos capítulos
var quantidadePaginas = <?php echo $qtdPaginas; ?>; // Quantidade de páginas do PDF

// Função para adicionar um capítulo
function adicionarCapitulo() {
  var quantidade = capituloData.length + 1;

  // Cria os campos de entrada para o novo capítulo
  var inputLabel = document.createElement('label');
  inputLabel.textContent = 'Capítulo ' + quantidade + ' - Nome: ';
  inputLabel.classList.add('lblIn');

  var inputField = document.createElement('input');
  inputField.setAttribute('type', 'text');
  inputField.setAttribute('name', 'capitulo[]');
  inputField.classList.add('txtCapitulo');
  inputField.setAttribute('value', 'Capítulo ' + quantidade);
  inputField.setAttribute('required', 'required');
  inputField.setAttribute('maxlength', '100');

  var paginaLabel = document.createElement('label');
  paginaLabel.textContent = 'Página Inicial:';
  paginaLabel.classList.add('lblPag');
  
  
  
  var paginaField = document.createElement('input');
  paginaField.setAttribute('type', 'number');
  paginaField.setAttribute('name', 'pagina[]');
  paginaField.setAttribute('min', '1');
  paginaField.setAttribute('max', quantidadePaginas);
  paginaField.classList.add('txtCapitulo');
  paginaField.setAttribute('required', 'required');

  var novoItem = document.createElement('hr');
	novoItem.classList.add('linhaCap');
	
  // Adiciona o event listener para validar o valor inserido
  paginaField.addEventListener('input', function() {
    var value = parseInt(paginaField.value);
    if (isNaN(value) || value < 1) {
      paginaField.value = '1';
    } else if (value > quantidadePaginas) {
      paginaField.value = quantidadePaginas.toString();
    }
  });

  // Adiciona o event listener para detectar o "Backspace" e limpar o campo se o valor for "1"
  paginaField.addEventListener('keyup', function(event) {
    var value = paginaField.value;

    if (event.keyCode === 8 && value === "1") {
      setTimeout(function() {
        paginaField.value = "";
      }, 0);
    }
  });

  capitulosContainer.appendChild(inputLabel);
  capitulosContainer.appendChild(inputField);
  capitulosContainer.appendChild(document.createElement('br'));
  capitulosContainer.appendChild(paginaLabel);
  capitulosContainer.appendChild(paginaField);
  capitulosContainer.appendChild(document.createElement('br'));
  capitulosContainer.appendChild(novoItem); // Adiciona a linha horizontal

  capituloData.push({
    nome: inputField.value,
    paginaInicial: paginaField.value
  }); // Armazena os dados do capítulo atual

  quantidadeInput.value = quantidade; // Atualiza o campo de quantidade
}

// Adicionar o capítulo inicial ao carregar a página
adicionarCapitulo();

adicionarCapituloButton.addEventListener('click', adicionarCapitulo);

removerCapituloButton.addEventListener('click', function() {
  if (capituloData.length > 1) {
    capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove a linha horizontal
    capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove a quebra de linha
    capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove o campo de entrada de página
    capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove o label de página
    capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove a quebra de linha
    capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove o campo de entrada de capítulo
    capitulosContainer.removeChild(capitulosContainer.lastChild); // Remove o label de capítulo

    capituloData.pop(); // Remove o último capítulo do array

    var quantidade = capituloData.length;
    quantidadeInput.value = quantidade; // Atualiza o campo de quantidade
  }
});

var enviarButton = document.getElementById('enviar');
enviarButton.addEventListener('click', function() {
  var formData = new FormData();

  for (var i = 0; i < capituloData.length; i++) {
    formData.append('capitulo[]', capituloData[i].nome);
    formData.append('pagina[]', capituloData[i].paginaInicial);
  }

  console.log(capituloData); // Exibe o array de capítulos no console para depurar

  // Realize a lógica para enviar os dados via AJAX ou qualquer outra abordagem desejada
  // ...
});

    var qtdCapitulos = document.getElementById("quantidade").value;
    
    function addCapitulo ()
    {
        qtdCapitulos++;
        quantidade.value = qtdCapitulos;
    }

    function valorMenorUm ()
    {

        if (qtdCapitulos < 1)
        {
            quantidade.value = 1;
        }
    }

    function haCapitulosFunc (haCapitulos)
    {
        //var haCapitulos = slctHaCapitulosId.value;
        var seletorCapitulosDiv = document.getElementById('seletorCapitulosId');
		var btnPublicarSemCapitulos = document.getElementById('btnPublicarSemCapitulosId');
        var campos = seletorCapitulosDiv.getElementsByTagName('input'); // Substitua 'input' pelo tipo de campo que você deseja desabilitar
        if (haCapitulos == "sim")
        {
			btnPublicarSemCapitulos.style.display = 'none';
            seletorCapitulosDiv.style.display = 'flex';
			
            for (var i = 0; i < campos.length; i++)
            {
                campos[i].disabled = false;
            }
        }
        if (haCapitulos == "nao")
        {
            seletorCapitulosDiv.style.display = 'none';

            for (var i = 0; i < campos.length; i++)
            {
            campos[i].disabled = true;
            }

            if (haCapitulos == "nao") { btnPublicarSemCapitulos.style.display = 'flex'; }
            else {btnPublicarSemCapitulos.style.display = 'none';}
        }
    }

	function qtdeCaracsTitulo(qtdeCaracteres)
	{
		var txtTitulo = document.getElementById('txtTituloId').value;
		var caractUsados = txtTitulo.length;
		document.getElementById('lblQtdeCaracTituloID').innerHTML = (qtdeCaracteres - caractUsados);
		
	}
	function qtdeCaracsDescricao(qtdeCaracteres)
	{
		var txtDescricao = document.getElementById('txtDescricaoId').value;
		var caractUsados = txtDescricao.length;
		document.getElementById('lblQtdeCaracDescricaoID').innerHTML = (qtdeCaracteres - caractUsados);
		
	}