<?php
/**
 * m2brimagem.class.php
 *
 * Classe para manipulacao de imagens
 *
 * @package    m2brnet admin v2
 * @author     Davi Ferreira <davi.ferreira@m2br.net>
 * @version    0.6a $ 2008-11-14 12:07:13 $
*/

class image {

  // arquivos
  private $origem, $img;
  // dimensoes
  private $largura, $altura, $nova_largura, $nova_altura, $tamanho_html;
  // dados do arquivo
  private $formato, $extensao, $tamanho, $arquivo, $diretorio;
  // extensoes validas
  private $extensoes_validas;
  // cor de fundo para preenchimento
  private $rgb;
  // mensagem de erro
  private $erro;

  /**
   * Construtor
   * @param $string caminho da imagem a ser carregada
   * @return void
  */
  public function __construct($origem = '', $extensoes_validas = array('jpg', 'jpeg', 'jpe', 'gif', 'bmp', 'png'))
  {

    $this->origem					= $origem;
    $this->img						= '';
    $this->largura					= 0;
    $this->altura					= 0;
    $this->nova_largura				= 0;
    $this->nova_altura				= 0;
    $this->formato					= 0;
    $this->extensao					= '';
    $this->tamanho					= '';
    $this->extensoes_validas		= $extensoes_validas;
    $this->arquivo					= '';
    $this->diretorio				= '';
    $this->rgb						= array(255, 255, 255);
    $this->tamanho_html				= '';

    if ($this->origem) {
      $this->dados();
    }

  } // fim construtor

  /**
   * Retorna dados da imagem
   * @param
   * @return void
  */
  private function dados()
  {
    // mensagem padrao, sem erro
    $this->erro = null;
    // verifica se imagem existe
    if (!is_file($this->origem)) {
         $this->erro = 'Erro: Arquivo de imagem nao encontrado!';
    } else {
      // dados do arquivo
      $this->dadosArquivo();
      // verifica se e imagem
      if (!$this->eImagem()) {
        $this->erro = 'Erro: Arquivo '.$this->origem.' nao e uma imagem!';
      } else {
        // pega dimensoes
        $this->dimensoes();
        // cria imagem para php
        $this->criaImagem();
      }
    }
  } // fim dadosImagem

  /**
   * Retorna validacao da imagem
   * @param
   * @return String string com erro de mensagem ou 'OK' para imagem valida
  */
  public function valida()
  {
    return $this->erro;
  } // fim valida

  /**
   * Carrega uma nova imagem, fora do construtor
   * @param String caminho da imagem a ser carregada
   * @return void
  */
  public function carrega($origem='')
  {
    $this->origem			= $origem;
    $this->dados();
  } // fim carrega

//------------------------------------------------------------------------------
// dados da imagem

  /**
   * Busca dimensoes e formato real da imagem
   * @param
   * @return void
  */
  private function dimensoes()
  {
    $dimensoes 				= getimagesize($this->origem);
    $this->largura 	 		= $dimensoes[0];
    $this->altura	 		= $dimensoes[1];
    // 1 = gif, 2 = jpeg, 3 = png, 6 = BMP
    // http://br2.php.net/manual/en/function.exif-imagetype.php
    $this->formato			= $dimensoes[2];
    $this->tamanho_html		= $dimensoes[3];
  } // fim dimensoes

  /**
   * Retorna extensao do arquivo
   * @param
   * @return string
  */
  public function getExtensao()
  {
    return $this->extensao;
  }

  /**
   * Busca dados do arquivo
   * @param
   * @return void
  */
  private function dadosArquivo()
  {
    // imagem de origem
    $pathinfo 			= pathinfo($this->origem);
    $this->extensao 	= strtolower($pathinfo['extension']);
    $this->arquivo		= $pathinfo['basename'];
    $this->diretorio	= $pathinfo['dirname'];
    $this->tamanho		= filesize($this->origem);
  } // fim dadosArquivo

  /**
   * Verifica se o arquivo indicado e uma imagem
   * @param
   * @return Boolean true/false
  */
  private function eImagem()
  {
    // filtra extensao
    if (!in_array($this->extensao, $this->extensoes_validas)) {
      return false;
    } else {
      return true;
    }
  } // fim validaImagem

//------------------------------------------------------------------------------
// manipulacao da imagem

