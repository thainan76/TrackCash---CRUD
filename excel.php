<?php 
ini_set('max_execution_time','-1');
require_once "src/SimpleXLSX.class.php";

class ImportaPlanilha{

	// Atributo recebe a instância da conexão PDO
	private $conexao  = null;

     // Atributo recebe uma instância da classe SimpleXLSX
	private $planilha = null;

	// Atributo recebe a quantidade de linhas da planilha
	private $linhas   = null;

	// Atributo recebe a quantidade de colunas da planilha
	private $colunas  = null;

	/*
	 * Método Construtor da classe
	 * @param $path - Caminho e nome da planilha do Excel xlsx
	 * @param $conexao - Instância da conexão PDO
	 */
	public function __construct($path=null, $conexao=null){

		if(!empty($path) && file_exists($path)):
			$this->planilha = new SimpleXLSX($path);
			list($this->colunas, $this->linhas) = $this->planilha->dimension();
		else:
			echo 'Arquivo não encontrado!';
			exit();
		endif;

		if(!empty($conexao)):
			$this->conexao = $conexao;
		else:
			echo 'Conexão não informada!';
			exit();
		endif;

	}

	/*
	 * Método que retorna o valor do atributo $linhas
	 * @return Valor inteiro contendo a quantidade de linhas na planilha
	 */
	public function getQtdeLinhas(){
		return $this->linhas;
	}

	/*
	 * Método que retorna o valor do atributo $colunas
	 * @return Valor inteiro contendo a quantidade de colunas na planilha
	 */
	public function getQtdeColunas(){
		return $this->colunas;
	}

	/*
	 * Método que verifica se o registro CPF da planilha já existe na tabela cliente
	 * @param $cpf - CPF do cliente que está sendo lido na planilha
	 * @return Valor Booleano TRUE para duplicado e FALSE caso não 
	 */
	private function isRegistroDuplicado($cpf=null){
		$retorno = false;
<div style="clear:both; margin-top:0em; margin-bottom:1em;"><a href="http://www.devwilliam.com.br/php/corrigir-charset-em-paginas-php" target="_blank" rel="nofollow" class="udf068219721721cbd2409bd328de2eca"><!-- INLINE RELATED POSTS 1/3 //--><style> .udf068219721721cbd2409bd328de2eca , .udf068219721721cbd2409bd328de2eca .postImageUrl , .udf068219721721cbd2409bd328de2eca .centered-text-area { min-height: 80px; position: relative; } .udf068219721721cbd2409bd328de2eca , .udf068219721721cbd2409bd328de2eca:hover , .udf068219721721cbd2409bd328de2eca:visited , .udf068219721721cbd2409bd328de2eca:active { border:0!important; } .udf068219721721cbd2409bd328de2eca .clearfix:after { content: ""; display: table; clear: both; } .udf068219721721cbd2409bd328de2eca { display: block; transition: background-color 250ms; webkit-transition: background-color 250ms; width: 100%; opacity: 1; transition: opacity 250ms; webkit-transition: opacity 250ms; background-color: #2980B9; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.17); -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.17); -o-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.17); -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.17); } .udf068219721721cbd2409bd328de2eca:active , .udf068219721721cbd2409bd328de2eca:hover { opacity: 1; transition: opacity 250ms; webkit-transition: opacity 250ms; background-color: #D35400; } .udf068219721721cbd2409bd328de2eca .centered-text-area { width: 100%; position: relative; } .udf068219721721cbd2409bd328de2eca .ctaText { border-bottom: 0 solid #fff; color: #ECF0F1; font-size: 16px; font-weight: bold; margin: 0; padding: 0; text-decoration: underline; } .udf068219721721cbd2409bd328de2eca .postTitle { color: #FFFFFF; font-size: 16px; font-weight: 600; margin: 0; padding: 0; width: 100%; } .udf068219721721cbd2409bd328de2eca .ctaButton { background-color: #3498DB!important; color: #ECF0F1; border: none; border-radius: 3px; box-shadow: none; font-size: 14px; font-weight: bold; line-height: 26px; moz-border-radius: 3px; text-align: center; text-decoration: none; text-shadow: none; width: 80px; min-height: 80px; background: url(http://www.devwilliam.com.br/wp-content/plugins/intelly-related-posts/assets/images/simple-arrow.png)no-repeat; position: absolute; right: 0; top: 0; } .udf068219721721cbd2409bd328de2eca:hover .ctaButton { background-color: #E67E22!important; } .udf068219721721cbd2409bd328de2eca .centered-text { display: table; height: 80px; padding-left: 18px; top: 0; } .udf068219721721cbd2409bd328de2eca .udf068219721721cbd2409bd328de2eca-content { display: table-cell; margin: 0; padding: 0; padding-right: 108px; position: relative; vertical-align: middle; width: 100%; } .udf068219721721cbd2409bd328de2eca:after { content: ""; display: block; clear: both; } </style><div class="centered-text-area"><div class="centered-text" style="float: left;"><div class="udf068219721721cbd2409bd328de2eca-content"><span class="ctaText">Post relacionado:</span>  <span class="postTitle">Corrigir charset em páginas PHP</span></div></div></div><div class="ctaButton"></div></a></div>
		try{
			if(!empty($cpf)):
				$sql = 'SELECT id FROM cliente WHERE cpf = ?';
				$stm = $this->conexao->prepare($sql);
				$stm->bindValue(1, $cpf);
				$stm->execute();
				$dados = $stm->fetchAll();

				if(!empty($dados)):
					$retorno = true;
				else:
					$retorno = false;
				endif;
			endif;

			
		}catch(Exception $erro){
			echo 'Erro: ' . $erro->getMessage();
			$retorno = false;
		}

		return $retorno;
	}

	/*
	 * Método para ler os dados da planilha e inserir no banco de dados
	 * @return Valor Inteiro contendo a quantidade de linhas importadas
	 */
	public function insertDados(){

		try{
			$sql = 'INSERT INTO cliente (codigo, nome, cpf, email, celular)VALUES(?, ?, ?, ?, ?)';
			$stm = $this->conexao->prepare($sql);
			
			$linha = 0;
			foreach($this->planilha->rows() as $chave => $valor):
				if ($chave >= 1 && !$this->isRegistroDuplicado(trim($valor[2]))):		
					$codigo  = trim($valor[0]);
					$nome    = trim($valor[1]);
					$cpf     = trim($valor[2]);
					$email   = trim($valor[3]);
					$celular = trim($valor[4]);

					$stm->bindValue(1, $codigo);
					$stm->bindValue(2, $nome);
					$stm->bindValue(3, $cpf);
					$stm->bindValue(4, $email);
					$stm->bindValue(5, $celular);
					$retorno = $stm->execute();
					
					if($retorno == true) $linha++;
				 endif;
			endforeach;

			return $linha;
		}catch(Exception $erro){
			echo 'Erro: ' . $erro->getMessage();
		}

	}
}