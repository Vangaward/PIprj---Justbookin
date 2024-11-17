<?php session_start(); $txt=""; if (!isset($_SESSION['j1407b'])) {
  $_SESSION['j1407b'];
}

if (!isset($_SESSION['j1407bKey']))
{
die('<html><body style="font-size: 40px;">Olhá só, parece que você encontrou meu EasterEgg, porém eu não posso te entregar ele assim tão facilmente, se você quiser ter acesso a ele não basta apenas abrir esse arquivo, você tem que fazer por merecer. Pra você poder ter acesso ao conteúdo desse easterEgg, eu pesso encarecidamente que não trapaceie, deu trabalho fazer isso e eu quero que você se empenhe em procurar pelas telas do sistema a porta para esse EasterEgg. Vai ser divertido! Eu acredito em você!</body></html>');
}
else
{

?>

<html lang="pt-br">

<head>

<meta charset="UTF-8">
<title>J1407b?</title>

</head>

<style>

 @keyframes esmaecer
 {
     from {background-color: #ffffff;}
	to {background-color: #000000;}
 }
  @keyframes esmaecerTxt
 {
    from { opacity: 0.0; }
     to { opacity: 1; }
 }
 body
{ 
    background-color: #000000;
    text-align: center;
    height: 97vh;
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
}
.legendas
{
    animation-name: esmaecerTxt;
    animation-duration: 3s;
    color: #ffffff;
    font-size: 40px;
    margin-top: 60px;
}
.btns
{
    animation-name: esmaecerTxt;
    animation-duration: 10s;
    cursor: pointer;
    border-radius: 7px;
    margin-top: 60px;
    /*width: 140px;*/
    height: 40px;
}

</style>

<body>
<?php

/*MAS RAPAZ? OLHA, VÊ SE PARA DE FUÇAR NO CÓDIGO E VAI PROCURAR A MANEIRA CORRETA 
DE ACESSAR ESSE EASTER EGG, É SÉRIO VAI SER LEGAL PROCURAR
PELO SISTEMA COMO ACESSÁ-LO!*/

$_SESSION['j1407b'] = 't0';

if (!isset($_POST['t15.1b1']))
{
	if (!isset($_SESSION['j1407bvqj'])) ////vqj = Vez que está jogando
	  {
		  $_SESSION['j1407bvqj'] = 1;
	  }

	if ($_SESSION['j1407bvqj'] == 2)
	{
	  $_SESSION['j1407b'] = 'r2';
	}
	if ($_SESSION['j1407bvqj'] == 3)
	{
	  $_SESSION['j1407b'] = 'r3';
	}
	if ($_SESSION['j1407bvqj'] == 4)
	{
	  $_SESSION['j1407b'] = 'r4';
	}

	if (isset($_POST['r2b1']) || isset($_POST['r3b1']))
	{
		$_SESSION['j1407b'] = 't0';
	}
}
/**//**/

if (isset($_POST['t0b1']))
{
  $_SESSION['j1407b'] = 't1';
}
if (isset($_POST['t0b2']))
{
	$_SESSION['j1407b'] = 't10';
}
if (isset($_POST['t1b1']))
{
  $_SESSION['j1407b'] = 't2';
}
if (isset($_POST['t2b1']))
{
  $_SESSION['j1407b'] = 't3';
}
if (isset($_POST['t2b2']))
{
  $_SESSION['j1407b'] = 't6';
}
if (!isset($_SESSION['j1407bKey'])){$txt=" ";}
if (isset($_POST['t3b1']) || isset($_POST['t7b1']))
{
  $_SESSION['j1407b'] = 't4';
}
if (isset($_POST['t3b2']))
{
  $_SESSION['j1407b'] = 't7';
}
if (isset($_POST['t4b1']))
{
  $_SESSION['j1407b'] = 't5';
}
if (isset($_POST['t6b1']) || isset($_POST['t8b1']))
{
  $_SESSION['j1407b'] = 't9';
}
if (isset($_POST['t7b2']))
{
  $_SESSION['j1407b'] = 't8';
}
if (isset($_POST['t10b1']))
{
  $_SESSION['j1407b'] = 't30';
}
if (isset($_POST['t10b2']))
{
  $_SESSION['j1407b'] = 't11';
}
if (isset($_POST['t11b1']))
{
  $_SESSION['j1407b'] = 't12';
}
if (isset($_POST['t11b2']))
{
  $_SESSION['j1407b'] = 't24';
}
if (isset($_POST['t12b1']))
{
  $_SESSION['j1407b'] = 't13';
}
if (isset($_POST['t13b1']))
{
  $_SESSION['j1407b'] = 't14';
}
if (isset($_POST['t13b2']))
{
  $_SESSION['j1407b'] = 't21';
}
if (isset($_POST['t14b1']))
{
  $_SESSION['j1407b'] = 't15';
}
if (isset($_POST['t15b1']))
{
	if (sha1(strtolower($_POST["t15tx1"])) == "f4f66e37f139f5585efff911e60af196865d8708")
	{$_SESSION['j1407b'] = 't16';}
	else
	{$_SESSION['j1407b'] = 't15.1';}
}
if (isset($_POST['t15.1b1']))
{
  $_SESSION['j1407b'] = 't14';
}
if (isset($_POST['t16b1']))
{
	if (sha1(strtolower($_POST["t16tx1"])) == "5dd4e85d9978dd65e738620ecb9c364667bfd297")//dc12a613487cfc433bdf981b7a65baf4
	{$_SESSION['j1407b'] = 't17';}
	else
	{$_SESSION['j1407b'] = 't15.1';}
}
if (isset($_POST['t17b1']))
{
	if (sha1(strtolower($_POST["t17tx1"])) == "da4b9237bacccdf19c0760cab7aec4a8359010b0")
	{$_SESSION['j1407b'] = 't18';}
	else
	{$_SESSION['j1407b'] = 't15.1';}
}
if (isset($_POST['t18b1']))
{
	if (sha1(strtolower($_POST["t18tx1"])) == "79eeb8d93f0b5ae8aad2546dc6e63f3f24529bff")
	{$_SESSION['j1407b'] = 't19';}
	else
	{$_SESSION['j1407b'] = 't15.1';}
}
if (isset($_POST['t19b1']))
{
	$_SESSION['j1407b'] = 't20';
}
if (isset($_POST['t21b1']))
{
	$_SESSION['j1407b'] = 't22';
}
if (isset($_POST['t21b2']))
{
	$_SESSION['j1407b'] = 't23';
}
if (isset($_POST['t24b1']))
{
	$_SESSION['j1407b'] = 't25';
}
if (isset($_POST['t25b1']))
{
	$_SESSION['j1407b'] = 't26';
}
if (isset($_POST['t26b1']))
{
	$_SESSION['j1407b'] = 't27';
}
if (isset($_POST['t27b1']))
{
	$_SESSION['j1407b'] = 't28';
}
if (isset($_POST['t28b1']))
{
	$_SESSION['j1407b'] = 't29';
}
if (isset($_POST['t30b1']))
{
	$_SESSION['j1407b'] = 't31';
}
if (isset($_POST['t30b2']))
{
	$_SESSION['j1407b'] = 't33';
}
if (isset($_POST['t33b1']) || isset($_POST['t33b2']))
{
	$_SESSION['j1407b'] = 't34';
}
if (isset($_POST['t31b1']))
{
	$_SESSION['j1407b'] = 't32';
}
/*--Retornar à página de login--*/
if (isset($_POST['t5b1']) || isset($_POST['t9b1']) || isset($_POST['t20b1']) || isset($_POST['t22b1']) || isset($_POST['t23b1']) || isset($_POST['t29b1']) || isset($_POST['t32b1']) || isset($_POST['t34b1']))
{
	$_SESSION['j1407b'] = 'tFinais';
}
if (isset($_POST['tFinaisb1']))
{
	$_SESSION['j1407bvqj'] ++;
	$_SESSION['j1407b'] = 'login';
}
/*---*/
else if (isset($_POST['t0b2']))
{
  //Ainda não planejado no BrModelo
}
?>
<form method="post" action="">

<label id="textosId"></label>
<script>var textos = document.getElementById("textosId");</script>

<?php 

$fundoImgUrl = "url('imagens/j1407b.jpg')";
$ton618ImgUrl = "url('imagens/Ton618.png')";
if ($txt!=""){die("<html><body style='color: #ffffff'>Qual a dificuldade em fazer o que eu pedi?</body></html>");}
if ($_SESSION['j1407b'] == "t0")
{
$t0txt = "<label class='legendas'>[Voz grave] Quem ousas me incomodar?</label> <br><br><input type='submit' name='t0b1' value='Não fui eu' class='btns'> <input type='submit' name='t0b2' value='Fui eu' class='btns'>"; //t0b1 = botão 1 do t0

echo '
<style>
body
{
    animation-name: esmaecer;
    animation-duration: 5s;
}
</style>
<script>

var myTimeout = setTimeout(t0, 6000);

function t0 ()
{
    textos.innerHTML = "' . $t0txt . '";
}

</script>

';
}
//$_SESSION['j1407b'] = "t22";
if ($_SESSION['j1407b'] == "r2")
{
$r2txt = "<label class='legendas'>Ei, espere, EU ME LEMBRO DE VOCÊ! Essa é a 2ª vez que você está jogando esse EasterEgg. Poxa que legal! Talvez você tenha encontrado um dos finais e depois disso você ficou curioso e voltou aqui para procurar por outro! Bom, então vamos lá..</label> <br><br><input type='submit' name='r2b1' value='Iniciar' class='btns'>"; //r2b1 = botão 1 do r2

echo '<script>textos.innerHTML = "' . $r2txt . '";</script>';
}
if ($_SESSION['j1407b'] == "r3")
{
$r3txt = "<label class='legendas'>Hahahaha eu não acredito que você está aqui pela 3ª vez, isso é muito emocionante! Não é sempre que eu recebo visitas. A vida de um Easter Egg é muito solitária. Você realmente deve ter gostado desse jogo, ou só está curioso para saber o quão grande é esse Easter Egg. Ah, me descuple, eu falo muito. Agora fique com medo de mim para nós entrarmos no clima do jogo.</label> <br><br><input type='submit' name='r3b1' value='Iniciar' class='btns'>"; //r3b1 = botão 1 do r3

echo '<script>textos.innerHTML = "' . $r3txt . '";</script>';
}
if ($_SESSION['j1407b'] == "r4")
{
$r4txt = "<label class='legendas'>Ok, eu acho melhor eu parar de falar com <br>você no começo das nossas aventuras......<br>É serio pode confiar em mim, essa é a última vez que eu te atrapalho,<br>não vou fazer isso de novo.<br>Vamos direto ao ponto: Quem ousas me incomodar?</label> <br><br><input type='submit' name='t0b1' value='Não fui eu' class='btns'> <input type='submit' name='t0b2' value='Fui eu' class='btns'>"; //Os botões do t0 estão aqui para seguir o roteiro do Easter Egg.

echo '<script>textos.innerHTML = "' . $r4txt . '";</script>';
}

if ($_SESSION['j1407b'] == "t1")
{
$t1txt = "<label class='legendas'>[Voz grave] Tu realmente achas que alguém digitarias - J1407b - numa tela de login por motivo algum?</label> <br><br><input type='submit' name='t1b1' value='Uh...' class='btns'>"; //t1b1 = botão 1 do t1

echo '<script>textos.innerHTML = "' . $t1txt . '";</script>';
}

if ($_SESSION['j1407b'] == "t2")
{
    $t2txt = "<label class='legendas'>Há provas, provas muito mais que suficientes de que foste tu!</label> <br><br><input type='submit' name='t2b1' value='Você está certo' class='btns'><input type='submit' name='t2b2' value='Por favor, me perdoe' class='btns'>"; //t2b1 = botão 1 do t2

echo'<script> textos.innerHTML = "' . $t2txt . '"; </script>';

}

if ($_SESSION['j1407b'] == "t3")
{
    $t3txt = "<label class='legendas'>De fato, estou! mas em minha grande sabedoria, pude eu perceber que tu não sabes o que estás fazendo e, nem mesmo por que estás aqui.</label> <br><br><input type='submit' name='t3b1' value='Não sei' class='btns'><input type='submit' name='t3b2' value='Eu sei' class='btns'>"; //t3b1 = botão 1 do t3

echo'<script> textos.innerHTML = "' . $t3txt . '"; </script>';

}

if ($_SESSION['j1407b'] == "t4")
{
    $t4txt = "<label class='legendas'>Obviamente não sabes, pois tamanha é a tua insignificância. Jarvis! Acompanhe este ser até a saída, pois ele não sabe nem mesmo onde está. Rapido, antes que seja tarde demais.</label> <br><br><input type='submit' name='t4b1' value='Acompanhar o Jarvis' class='btns'>"; //t4b1 = botão 1 do t4

echo'<script> textos.innerHTML = "' . $t4txt . '"; </script>';

}

if ($_SESSION['j1407b'] == "t5")
{
    $t5txt = "<label class='legendas'>[Então você ouve um alto som de uma porta abrindo, você é então arremessado para fora.]<br><br>Final 1 - Jarvis</label> <br><br><input type='submit' name='t5b1' value='>...' class='btns'>"; //t5b1 = botão 1 do t5

echo'<script> textos.innerHTML = "' . $t5txt . '"; </script>';

}
if ($_SESSION['j1407b'] == "t6")
{
    $t6txt = "<label class='legendas'>[A voz fica mais grave e alta] Agora é tarde demais, tu não deverias estar aqui!</label> <br><br><input type='submit' name='t6b1' value='Como assim?' class='btns'>"; //t6b1 = botão 1 do t6

echo'<script> textos.innerHTML = "' . $t6txt . '"; </script>';

}

if ($_SESSION['j1407b'] == "t7")
{
    $t7txt = "<label class='legendas'>[A voz fica mais grave e alta] Diga-me então, onde tu estás?</label> <br><br><input type='submit' name='t7b1' value='Em um site de Livros e textos' class='btns'> <input type='submit' name='t7b2' value='Estou Em frente ao J1407b' class='btns'>"; //t7b1 = botão 1 do t7

echo'<script> textos.innerHTML = "' . $t7txt . '"; </script>';

}
if ($_SESSION['j1407b'] == "t8")
{
    $t8txt = "<label class='legendas'>Realmente tu reconheces este local, mas agora já é tarde! Tu não deverias estar aqui, tenho pena de ti.</label> <br><br><input type='submit' name='t8b1' value='Como assim?' class='btns'>"; //t8b1 = botão 1 do t8

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t8txt . '"; </script>';

}
if ($_SESSION['j1407b'] == "t9")
{
    $t8txt = "<label class='legendas'>[A radiação de J1407b é tão grande que seu corpo é desintegrado e agora você não passa de poeira flutuando pelo universo.]<br><br>Final 2 - Radioativo</label> <br><br><center><input type='submit' name='t9b1' value='>...' class='btns'></center>"; //t9b1 = botão 1 do t9

echo'<script> textos.innerHTML = "' . $t8txt . '"; </script>';

}
if ($_SESSION['j1407b'] == "t10")
{
$t10txt = "<label class='legendas'>Então tu sabes quem sou eu.</label> <br><br><input type='submit' name='t10b1' value='Sim' class='btns'><input type='submit' name='t10b2' value='Não' class='btns'>"; //t10b1 = botão 1 do t10

echo '<script>textos.innerHTML = "' . $t10txt . '";</script>';
}
if ($_SESSION['j1407b'] == "t11")
{
$t11txt = "<label class='legendas'>[A voz fica raivosa] ENTÃO VOCÊ ESTÁ DIZENDO QUE FOI VOCÊ QUE ME INCOMODOU MAS NÃO SABE QUEM SOU EU?</label> <br><br><input type='submit' name='t11b1' value='Me desculpe,não foi minha intenção' class='btns'> <input type='submit' name='t11b2' value='Isso não faz sentido' class='btns'>"; //t11b1 = botão 1 do t11

echo '<script>textos.innerHTML = "' . $t11txt . '";</script>';
}
if ($_SESSION['j1407b'] == "t12")
{
$t12txt = "<label class='legendas'>Interessante... Um intruso que desconhece minha identidade. Permita-me revelar-te, pequeno ser. Eu sou J1407b, um planeta grande e misterioso. Há séculos ninguém notou que estou aqui, e agora tu me encontraste. Mas o que te trouxe até aqui?</label> <br><br><input type='submit' name='t12b1' value='Por que você estava me observando?' class='btns'>"; //t12b1 = botão 1 do t12

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t12txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t13")
{
$t13txt = "<label class='legendas'>Ah, curiosidade! Eu estava observando a Terra e seus habitantes, estudando tudo o que vocês fazem. Há tanto mistério e potencial nesse pequeno planeta azul.  E então, por acaso, tu surgiste em meu caminho. Agora, permita-me fazer-te uma pergunta:<br>O que te motiva a explorar o desconhecido?</label> <br><br><input type='submit' name='t13b1' value='Sou um aventureiro em busca de descobertas.' class='btns'> <input type='submit' name='t13b2' value='Não tenho um motivo específico, apenas gosto de explorar' class='btns'>"; //t13b1 = botão 1 do t13

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t13txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t14")
{
$t14txt = "<label class='legendas'>Um aventureiro em busca dedescobertas, como eu esperava. Poucos têm a coragem de se lançar nessa busca incansável. Tu és uma vida valente, e posso apreciar isso.<br>Estás pronto para enfrentar os desafios que eu te preparar?</label> <br><br><input type='submit' name='t14b1' value='Estou pronto(a) para enfrentar qualquer desafio' class='btns'>"; //t14b1 = botão 1 do t14

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t14txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t15")
{
$t15txt = "<label class='legendas'>Ótimo! Abrace o desafio das charadas e mostre a tua habilidade em decifrar enigmas. Aqui vai a primeira charada: 'Posso ser feito de água, mas, nesse caso, você não tentaria me beber. Quando me tocas, desapareço. Quem sou eu?<br><b>Lembra-te de não usar acentos!</b></label> <br><br><input type='text' placeholder='Escreva a sua resposta aqui' name='t15tx1' class='btns' required><input type='submit' name='t15b1' value='Enviar' class='btns'>"; //t15b1 = botão 1 do t15 | t15tx1 = Caixa de texto 1 do t15

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t15txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t15.1")
{
$t15p1txt = "<label class='legendas'>Tu és um ser burro e sem criatividade! Volte ao começo.<br>Dar-te-ei apenas uma dica: Não é necessário usar a barra de espaço para responder as charadas. (Se fores inteligente saberás o que isso significa).</label> <br><br><input type='submit' name='t15.1b1' value='Voltar ao inicio' class='btns'>"; //t15.1b1 = botão 1 do t15.1

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t15p1txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t16")
{
$t16txt = "<label class='legendas'>Próxima charada: Sou um enigma que desafia a mente, Sem forma, sem corpo, sem limite aparente. Quando me procuram, me encontram distante, E quanto mais me buscam, mais longe estou adiante.<br>Quem sou eu?</label> <br><br><input type='text' placeholder='Escreva a sua resposta aqui' name='t16tx1' class='btns' required><input type='submit' name='t16b1' value='Enviar' class='btns'>"; //t16b1 = botão 1 do t16 | t16tx1 = Caixa de texto 1 do t16

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t16txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t17")
{
$t17txt = "<label class='legendas'>Vamos à próxima charada:<br>Se 11 + 2 é igual a 1, quanto é 9 + 5?</label><br><br><input type='text' placeholder='Escreva a sua resposta aqui' name='t17tx1' class='btns' required><input type='submit' name='t17b1' value='Enviar' class='btns'>"; //t17b1 = botão 1 do t17 | t17tx1 = Caixa de texto 1 do t17

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t17txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t18")
{
$t18txt = "<label class='legendas'>Muito Bem! Pareces que estás se saindo bem,<br>mas será que consiguirás passar pela última, e mais difícil charada?:<br>'Sou extremamente grande, não existem fotos reais de mim, tenho anéis que são 200 vezes maiores que os aneis de Saturno' Quem sou eu?</label><br><br><input type='text' placeholder='Escreva a sua resposta aqui' name='t18tx1' class='btns' required><input type='submit' name='t18b1' value='Enviar' class='btns'>"; //t18b1 = botão 1 do t18 | t18tx1 = Caixa de texto 1 do t18

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t18txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t19")
{
$t19txt = "<label class='legendas'>Tua sabedoria és admirável,<br>venha e chegue mais perto de mim, sua recompensa está aqui!</label><br><br><input type='submit' name='t19b1' value='Aproximar-se' class='btns'>"; //t19b1 = botão 1 do t19

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t19txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t20")
{
$t20txt = "<label class='legendas'>Você ouve um alto som e uma forte luz aparece sobre os seus olhos:<br>Agora você faz parte de J1407b!<br><br>Final 5 - A grande recompensa</label><br><br><input type='submit' name='t20b1' value='>...' class='btns'>"; //t20b1 = botão 1 do t20

echo'<script>textos.innerHTML = "' . $t20txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t21")
{
$t21txt = "<label class='legendas'>Como assim? Apenas gosta de explorar? Não tens um propósito, um objetivo claro? Estás brincando comigo? Não tenho tempo para lidar com aventureiros sem rumo!</label><br><br><input type='submit' name='t21b1' value='Como pode estar perdendo seu tempo se você não é um ser vivo?' class='btns'><input type='submit' name='t21b2' value='Desculpe, não quis ofendê-lo.' class='btns'>"; //t21b1 = botão 1 do t21

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $fundoImgUrl . '";
textos.innerHTML = "' . $t21txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t22")
{
$t22txt = "<label class='legendas'>Você está certo, eu... <br>[J1407b mal termina a frase quando ocorre uma querbra de realidade, você percebe que tudo estava na sua imaginação e você ainda estava na tela de login.]<br><br>Final 3 - Quebra de realidade</label><br><br><input type='submit' name='t22b1' value='>...' class='btns'>"; //t22b1 = botão 1 do t22

echo'<script>textos.innerHTML = "' . $t22txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t23")
{
$t23txt = "<label class='legendas' style='-webkit-text-stroke: 0.3px black;'>Tuas palavras são tardias, agora ventos estelares te enpurrarão para TON 618.<br>[Se você não tivesse gastado seu tempo imaginando-se ter uma conversa com um planeta, você teria percebido que estava indo em direção à um buraco negro -<br>Parabéns!]<br><br>Final 4 - Ton 618.</label><br><br><input type='submit' name='t23b1' value='>...' class='btns'>"; //t23b1 = botão 1 do t23

echo'<script> var body = document.querySelector("body");
body.style.backgroundImage = "' . $ton618ImgUrl . '";
textos.innerHTML = "' . $t23txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t24")
{
$t24txt = "<label class='legendas'>[A voz fica extremamente mais raivosa e rápida] QUEM NÃO FAZ SENTIDO? VOCÊ NÃO FAZ SENTIDO! SE VOCÊ NÃO QUER FAZER SENTIDO, NÃO TEREMOS SENTIDO!!!</label><br><br><input type='submit' name='t24b1' value='Terra plana' class='btns'><input type='submit' name='t24b1' value='Ornitorrinco' class='btns'>"; //t24b1 = botão 1 do t24

echo'<script>textos.innerHTML = "' . $t24txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t25")
{
$t25txt = "<label class='legendas'>Eu não falo nada sobre isso que você me falou mas acho melhor pra você registrar o seu comentário se for curto.</label><br><br><input type='submit' name='t25b1' value='Já' class='btns'><input type='submit' name='t25b1' value='Vou registrar' class='btns'>"; //t25b1 = botão 1 do t25

echo'<script>textos.innerHTML = "' . $t25txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t26")
{
$t26txt = "<label class='legendas'>Lá no Brasil é um dos mais importantes de todos os dias da semana Excel</label><br><br><input type='submit' name='t26b1' value='Kill' class='btns'><input type='submit' name='t26b1' value='Eu não sabia disso' class='btns'>"; //t26b1 = botão 1 do t26

echo'<script>textos.innerHTML = "' . $t26txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t27")
{
$t27txt = "<label class='legendas'>Su nombre era uma das sugestões é que nós estamos preparado para o dia mais importante do dia ਪਲਾਊ  /  მდინარე ტიტე</label><br><br><input type='submit' name='t27b1' value='Joias' class='btns'><input type='submit' name='t27b1' value='Certo' class='btns'>"; //t27b1 = botão 1 do t27

echo'<script>textos.innerHTML = "' . $t27txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t28")
{
$t28txt = "<label class='legendas'>Cão e a documentação que você vai fazer é um pequeno grupo de pessoas que estão dormindo e que você não conseguiria Советский Союз оставил одного из своих астронавтов на Луне, когда Марс завоевал Бразилию</label><br><br><input type='submit' name='t28b1' value='Fui' class='btns'><input type='submit' name='t28b1' value='Youtube android' class='btns'>"; //t28b1 = botão 1 do t28

echo'<script>textos.innerHTML = "' . $t28txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t29")
{
$t29txt = "<label class='legendas'>Ua hiki ʻoe i ka hopena o kēia huakaʻi, mahalo no ka unuhi ʻana i kēlā ʻōlelo, kakaikahi ka poʻe e hana pēlā, congratlations.  você estourou!<br><br>Final 6 - desapropositado.</label><br><br><input type='submit' name='t29b1' value='>...' class='btns'>"; //t29b1 = botão 1 do t29

echo'<script>textos.innerHTML = "' . $t29txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t29.1")
{//t29.1 Não está sendo usado.
$t29txt = "<label class='legendas'>t29.1</label>";

echo'<script>textos.innerHTML = "' . $t29txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t30")
{
$t30txt = "<label class='legendas'>Como você me conhece?</label><br><br><input type='submit' name='t30b1' value='Não pararam de me falar sobre você' class='btns'><input type='submit' name='t30b2' value='Pesquisei sobre você' class='btns'>"; //t30b1 = botão 1 do t30

echo'<script>textos.innerHTML = "' . $t30txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t31")
{
$t31txt = "<label class='legendas'>Incrível, pois bem eu lhe digo, ouça essa pessoa fala-te sobre mim, pois esta tem grande sabedoria. Escute-a! Por conta disso, te darei um grande presente, algo que irá ajudar-te para sempre, aceite-o!</label><br><br><input type='submit' name='t31b1' value='Aceitar' class='btns'>"; //t31b1 = botão 1 do t31

echo'<script>textos.innerHTML = "' . $t31txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t32")
{
$t32txt = "<label class='legendas'>Este é um pisante feito com pele de Crolodilo, ele será muito útil a ti quando precisares cruzar o deserto do Saara ou quando precisares ir a uma reunião de negócios. Esta é a mais alta honrarria que um ser-humano poderias receber.<br>Agora vá, e seja feliz!<br><br><img style='width: 150px;' src='fotosPerfil/AHJnAbNANJAHBNPBAAIOBJAKJBHVKjbgv.png'/><br><br>Final 7 - Uma ajuda eterna!</label><br><br><input type='submit' name='t32b1' value='Pegar presente e voltar pra casa' class='btns'>"; //t32b1 = botão 1 do t32

echo'<script>textos.innerHTML = "' . $t32txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t33")
{
$t33txt = "<label class='legendas'>Então você deve ser um pesquisador,<br>me diga o que tem dentro do grande monumento da Islândia.</label><br><br><input type='submit' name='t33b1' value='Apenas Gelo' class='btns'><input type='submit' name='t33b2' value='A escada até o observador' class='btns'>"; //t33b1 = botão 1 do t33

echo'<script>textos.innerHTML = "' . $t33txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "t34")
{
$t34txt = "<label class='legendas'>Pesquisador fementido, provou-se ser uma farsa! Enviar-lo-ei a um local onde poderás adquirir mais conhecimento.<br><br>Final 8 - Pesquisador fementido</label><br><br><input type='submit' name='t34b1' value='>...' class='btns'>"; //t34b1 = botão 1 do t34

echo'<script>textos.innerHTML = "' . $t34txt . '"; </script>';
}
if ($_SESSION['j1407b'] == "tFinais")
{
$tFinaisTxt = "<div style='display: inline-block; text-align: left;'><label class='legendas'>Finais possíveis:<br><br>Final 1 - Jarvis<br>Final 2 - Radioativo<br>Final 3 - Quebra de realidade<br>Final 4 - TON 618<br>Final 5 - A grande recompensa<br>Final 6 - Desapropositado<br>Final 7 - Uma ajuda eterna!<br>Final 8 - Pesquisador fementido</label><br><br><center><input type='submit' name='tFinaisb1' value='>...' class='btns'></center></div>"; //tFinaisb1 = botão 1 do tFinais

echo'<script>textos.innerHTML = "' . $tFinaisTxt . '"; </script>';
}
if ($_SESSION['j1407b'] == "login")
{
    header('Location: login');
}
if ($_SESSION['j1407b'] == "login")
{
    header('Location: login');
}

?>
<script>console.log("<?php echo $_SESSION['j1407b']; ?>")</script>
</form>

</body>

</html>
<?php } ?>