  /**
   * Cria objeto de imagem para manipulacao no GD
   * @param
   * @return void
  */
    private function criaImagem()
    {
        switch ($this->formato) {
        case 1:
          $this->img = imagecreatefromgif($this->origem);
          $this->extensao = 'gif';
            break;
        case 2:
          $this->img = imagecreatefromjpeg($this->origem);
          $this->extensao = 'jpg';
            break;
        case 3:
          $this->img = imagecreatefrompng($this->origem);
          $this->extensao = 'png';
            break;
        case 6:
          $this->img = $this->imagecreatefrombmp($this->origem);
          $this->extensao = 'bmp';
            break;
        default:
            trigger_error('Arquivo invalido!', E_USER_WARNING);
            break;
    }
  } // fim criaImagem

//------------------------------------------------------------------------------
// funcoes para redimensionamento

  /**
   * Redimensiona imagem
   * @param Int $nova_largura valor em pixels da nova largura da imagem
   * @param Int $nova_altura valor em pixels da nova altura da imagem
   * @param String $tipo metodo para redimensionamento (padrao [vazio], 'fill' [preenchimento] ou 'crop')
   * @return Boolean/void
  */
  public function redimensiona($nova_largura = 0, $nova_altura = 0, $tipo = '', $rgb = array(255,255,255))
  {
    // seta variaveis passadas via parametro
    $this->nova_largura		= $nova_largura;
    $this->nova_altura		= $nova_altura;
    $this->rgb				= $rgb;
    // define se so passou nova largura ou altura
    if (!$this->nova_largura && !$this->nova_altura) {
      return false;
    } else if (!$this->nova_largura) { // so passou altura
      $this->nova_largura = $this->largura / ($this->altura/$this->nova_altura);
    } elseif (!$this->nova_altura) { // so passou largura
      $this->nova_altura = $this->altura / ($this->largura/$this->nova_largura);
    }
    // redimensiona de acordo com tipo
    if ('crop'==$tipo) {
      $this->resizeCrop();
    } else if ('fill'==$tipo) {
      $this->resizeFill();
    } else {
      $this->resize();
    }
    // atualiza dimensoes da imagem
    $this->altura 	= $this->nova_altura;
    $this->largura	= $this->nova_largura;

  } // fim redimensiona

  /**
   * Redimensiona imagem, modo padrao, sem crop ou fill (distorcendo)
   * @param
   * @return void
  */
  private function resize()
  {
    // cria imagem de destino temporaria
    $imgtemp	= imagecreatetruecolor($this->nova_largura, $this->nova_altura);

    imagecopyresampled($imgtemp, $this->img, 0, 0, 0, 0, $this->nova_largura, $this->nova_altura, $this->largura, $this->altura);
    $this->img	= $imgtemp;
  } // fim resize()

  /**
   * Redimensiona imagem sem cropar, proporcionalmente,
   * preenchendo espaco vazio com cor rgb especificada
   * @param
   * @return void
  */
  private function resizeFill()
  {
    // cria imagem de destino temporaria
    $imgtemp	= imagecreatetruecolor($this->nova_largura, $this->nova_altura);
    // adiciona cor de fundo e nova imagem
    $corfundo = imagecolorallocate($imgtemp, $this->rgb[0], $this->rgb[1], $this->rgb[2]);
    imagefill($imgtemp, 0, 0, $corfundo);
    // salva variaveis para centralizacao
    $dif_y = $this->nova_altura;
    $dif_x = $this->nova_largura;
    // verifica altura e largura
    if ($this->largura>$this->altura) {
      $this->nova_altura	= (($this->altura * $this->nova_largura) / $this->largura);
    } else if ($this->largura<=$this->altura) {
      $this->nova_largura	= (($this->largura * $this->nova_altura) / $this->altura);
    }  // fim do if verifica altura largura
    // copia com o novo tamanho, centralizando
    $dif_x = ($dif_x - $this->nova_largura) / 2;
    $dif_y = ($dif_y - $this->nova_altura) / 2;
    imagecopyresampled($imgtemp, $this->img, $dif_x, $dif_y, 0, 0, $this->nova_largura, $this->nova_altura, $this->largura, $this->altura);
    $this->img	= $imgtemp;
  } // fim resizeFill()

  /**
   * Redimensiona imagem, cropando para encaixar no novo tamanho, sem sobras
   * baseado no script original de Noah Winecoff
   * http://www.findmotive.com/2006/12/13/php-crop-image/
   * @return void
  */
  private function resizeCrop()
  {
    // cria imagem de destino temporaria
    $imgtemp	= imagecreatetruecolor($this->nova_largura, $this->nova_altura);
    // media altura/largura
    $hm	= $this->altura / $this->nova_altura;
    $wm	= $this->largura / $this->nova_largura;
    // 50% para calculo do crop
    $h_height = $this->nova_altura / 2;
    $h_width  = $this->nova_largura / 2;
    // largura > altura
    if ($wm>$hm) {
      $adjusted_width 	= $this->largura / $hm;
          $half_width 		= $adjusted_width / 2;
          $int_width 			= $half_width - $h_width;
          imagecopyresampled($imgtemp, $this->img, -$int_width, 0, 0, 0, $adjusted_width, $this->nova_altura, $this->largura, $this->altura);
    } else if (($wm<=$hm)) { // largura <= altura
      $adjusted_height 	= $this->altura / $wm;
      $half_height 		= $adjusted_height / 2;
      $int_height 		= $half_height - $h_height;
      imagecopyresampled($imgtemp, $this->img, 0, -$int_height, 0, 0, $this->nova_largura, $adjusted_height, $this->largura, $this->altura);
    }
    $this->img	= $imgtemp;
  } // fim resizeCrop

//------------------------------------------------------------------------------
// funcoes de manipulacao da imagem

  /**
   * flipa/inverte imagem
   * baseado no script original de Noah Winecoff
   * http://www.php.net/manual/en/ref.image.php#62029
   * @param String $tipo tipo de espelhamento: h - horizontal, v - vertical
   * @return void
  */
  public function flip($tipo = 'h')
  {
    $w = imagesx($this->img);
    $h = imagesy($this->img);
    $imgtemp = imagecreatetruecolor($w, $h);
    // vertical
    if ('v'==$tipo) {
      for ($y = 0; $y < $h; $y++) {
        imagecopy($imgtemp, $this->img, 0, $y, 0, $h - $y - 1, $w, 1);
      }
    }
    // horizontal
    if ('h'==$tipo) {
      for ($x = 0; $x < $w; $x++) {
        imagecopy($imgtemp, $this->img, $x, 0, $w - $x - 1, 0, 1, $h);
      }
    }
    $this->img	= $imgtemp;
  } // fim flip

  /**
   * gira imagem
   * @param Int $graus grau para giro
   * @param Array $rgb cor RGB para preenchimento
   * @return void
  */
  public function girar($graus, $rgb = array(255,255,255))
  {
    $corfundo	= imagecolorallocate($this->img, $rgb[0], $rgb[1], $rgb[2]);
    $this->img	= imagerotate($this->img, $graus, $corfundo);
  } // fim girar

  /**
   * adiciona texto a imagem
   * @param String $texto texto a ser inserido
   * @param Int $tamanho tamanho da fonte
   * @param Int $x posicao x do texto na imagem
   * @param Int $y posicao y do texto na imagem
   * @param Array $rgb cor do texto
   * @param Boolean $truetype true para utilizar fonte truetype, false para fonte do sistema
   * @param String $fonte nome da fonte truetype a ser utilizada
   * @return void
  */
  public function legenda($texto, $tamanho = 10, $x = 0, $y = 0, $rgb = array(255,255,255), $truetype = false, $fonte = '')
  {
    $cortexto = imagecolorallocate($this->img, $rgb[0], $rgb[1], $rgb[2]);
    // truetype ou fonte do sistema?
    if ($truetype===true) {
      imagettftext($this->img, $tamanho, 0, $x, $y, $cortexto, $fonte, $texto);
    } else {
      imagestring($this->img, $tamanho, $x, $y, $texto, $cortexto);
    }
  } // fim legenda

  /**
   * adiciona imagem de marca d'agua
   * @param String $imagem caminho da imagem de marca d'agua
   * @param Int $x posicao x da marca na imagem
   * @param Int $y posicao y da marca na imagem
   * @return Boolean true/false dependendo do resultado da operacao
   * @param Int $alfa valor para transparencia (0-100)
           -> se utilizar alfa, a funcao imagecopymerge nao preserva
          -> o alfa nativo do PNG
   */
    public function marca($imagem, $x = 0, $y = 0, $alfa = 100)
    {
        // cria imagem temporaria para merge
        if ($imagem) {
            $pathinfo = pathinfo($imagem);
          switch (strtolower($pathinfo['extension'])) {
            case 'jpg':
            case 'jpeg':
              $marcadagua = imagecreatefromjpeg($imagem);
                break;
            case 'png':
              $marcadagua = imagecreatefrompng($imagem);
                break;
            case 'gif':
              $marcadagua = imagecreatefromgif($imagem);
                break;
            case 'bmp':
              $marcadagua = $this->imagecreatefrombmp($imagem);
                break;
            default:
              $this->erro = 'Arquivo de marca d\'agua invalido.';
              return false;
            }
        } else {
            return false;
        }
	    // dimensoes
	    $marca_w	= imagesx($marcadagua);
	    $marca_h	= imagesy($marcadagua);
	    // retorna imagens com marca d'�gua
	    if (is_numeric($alfa) && (($alfa > 0) && ($alfa < 100))) {
	      imagecopymerge($this->img, $marcadagua, $x, $y, 0, 0, $marca_w, $marca_h, $alfa);
	    } else {
	      imagecopy($this->img, $marcadagua, $x, $y, 0, 0, $marca_w, $marca_h);
	    }
	    return true;
    } // fim marca

  /**
   * adiciona imagem de marca d'agua, com valores fixos
   * ex: topo_esquerda, topo_direita etc.
   * Implementacao original por Giolvani <inavloig@gmail.com>
   * @param String $imagem caminho da imagem de marca d'�gua
   * @param String $posicao posicao/orientacao fixa da marca d'agua
   *        [topo, meio, baixo] + [esquerda, centro, direita]
   * @param Int $alfa valor para transparencia (0-100)
   * @return void
  */
  public function marcaFixa($imagem, $posicao, $alfa = 100)
  {
    // dimensoes da marca d'agua
    list($marca_w, $marca_h) = getimagesize($imagem);
    // define X e Y para posicionamento
    switch($posicao)
    {
        case 'topo_esquerda':
        $x = 0;
        $y = 0;
            break;
        case 'topo_centro':
        $x = ($this->largura - $marca_w) / 2;
        $y = 0;
            break;
        case 'topo_direita':
        $x = $this->largura - $marca_w;
        $y = 0;
            break;
        case 'meio_esquerda':
        $x = 0;
        $y = ($this->altura / 2) - ($marca_h / 2);
            break;
        case 'meio_centro':
        $x = ($this->largura - $marca_w) / 2;
        $y = ($this->altura / 2) - ($marca_h / 2);
            break;
        case 'meio_direita':
        $x = $this->largura - $marca_w;
        $y = ($this->altura / 2) - ($marca_h / 2);
            break;
        case 'baixo_esquerda':
        $x = 0;
        $y = $this->altura - $marca_h;
            break;
        case 'baixo_centro':
        $x = ($this->largura - $marca_w) / 2;
        $y = $this->altura - $marca_h;
            break;
        case 'baixo_direita':
        $x = $this->largura - $marca_w;
        $y = $this->altura - $marca_h;
            break;
        default:
        return false;
            break;
    } // end switch posicao
    // cria marca
    $this->marca($imagem, $x, $y, $alfa);
  } // fim marcaFixa


//------------------------------------------------------------------------------
// gera imagem de saida

  /**
   * retorna saida para tela ou arquivo
   * @param String $destino caminho e nome do arquivo a serem criados
   * @param Boolean $salvar salva imagem ou nao
   * @param Int $qualidade qualidade da imagem no caso de JPEG (0-100)
   * @return void
  */
  public function grava($destino='', $qualidade=100)
  {
    // dados do arquivo de destino
    if ($destino) {
      $pathinfo 			= pathinfo($destino);
      $dir_destino		= $pathinfo['dirname'];
      $extensaodestino 	= strtolower($pathinfo['extension']);
      // valida diretorio
      if (!is_dir($dir_destino)) {
        $this->erro	= 'Diretorio de destino invalido ou inexistente';
        return false;
      }
    }
    // valida extensao de destino
    if (!isset($extensaodestino)) {
      $extensaodestino = $this->extensao;
    } else {
      if (!in_array($extensaodestino, $this->extensoes_validas)) {
        $this->erro = 'Extensao invalida para o arquivo de destino';
        return false;
      }
    }
    switch($extensaodestino)
    {
        case 'jpg':
        case 'jpeg':
        case 'bmp':
        if ($destino) {
          imagejpeg($this->img, $destino, $qualidade);
        } else {
          header("Content-type: image/jpeg");
          imagejpeg($this->img, NULL, $qualidade);
          imagedestroy($this->img);
          exit;
        }
            break;
        case 'png':
        if ($destino) {
          imagepng($this->img, $destino);
        } else {
          header("Content-type: image/png");
          imagepng($this->img);
          imagedestroy($this->img);
          exit;
        }
            break;
        case 'gif':
        if ($destino) {
          imagegif($this->img, $destino);
        } else {
          header("Content-type: image/gif");
          imagegif($this->img);
          imagedestroy($this->img);
          exit;
        }
            break;
        default:
        return false;
            break;
    }
  } // fim grava


  //------------------------------------------------------------------------------
  // suporte para a manipulacao de arquivos BMP

  /*********************************************/
  /* Function: ImageCreateFromBMP              */
  /* Author:   DHKold                          */
  /* Contact:  admin@dhkold.com                */
  /* Date:     The 15th of June 2005           */
  /* Version:  2.0B                            */
  /*********************************************/

  public function imagecreatefrombmp($filename) {
   //Ouverture du fichier en mode binaire
     if (! $f= fopen($filename, "rb")) return FALSE;
   //1 : Chargement des ent?tes FICHIER
     $file= unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f, 14));
     if ($file['file_type'] != 19778) return FALSE;
   //2 : Chargement des ent?tes BMP
     $bmp = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
           '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
           '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f, 40));
     $bmp['colors'] = pow(2, $bmp['bits_per_pixel']);
     if ($bmp['size_bitmap'] == 0) $bmp['size_bitmap'] = $file['file_size'] - $file['bitmap_offset'];
     $bmp['bytes_per_pixel'] = $bmp['bits_per_pixel']/8;
     $bmp['bytes_per_pixel2'] = ceil($bmp['bytes_per_pixel']);
     $bmp['decal'] = ($bmp['width']*$bmp['bytes_per_pixel']/4);
     $bmp['decal'] -= floor($bmp['width']*$bmp['bytes_per_pixel']/4);
     $bmp['decal'] = 4-(4*$bmp['decal']);
     if ($bmp['decal'] == 4) $bmp['decal'] = 0;
   //3 : Chargement des couleurs de la palette
     $palette = array();
     if ($bmp['colors']<16777216) {
    $palette = unpack('V'.$bmp['colors'], fread($f, $bmp['colors']*4));
     }
   //4 : Cr?ation de l'image
     $img = fread($f, $bmp['size_bitmap']);
     $vide = chr(0);
     $res = imagecreatetruecolor($bmp['width'], $bmp['height']);
     $p = 0;
     $y = $bmp['height']-1;
     while ($y >= 0) {
    $x=0;
    while ($x < $bmp['width']) {
     if ($bmp['bits_per_pixel'] == 24) {
        $color = @unpack("V", substr($img, $p, 3).$vide);
     } else if ($bmp['bits_per_pixel'] == 16) {
      $color = @unpack("n", substr($img, $p, 2));
      $color[1] = $palette[$color[1]+1];
     } else if ($bmp['bits_per_pixel'] == 8) {
      $color = @unpack("n", $vide.substr($img, $p, 1));
      $color[1] = $palette[$color[1]+1];
     } elseif ($bmp['bits_per_pixel'] == 4) {
      $color = @unpack("n", $vide.substr($img, floor($p), 1));
      if (($p*2)%2 == 0) $color[1] = ($color[1] >> 4) ; else $color[1] = ($color[1] & 0x0F);
      $color[1] = $palette[$color[1]+1];
     } else if ($bmp['bits_per_pixel'] == 1) {
      $color = @unpack("n", $vide.substr($img, floor($p), 1));
      if     (($p*8)%8 == 0) $color[1] =  $color[1]        >>7;
      elseif (($p*8)%8 == 1) $color[1] = ($color[1] & 0x40)>>6;
      elseif (($p*8)%8 == 2) $color[1] = ($color[1] & 0x20)>>5;
      elseif (($p*8)%8 == 3) $color[1] = ($color[1] & 0x10)>>4;
      elseif (($p*8)%8 == 4) $color[1] = ($color[1] & 0x8)>>3;
      elseif (($p*8)%8 == 5) $color[1] = ($color[1] & 0x4)>>2;
      elseif (($p*8)%8 == 6) $color[1] = ($color[1] & 0x2)>>1;
      elseif (($p*8)%8 == 7) $color[1] = ($color[1] & 0x1);
      $color[1] = $palette[$color[1]+1];
     }
     else
      return FALSE;
     imagesetpixel($res, $x, $y, $color[1]);
     $x++;
     $p += $bmp['bytes_per_pixel'];
    }
    $y--;
    $p+=$bmp['decal'];
     }
   //Fermeture du fichier
     fclose($f);
   return $res;
  } // fim function image from BMP
  //------------------------------------------------------------------------------
  // fim da classe
}